<?php
/**
 * 文章相关操作 service 类
 */

namespace app\service;

use app\model\Post as PostModel;

class Post
{
    /**
     * 创建目录
     * @param $data
     * @return PostModel|\think\Model
     */
    public function create($data)
    {
        return PostModel::create($data);
    }
}
