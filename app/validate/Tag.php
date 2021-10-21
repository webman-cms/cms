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
class Tag extends BaseValidate
{
    //验证规则
    protected $rule = [];

    // AddTag 验证场景定义
    public function sceneAddTag()
    {
        return $this->append('name', 'require|max:255|unique:tag');
    }

    // UpdateTag 验证场景定义
    public function sceneUpdateTag()
    {
        return $this->append('id', 'require')
            ->append('name', 'require|max:255|unique:tag');
    }

    // DeleteTag 验证场景定义
    public function sceneDeleteTag()
    {
        return $this->append('id', 'require');
    }

    // GetTagList 验证场景定义
    public function sceneGetTagList()
    {
        return $this->append('page_number', 'require|integer');
    }
}