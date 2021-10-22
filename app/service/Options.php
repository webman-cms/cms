<?php
/**
 * 配置相关操作 service 类
 */

namespace app\service;

use app\model\Options as OptionsModel;
use support\ErrorCode;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class Options
{
    /**
     * 检查系统配置字段是否正确
     * @param array $configKey
     * @param $config
     * @return array
     * @throws \exception
     */
    protected function checkConfigFormatBase(array $configKey, $config): array
    {
        $newConfig = [];
        foreach ($configKey as $key) {
            if (!array_key_exists($key, $config)) {
                throw_http_exception("The media service config {$key} is required.", ErrorCode::ConfigParamKeyRequired);
            } else {
                $newConfig[$key] = $config[$key];
            }
        }

        return $newConfig;
    }

    /**
     * 检查媒体服务系统配置字段是否正确
     * @param $config
     * @return array
     * @throws \exception
     */
    protected function checkMediaServiceConfigFormat($config): array
    {
        $configKey = [
            'end_point', // 端点，上传url地址
            'region', // 可用区
            'port', // 端口
            'use_ssl', // bool 是否是 https
            'access_key', // 授权码
            'secret_key', // 密钥
            'bucket', // 存储桶
        ];

        return $this->checkConfigFormatBase($configKey, $config);
    }

    /**
     * 检查备案号系统配置字段是否正确
     * @param $config
     * @return array
     * @throws \exception
     */
    protected function checkBeianNumberConfigFormat($config): array
    {
        $configKey = [
            'record', // ipc备案号
            'url', // 管局指定跳转地址
        ];

        return $this->checkConfigFormatBase($configKey, $config);
    }

    /**
     * 新增配置
     * @param $data
     * @return array
     * @throws \exception
     */
    public function addOptions($data): array
    {
        try {
            // 增加数据
            $options = new OptionsModel();
            foreach ($data as $key => $value) {
                $options->$key = $value;
            }

            $options->save();

            return $options->toArray();
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }

    /**
     * 更新配置
     * - system 系统配置，只允许更改config参数，走指定方法更新
     * - 屏蔽 type 字段
     * @param $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function updateOptions($data): array
    {
        // 获取当前配置类型
        $exitRecordData = OptionsModel::where('id', '=', $data['id'])->field('id,type,code')->find();

        if (empty($exitRecordData)) {
            // 数据记录不存在
            throw_http_exception('Data record does not exist.', ErrorCode::DbNotExist);
        }

        $options = new OptionsModel();
        if ($exitRecordData['type'] === 'system') {
            // 处理系统类型
            $options->id = $data['id'];
            $options->config = call_user_func(array($this, "check" . camelize($exitRecordData['code'] . "ConfigFormat")), $data['config']);
        } else {
            foreach ($data as $key => $value) {
                if ($key !== 'type') {
                    $options->$key = $value;
                }
            }
        }

        $options->exists(true)->save();
        return $options->toArray();
    }


    /**
     * 删除配置，只允许删除 custom 自定义配置
     * @param $id
     * @return array
     * @throws \exception
     */
    public function deleteOptions($id): array
    {
        // 获取当前配置类型
        $type = OptionsModel::where('id', '=', $id)->value('type');

        if (empty($type)) {
            // 数据记录不存在
            throw_http_exception('Data record does not exist.', ErrorCode::DbNotExist);
        }

        if ($type === 'system') {
            // 系统配置不允许删除
            throw_http_exception('Unable to delete system config.', ErrorCode::UnableToDeleteSystemConfig);
        }

        OptionsModel::where('id', '=', $id)->delete();

        return ['id' => $id];
    }

    /**
     * 通过code码查询指定配置
     * @param $code
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getOptionsByCode($code): array
    {
        // 获取当前配置类型
        $optionsConfig = OptionsModel::where('code', '=', $code)->field('config')->find();
        if (!empty($optionsConfig)) {
            $optionsData = $optionsConfig->toArray();
            return $optionsData['config'];
        }
        return [];
    }

    /**
     * 获取存储对象预上传地址，默认20分钟不能超过7天（10080分钟）
     * @param $objectName
     * @param string $bucketName
     * @param int $expiry
     * @return string[]|void
     * @throws \exception
     */
    public function getPresignedPutObjectUrl($objectName, string $bucketName = '', $expiry = 20)
    {
        try {
            // 获取对象存储配置
            $mediaServerConfig = $this->getOptionsByCode('media_service');

            if (!empty($mediaServerConfig)) {
                // 初始化 S3 client.
                $endPointHttp = $mediaServerConfig['use_ssl'] ? 'https://' : 'http://';
                $endPointUrl = "{$endPointHttp}{$mediaServerConfig['end_point']}:{$mediaServerConfig['port']}";
                $s3Client = new S3Client([
                    'version' => 'latest',
                    'endpoint' => $endPointUrl,
                    'use_path_style_endpoint' => true,
                    'region' => $mediaServerConfig['region'],
                    'credentials' => [
                        'key' => $mediaServerConfig['access_key'],
                        'secret' => $mediaServerConfig['secret_key'],
                    ],
                ]);

                // 用户为指定存储桶则用默认配置地址
                $bucket = !empty($bucketName) ? $bucketName : $mediaServerConfig['bucket'];
                $cmd = $s3Client->getCommand('putObject', [
                    'Bucket' => $bucket,
                    'Key' => $objectName
                ]);

                if ($expiry > 10080) {
                    throw_http_exception('The expiration time cannot be greater than 7 days.', ErrorCode::ExpiryCanNotGreaterThan7days);
                }

                $request = $s3Client->createPresignedRequest($cmd, "+{$expiry} minutes");

                // 返回预上传地址
                return [
                    "url" => (string)$request->getUri()
                ];
            } else {
                throw_http_exception('The object storage configuration does not exist.', ErrorCode::ObjectStorageConfigNotExist);
            }
        } catch (\Throwable $e) {
            throw_http_exception($e->getMessage(), ErrorCode::GetPresignedPutObjectUrlError);
        }
    }
}