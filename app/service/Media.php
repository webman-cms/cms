<?php
/**
 * 媒体相关操作 service 类
 */

namespace app\service;

use app\model\Media as MediaModel;
use support\ErrorCode;

class Media
{
    /**
     * 添加媒体信息
     * @param $data
     * @return array
     * @throws \exception
     */
    public function addMedia($data): array
    {
        try {
            // 增加数据
            $media = new MediaModel();
            foreach ($data as $key => $value) {
                $media->$key = $value;
            }

            $media->save();

            return $media->getData();
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }

    /**
     * 修改媒体信息
     * @param $data
     * @return mixed
     * @throws \exception
     */
    public function updateMedia($data)
    {
        // 检查数据是否存在
        check_db_exist('media', $data['id']);

        $media = new MediaModel();
        foreach ($data as $key => $value) {
            $media->$key = $value;
        }

        $media->exists(true)->save();

        return $media->getData();
    }

    /**
     * 删除媒体信息
     * @param $id
     * @return array
     * @throws \exception
     */
    public function deleteMedia($id): array
    {
        // 检查数据是否存在
        check_db_exist('media', $id);

        MediaModel::where('id', '=', $id)->delete();

        return ['id' => $id];
    }

    /**
     * 获取媒体列表
     * @param $filterParam
     * @param $orderParam
     * @param int $pageNumber
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMediaList($filterParam, $orderParam, int $pageNumber = 1): array
    {
        // 处理过滤条件参数
        $filterCondition = [
            'create_time' => 'between',
            'type' => 'in',
            'description' => 'like',
            'created_by' => 'in',
        ];
        $filter = [];
        foreach ($filterParam as $field => $param) {
            if (array_key_exists($field, $filterCondition)) {
                switch ($filterCondition[$field]) {
                    case 'between':
                        if ($field === 'create_time') {
                            $timeArray = explode(',', $param);
                            array_walk($timeArray, function (&$val) {
                                $val = strtotime($val);
                            });
                            $param = join(',', $timeArray);
                        }
                        break;
                    case 'like':
                        $param = "%{$param}%";
                        break;
                }

                $filter[] = [$field, $filterCondition[$field], $param];
            }
        }

        $media = new MediaModel();
        if (!empty($filter)) {
            $media = $media->where($filter);
        }

        // 处理排序参数
        if (!empty($orderParam)) {
            $media = $media->order($orderParam);
        }

        // 查询数据，默认查找分页条数为 100 条
        $mediaData = $media->with('user')
            ->page($pageNumber, 100)
            ->select();

        if (empty($mediaData)) {
            return [];
        }

        return $mediaData->toArray();
    }

    /**
     * 获取单个媒体详情
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMediaDetails($id): array
    {
        $mediaData = MediaModel::with('user')
            ->where('id', '=', $id)
            ->find();

        if (empty($mediaData)) {
            return [];
        }

        return $mediaData->toArray();
    }
}