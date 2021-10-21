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
class User extends BaseValidate
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

    // AddUser 验证场景定义
    public function sceneAddUser()
    {
        return $this->append('login_name', 'require|max:36|unique:user')
            ->append('name', 'require|max:128')
            ->append('phone', 'require|max:20|unique:user')
            ->append('password', 'require|max:32') // 限制用户输入密码最大32位
            ->append('sex', 'in:male,female')
            ->append('email', 'max:128|email');
    }

    // UpdateUser 验证场景定义
    public function sceneUpdateUser()
    {
        return $this->append('id', 'require')
            ->append('login_name', 'max:36|unique:user')
            ->append('name', 'max:128')
            ->append('phone', 'max:20|unique:user')
            ->append('password', 'max:32') // 限制用户输入密码最大32位
            ->append('sex', 'in:male,female')
            ->append('email', 'max:128|email');
    }

    // UpdateUser 验证场景定义
    public function sceneDeleteUser()
    {
        return $this->append('id', 'require|gt:1'); // user_id = 1 为超级管理员账户不允许删除
    }
}