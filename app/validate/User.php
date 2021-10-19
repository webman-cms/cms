<?php
/**
 * Teamones
 * User: weijer
 * Date: 2021/4/9
 * Email: <weiwei163@foxmail.com>
 **/

declare (strict_types=1);

namespace app\validate;

use think\Validate;

// 文件名与控制器名称一致
class User extends Validate
{
    //验证规则
    protected $rule = [];

    // GetToken 验证场景定义
    public function sceneGetToken()
    {
        return $this->append('login_name', 'require')
            ->append('password', 'require');
    }

    // RefreshToken 验证场景定义
    public function sceneRefreshToken()
    {
        return $this->append('refresh_token', 'require');
    }

    // GetUserInfo 验证场景定义
    public function sceneGetUserInfo()
    {
        return $this->append('user_id', 'require');
    }
}