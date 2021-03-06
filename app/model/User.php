<?php

namespace app\model;

use support\Model;

class User extends Model
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
    protected $updateTime = 'last_visit_time';


    // belongsTo media
    public function media()
    {
        return $this->belongsTo(Media::class, 'avatar_media_id');
    }

    /**
     * 加密密码字符串
     * @param $value
     * @return string
     */
    public function setPasswordAttr($value): string
    {
        return create_pass($value);
    }
}