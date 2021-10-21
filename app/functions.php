<?php

use support\ErrorCode;
use think\Validate;

/**
 * Here is your custom functions.
 */
if (!function_exists('throw_http_exception')) {
    /**
     * 自定义抛出异常函数
     * @param $msg
     * @param int $code
     * @param array $data
     * @throws exception
     */
    function throw_http_exception($msg, $code = -400000, $data = [])
    {
        $errorData = [
            "code" => $code,
            "msg" => $msg,
            "data" => $data
        ];
        throw new \support\exception\HttpResponseException(json_encode($errorData, JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('validate')) {
    /**
     * 生成验证对象
     * @param string|array $validate 验证器类名或者验证规则数组
     * @param array $message 错误提示信息
     * @param bool $batch 是否批量验证
     * @param bool $failException 是否抛出异常
     * @return Validate
     */
    function validate($validate = '', array $message = [], bool $batch = false, bool $failException = true): Validate
    {
        if (is_array($validate) || '' === $validate) {
            $v = new Validate();
            if (is_array($validate)) {
                $v->rule($validate);
            }
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }

            $class = false !== strpos($validate, '\\') ? $validate : "\\app\\validate\\{$validate}";

            $v = new $class();

            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        return $v->message($message)->batch($batch)->failException($failException);
    }
}

if (!function_exists('create_pass')) {
    /**
     * 加密密码
     * @param string $password
     * @return bool|string
     */
    function create_pass($password = "")
    {
        if (!empty($password)) {
            $options = [
                'cost' => 8,
            ];
            return password_hash($password, PASSWORD_BCRYPT, $options);
        } else {
            return '';
        }
    }
}

if (!function_exists('check_db_exist')) {
    /**
     * 判断数据库记录是否存在
     * @param string $modelName
     * @param int $id
     * @throws exception
     */
    function check_db_exist(string $modelName, int $id)
    {
        if (false !== strpos($modelName, '\\')) {
            $class = $modelName;
        } else {
            $modelName = ucfirst($modelName);
            $class = "\\app\\model\\{$modelName}";
        }

        $existId = $class::where('id', '=', $id)->value('id');

        if (empty($existId)) {
            throw_http_exception('Data record does not exist.', ErrorCode::DbNotExist);
        }
    }
}