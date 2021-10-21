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
class Media extends BaseValidate
{
    //验证规则
    protected $rule = [];


    // AddMedia 验证场景定义
    public function sceneAddMedia()
    {
        return $this->append('type', 'require|in:image,video,audio,file')
            ->append('path', 'require|max:255')
            ->append('size', 'max:32');
    }

    // UpdateMedia 验证场景定义
    public function sceneUpdateMedia()
    {
        return $this->append('id', 'require')
            ->append('type', 'in:image,video,audio,file')
            ->append('path', 'max:255')
            ->append('size', 'max:32');
    }

    // DeleteMedia 验证场景定义
    public function sceneDeleteMedia()
    {
        return $this->append('id', 'require');
    }

    // GetMediaList 验证场景定义
    public function sceneGetMediaList()
    {
        return $this->append('page_number', 'require|integer')
            ->append('filter', 'array')
            ->append('order', 'array');
    }

    // GetMediaDetails 验证场景定义
    public function sceneGetMediaDetails()
    {
        return $this->append('id', 'require');
    }
}