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
class Post extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddPost 模型验证场景定义
    public function sceneAddPost()
    {
        return $this->append('post', 'require|array')
            ->append('post.title', 'require|max:128')
            ->append('post.status', 'require|in:draft,publish')
            ->append('post.type', 'require|in:post,page')
            ->append('post.content', 'max:100000') // 限制5万中文字
            ->append('post.category_id', 'require|integer')
            ->append('post.thumb_media_id', 'integer')
            ->append('tag', 'array');
    }

    // UpdatePost 模型验证场景定义
    public function sceneUpdatePost()
    {
        return $this->append('post', 'require|array')
            ->append('post.id', 'require|integer')
            ->append('post.title', 'max:128')
            ->append('post.status', 'in:draft,publish')
            ->append('post.type', 'in:post,page')
            ->append('post.content', 'max:100000') // 限制5万中文字
            ->append('post.category_id', 'integer')
            ->append('post.thumb_media_id', 'integer')
            ->append('tag', 'array');
    }

    // DeletePost 验证场景定义
    public function sceneDeletePost()
    {
        return $this->append('id', 'require');
    }

    // FindOnePost 验证场景定义
    public function sceneFindOnePost()
    {
        return $this->append('id', 'require');
    }

    // GetPostList 验证场景定义
    public function sceneGetPostList()
    {
        return $this->append('page_number', 'require|integer')
            ->append('filter', 'array')
            ->append('filter.title', 'max:128')
            ->append('filter.content', 'max:255')
            ->append('filter.tags', 'max:128')
            ->append('order', 'array');
    }
}