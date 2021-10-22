<?php

namespace app\controller;

use support\Request;
use app\service\Category as CategoryService;
use support\Response;

class Category
{
    /**
     * @var CategoryService
     */
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * 添加分类
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addCategory(Request $request): Response
    {
        $param = $request->all();
        $res = $this->categoryService->addCategory($param);
        return json(success_response('', $res));
    }

    /**
     * 更新分类
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateCategory(Request $request): Response
    {
        $param = $request->all();
        $res = $this->categoryService->updateCategory($param);
        return json(success_response('', $res));
    }

    /**
     * 删除分类
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteCategory(Request $request): Response
    {
        $param = $request->all();
        $res = $this->categoryService->deleteCategory($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 获取分类树列表
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryTreeList(Request $request): Response
    {
        $param = $request->all();
        $filterName = $param['filter']['name'] ?? '';

        $res = $this->categoryService->getCategoryTreeList($filterName, $param['page_number']);
        return json(success_response('', $res));
    }
}