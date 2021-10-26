<?php

namespace app\model;

use support\Model;

class Post extends Model
{
    /**
     * 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
     * @var bool|string
     */
    protected $autoWriteTimestamp = true;

    /**
     * 创建时间字段 false表示关闭
     * @var false|string
     */
    protected $createTime = 'create_time';

    /**
     * 更新时间字段 false表示关闭
     * @var false|string
     */
    protected $updateTime = 'update_time';

    // belongsTo user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->bind(['user_name' => 'name']);
    }

    // belongsTo media
    public function media()
    {
        return $this->belongsTo(Media::class, 'thumb_media_id');
    }

    // belongsTo category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // 多对多关联 belongsToMany
    public function tag()
    {
        return $this->belongsToMany(Tag::class, PostTag::class);
    }
}