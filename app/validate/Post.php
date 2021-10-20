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
class Post extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // ModelCreate 模型验证场景定义
    public function sceneModelCreate()
    {
        return $this->append('name', 'require');
    }
}