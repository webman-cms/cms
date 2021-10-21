<?php

namespace app\model;

use support\Model;

class Options extends Model
{
    /**
     * 序列化config字段
     * @param $value
     * @return string
     */
    public function setConfigAttr($value): string
    {
        return json_encode($value);
    }

    /**
     * 反序列化config字段
     * @param $value
     * @return array
     */
    public function getConfigAttr($value): array
    {
        return json_decode($value, true);
    }
}