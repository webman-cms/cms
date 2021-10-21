<?php

namespace app\controller;

use support\Request;
use app\service\Nav as NavService;
use support\Response;

class Nav
{
    /**
     * @var NavService
     */
    private NavService $navService;

    public function __construct(NavService $navService)
    {
        $this->navService = $navService;
    }

    /**
     * 添加导航
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addNav(Request $request): Response
    {
        $param = $request->all();
        $res = $this->navService->addNav($param);
        return json(success_response('', $res));
    }

    /**
     * 更新导航
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateNav(Request $request): Response
    {
        $param = $request->all();
        $res = $this->navService->updateNav($param);
        return json(success_response('', $res));
    }

    /**
     * 删除导航
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteNav(Request $request): Response
    {
        $param = $request->all();
        $res = $this->navService->deleteNav($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 删除导航排序
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateNavIndexSort(Request $request): Response
    {
        $param = $request->all();
        $res = $this->navService->updateNavIndexSort($param);
        return json(success_response('', $res));
    }

    /**
     * 获取导航树
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function getNavTree(Request $request): Response
    {
        $param = $request->all();
        $res = $this->navService->getNavTree($param);
        return json(success_response('', $res));
    }
}