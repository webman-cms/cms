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
class Category extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddCategory 验证场景定义
    public function sceneAddCategory()
    {
        return $this->append('name', 'require|max:24|unique:category')
            ->append('code', 'require|alphaDash|max:24|unique:category')
            ->append('parent_id', 'integer');
    }

    // UpdateCategory 验证场景定义
    public function sceneUpdateCategory()
    {
        return $this->append('id', 'require')
            ->append('name', 'max:24|unique:category')
            ->append('code', 'alphaDash|max:24|unique:category')
            ->append('parent_id', 'integer');
    }

    // DeleteCategory 验证场景定义
    public function sceneDeleteCategory()
    {
        return $this->append('id', 'require');
    }

    // GetCategoryTreeList 验证场景定义
    public function sceneGetCategoryTreeList()
    {
        return $this->append('page_number', 'require|integer');
    }
}