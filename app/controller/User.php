<?php

namespace app\controller;

use support\ErrorCode;
use support\Request;
use support\Response;
use app\service\User as UserService;

class User
{

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 获取令牌
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getToken(Request $request): Response
    {
        $param = $request->all();
        $clientIp = $request->getRealIp();
        $res = $this->userService->getToken($param['login_name'], $param['password'], $clientIp);
        return json(success_response('', $res));
    }

    /**
     * 刷新令牌
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function refreshToken(Request $request): Response
    {
        $param = $request->all();
        $clientIp = $request->getRealIp();
        $res = $this->userService->refreshToken($param['refresh_token'], $clientIp);
        return json(success_response('', $res));
    }

    /**
     * 获取指定用户信息
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserInfo(Request $request): Response
    {
        $param = $request->all();
        $res = $this->userService->getUserInfo($param['user_id']);
        return json(success_response('', $res));
    }

    /**
     * 新增用户
     * @param Request $request
     * @return Response
     */
    public function addUser(Request $request): Response
    {
        $param = $request->all();
        $res = $this->userService->addUser([
            'login_name' => $param['login_name'],
            'name' => $param['name'],
            'phone' => $param['phone'],
            'password' => $param['password'],
            'sex' => $param['sex'] ?? 'male',
            'email' => $param['email'] ?? '',
        ]);
        return json(success_response('', $res));
    }

    /**
     * 修改用户信息
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateUser(Request $request): Response
    {
        $param = $request->all();
        $hasUpdateValue = false;

        foreach (['login_name', 'name', 'phone', 'password', 'sex', 'email'] as $field) {
            // 至少有一个字段需要更新
            if (!empty($param[$field])) {
                // 如果为超级管理员账户只允许修改password
                if ($param['id'] === 1 && $field !== 'password') {
                    throw_http_exception('Only the administrator password can be modified.', ErrorCode::OnlyAdminPasswordCanBeModified);
                }
                $hasUpdateValue = true;
                break;
            }
        }

        if ($hasUpdateValue) {
            $res = $this->userService->modifyUser($param);
            return json(success_response('', $res));
        } else {
            throw_http_exception('There is no info to modify.', ErrorCode::NoInfoToModify);
        }
    }

    /**
     * 删除指定用户
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteUser(Request $request): Response
    {
        $param = $request->all();
        $res = $this->userService->deleteUser($param['id']);
        return json(success_response('', $res));
    }
}
