<?php

namespace app\controller;

use support\Request;
use app\service\Tag as TagService;
use support\Response;

class Tag
{
    /**
     * @var TagService
     */
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * 添加标签
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addTag(Request $request): Response
    {
        $param = $request->all();
        $res = $this->tagService->addTag($param);
        return json(success_response('', $res));
    }

    /**
     * 更新标签
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateTag(Request $request): Response
    {
        $param = $request->all();
        $res = $this->tagService->updateTag($param);
        return json(success_response('', $res));
    }

    /**
     * 删除标签
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteTag(Request $request): Response
    {
        $param = $request->all();
        $res = $this->tagService->deleteTag($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 获取标签列表
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getTagList(Request $request): Response
    {
        $param = $request->all();
        $filterName = $param['filter']['name'] ?? '';

        $res = $this->tagService->getTagList($filterName, $param['page_number']);
        return json(success_response('', $res));
    }
}