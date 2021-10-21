<?php

namespace app\model;

use support\Model;

class Media extends Model
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
    protected $updateTime = false;

    // belongsTo user
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')
            ->bind(['create_by_name'=>'name']);
    }
}