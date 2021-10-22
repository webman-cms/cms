<?php
/**
 * 分类相关操作 service 类
 */

namespace app\service;

use app\model\Category as CategoryModel;
use support\ErrorCode;
use support\Tree;

class Category
{
    /**
     * 获取指定父级下面所有子级id
     * @param $ids
     * @param int $rootId
     */
    protected function getAllChildById(&$ids, int $rootId)
    {
        if ($rootId > 0) {

        }
        return $ids;
    }

    /**
     * 添加分类
     * @param $data
     * @return array|mixed
     * @throws \exception
     */
    public function addCategory($data): array
    {
        if (!empty($data['parent_id'])) {
            check_db_exist('category', $data['parent_id']);
        }

        try {
            // 增加数据
            $category = new CategoryModel();
            foreach ($data as $key => $value) {
                $category->$key = $value;
            }

            $category->save();

            return $category->getData();
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }

    /**
     * 修改分类信息
     * @param $data
     * @return mixed
     * @throws \exception
     */
    public function updateCategory($data): array
    {
        // 检查数据是否存在
        check_db_exist('category', $data['id']);

        //如果parent_id不为空检测是否是合法的
        if (!empty($data['parent_id'])) {
            check_db_exist('category', $data['parent_id']);
        }

        $category = new CategoryModel();
        foreach ($data as $key => $value) {
            $category->$key = $value;
        }

        $category->exists(true)->save();

        return $category->getData();
    }

    /**
     * 删除分类信息
     * @param $id
     * @return array
     * @throws \exception
     */
    public function deleteCategory($id): array
    {
        // 检查数据是否存在
        check_db_exist('category', $id);

        // 如果是父级则连同子集一起删除


        CategoryModel::where('id', '=', $id)->delete();

        return ['id' => $id];
    }

    /**
     * 获取分类树列表
     * @param $filterName
     * @param int $pageNumber
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryTreeList($filterName, int $pageNumber = 1): array
    {
        $category = new CategoryModel();
        if (!empty($filterName)) {
            $category = $category->where('name', 'like', "%{$filterName}%");
        }

        // 查询数据，默认查找分页条数为 200 条
        $categoryData = $category->page($pageNumber, 200)->select();

        if (empty($categoryData)) {
            return [];
        }

        // 生成树列表
        $categoryArray = $categoryData->toArray();
        if (!empty($categoryArray)) {
            $tree = new Tree("id", "parent_id");
            $tree->load($categoryArray);
            $categoryTree = $tree->DeepTree();
            if ($categoryTree !== false) {
                return $categoryTree;
            }
        }
        return [];
    }
}