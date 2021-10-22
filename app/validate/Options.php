<?php
/**
 * Teamones
 * User: weijer
 * Date: 2021/4/9
 * Email: <weiwei163@foxmail.com>
 **/

declare (strict_types=1);

namespace app\validate;

// 文件名与控制器名称一致
class Options extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddOptions 验证场景定义
    public function sceneAddOptions()
    {
        return $this->append('name', 'require|max:128')
            ->append('code', 'require|max:128|unique:options')
            ->append('config', 'require|array')
            ->append('type', 'eq:custom');
    }

    // UpdateOptions 验证场景定义
    public function sceneUpdateOptions()
    {
        return $this->append('id', 'require')
            ->append('name', 'max:128')
            ->append('code', 'max:128|unique:options')
            ->append('config', 'array');
    }

    // DeleteOptions 验证场景定义
    public function sceneDeleteOptions()
    {
        return $this->append('id', 'require');
    }

    // GetOptionsByCode 验证场景定义
    public function sceneGetOptionsByCode()
    {
        return $this->append('code', 'require');
    }

    // GetPresignedPutObjectUrl 验证场景定义
    public function sceneGetPresignedPutObjectUrl()
    {
        return $this->append('object_name', 'require');
    }
}