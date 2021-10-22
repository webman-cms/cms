<?php
/**
 * 导航相关操作 service 类
 */

namespace app\service;

use app\model\Tag as TagModel;
use support\ErrorCode;

class Tag
{
    /**
     * 添加tag
     * @param $data
     * @return array|mixed
     * @throws \exception
     */
    public function addTag($data): array
    {
        try {
            // 增加数据
            $tag = new TagModel();
            foreach ($data as $key => $value) {
                $tag->$key = $value;
            }

            $tag->save();

            return $tag->getData();
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }

    /**
     * 修改tag信息
     * @param $data
     * @return mixed
     * @throws \exception
     */
    public function updateTag($data): array
    {
        // 检查数据是否存在
        check_db_exist('tag', $data['id']);

        $tag = new TagModel();
        foreach ($data as $key => $value) {
            $tag->$key = $value;
        }

        $tag->exists(true)->save();

        return $tag->getData();
    }

    /**
     * 删除Tag信息
     * @param $id
     * @return array
     * @throws \exception
     */
    public function deleteTag($id): array
    {
        // 检查数据是否存在
        check_db_exist('tag', $id);

        TagModel::where('id', '=', $id)->delete();

        return ['id' => $id];
    }

    /**
     * 获取标签列表
     * @param $filterName
     * @param int $pageNumber
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getTagList($filterName, int $pageNumber = 1): array
    {
        $tag = new TagModel();
        if (!empty($filterName)) {
            $tag = $tag->where('name', 'like', "%{$filterName}%");
        }

        // 查询数据，默认查找分页条数为 200 条
        $tagData = $tag->page($pageNumber, 200)->select();

        if (empty($tagData)) {
            return [];
        }

        return $tagData->toArray();
    }
}