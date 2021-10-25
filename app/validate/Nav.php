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
class Nav extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddNav 验证场景定义
    public function sceneAddNav()
    {
        return $this->append('name', 'require|max:24')
            ->append('type', 'require|in:post,page,link,category')
            ->append('url', 'requireIf:type,link|url|max:255')
            ->append('parent_id', 'integer')
            ->append('link_id', 'requireIfNot:type,link|integer');
    }

    // UpdateNav 验证场景定义
    public function sceneUpdateNav()
    {
        return $this->append('id', 'require')
            ->append('name', 'max:24')
            ->append('type', 'in:post,page,link,category')
            ->append('url', 'url|max:255')
            ->append('parent_id', 'integer')
            ->append('link_id', 'integer');
    }

    // DeleteNav 验证场景定义
    public function sceneDeleteNav()
    {
        return $this->append('id', 'require');
    }

    // GetNavTreeList 验证场景定义
    public function sceneGetNavTreeList()
    {
        return $this->append('page_number', 'require|integer');
    }

    // UpdateNavIndexSort 验证场景定义
    public function sceneUpdateNavIndexSort()
    {
        return $this->append('data', 'require|array');
    }
}