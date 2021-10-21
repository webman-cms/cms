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
class Nav extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddNav 验证场景定义
    public function sceneAddNav()
    {
        return $this->append('name', 'require|max:255|unique:tag');
    }
}