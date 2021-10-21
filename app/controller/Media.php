<?php

namespace app\controller;

use support\Request;
use app\service\Media as MediaService;
use support\Response;

class Media
{

    /**
     * @var MediaService
     */
    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * 新增媒体
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addMedia(Request $request): Response
    {
        $param = $request->all();
        // 增加创建者用户id
        $param['created_by'] = $request->currentUserId;
        $res = $this->mediaService->addMedia($param);
        return json(success_response('', $res));
    }

    /**
     * 替换指定媒体
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updateMedia(Request $request): Response
    {
        $param = $request->all();
        // 增加创建者用户id
        $param['created_by'] = $request->currentUserId;
        $res = $this->mediaService->updateMedia($param);
        return json(success_response('', $res));
    }

    /**
     * 删除指定媒体
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteMedia(Request $request): Response
    {
        $param = $request->all();
        $res = $this->mediaService->deleteMedia($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 获取媒体列表
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMediaList(Request $request): Response
    {
        /**
         * 支持按时间排序、过滤
         * 支持按类型过滤
         * 支持按创建者过滤
         * 支持按描述过滤
         *
         * 默认每次查询条数 100 条，不返回总条数，请客户端自行处理滚动加载分页！
         *
         */

        // 请求参数示例
//        [
//            "filter"=> [
//                "create_time"=> "2021-10-20,2021-10-21",
//                "type"=> "image,video,audio,file",
//                "description"=> "图片",
//                "created_by"=> "1,2"
//            ],
//            "order"=> [
//                "create_time"=> "asc"
//            ],
//            "page_number" => 1
//        ]

        $param = $request->all();

        $filter = $param['filter'] ?? [];
        $order = $param['order'] ?? [];

        $res = $this->mediaService->getMediaList($filter, $order, $param['page_number']);
        return json(success_response('', $res));
    }


    /**
     * 获取单个媒体详情
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMediaDetails(Request $request): Response
    {
        $param = $request->all();
        $res = $this->mediaService->getMediaDetails($param['id']);
        return json(success_response('', $res));
    }
}
