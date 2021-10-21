<?php
/**
 * 导航相关操作 service 类
 */

namespace app\service;

use app\model\Nav as NavModel;
use support\ErrorCode;

class Nav
{
    /**
     * 添加导航
     * @param $data
     * @return array|mixed
     * @throws \exception
     */
    public function addNav($data): array
    {
        try {
            // 增加数据
            $nav = new NavModel();
            foreach ($data as $key => $value) {
                $nav->$key = $value;
            }

            $nav->save();

            return $nav->getData();
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }
}