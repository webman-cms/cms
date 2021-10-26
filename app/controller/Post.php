<?php

namespace app\controller;

use app\service\Post as PostService;
use support\ErrorCode;
use support\Request;
use support\Response;

class Post
{
    /**
     * @var PostService
     */
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * 添加文章
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addPost(Request $request): Response
    {
        $param = $request->all();
        // 增加创建者用户id
        $param['post']['user_id'] = $request->currentUserId;
        $tagData = [];
        if (!empty($param['tag'])) {
            // 验证tag是否符合数据规范
            foreach ($param['tag'] as $item) {
                if ((!is_array($item)) || (!array_key_exists('name', $item))) {
                    throw_http_exception('Tag name attribute does not exist.', ErrorCode::TagNameAttNotExist);
                }
            }
            $tagData = $param['tag'];
        }
        $res = $this->postService->addPost($param['post'], $tagData);
        return json(success_response('', $res));
    }

    /**
     * 更新文章
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function updatePost(Request $request): Response
    {
        $param = $request->all();
        $tagData = [];
        if (!empty($param['tag'])) {
            // 验证tag是否符合数据规范
            foreach ($param['tag'] as $item) {
                if ((!is_array($item)) || (!array_key_exists('name', $item))) {
                    throw_http_exception('Tag name attribute does not exist.', ErrorCode::TagNameAttNotExist);
                }
            }
            $tagData = $param['tag'];
        }
        $res = $this->postService->updatePost($param['post'], $tagData);
        return json(success_response('', $res));
    }


    /**
     * 删除文章
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deletePost(Request $request): Response
    {
        $param = $request->all();
        $res = $this->postService->deletePost($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 查询指定文章数据
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function findOnePost(Request $request): Response
    {
        $param = $request->all();
        $res = $this->postService->findOnePost($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 获取文章列表
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function getPostList(Request $request): Response
    {
        /**
         * 支持文章标题过滤
         * 支持文章内容过滤
         * 支持文章类型过滤 draft：草稿，publish：已发布
         * 支持按类型过滤 post 文章，page 页面
         * 支持按创建者过滤
         * 支持按分类过滤
         * 支持按创建、更新时间排序、过滤
         * 支持按文章标签过滤
         *
         * 默认每次查询条数 100 条，不返回总条数，请客户端自行处理滚动加载分页！
         *
         */

        // 请求参数示例
//        $filter = [
//            "filter" => [
//                "title" => "文章标题",
//                "content" => "文章内容",
//                "status" => "draft,publish",
//                "type" => "post,page",
//                "user_id" => "1,2",
//                "category_id" => "1,2",
//                "create_time" => "2021-10-20,2021-10-21",
//                "update_time" => "2021-10-20,2021-10-21",
//                "tags" => "tag1,tag2,tag3"
//            ],
//            "order" => [
//                "create_time" => "asc"
//            ],
//            "page_number" => 1
//        ];

        $param = $request->all();

        $filter = $param['filter'] ?? [];
        $order = $param['order'] ?? [];

        $res = $this->postService->getPostList($filter, $order, $param['page_number']);
        return json(success_response('', $res));
    }
}
