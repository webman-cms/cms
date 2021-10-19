<?php

namespace app\controller;

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
     * 新增用户
     * @param Request $request
     * @return Response
     */
    public function addUser(Request $request): Response
    {
        $param = $request->all();
        $res = $this->userService->addUser($param);
        return json(success_response('', $res));
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
     */
    public function refreshToken(Request $request)
    {

    }

    /**
     * 获取指定用户信息
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserInfo(Request $request)
    {
        $param = $request->all();
        $res = $this->userService->getUserInfo($param['user_id']);
        return json(success_response('', $res));
    }
}
