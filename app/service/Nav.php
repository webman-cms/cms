<?php
/**
 * 导航相关操作 service 类
 */

namespace app\service;

use app\model\Nav as NavModel;
use support\ErrorCode;
use support\Tree;

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
        if (!empty($data['parent_id'])) {
            check_db_exist('nav', $data['parent_id']);
        }

        if (empty($data['index'])) {
            // 如果没有排序就给一个最大值
            $data['index'] = 99999;
        }

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


    /**
     * 修改导航信息
     * @param $data
     * @return array
     * @throws \exception
     */
    public function updateNav($data): array
    {
        // 检查数据是否存在
        check_db_exist('nav', $data['id']);

        //如果parent_id不为空检测是否是合法的
        if (!empty($data['parent_id'])) {
            check_db_exist('nav', $data['parent_id']);
        }

        $nav = new NavModel();
        foreach ($data as $key => $value) {
            $nav->$key = $value;
        }

        $nav->exists(true)->save();

        return $nav->getData();
    }

    /**
     * 删除导航
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function deleteNav($id): array
    {
        // 如果删除项下面有子集则把子集第一层 parent_id 改为 0
        $childParentIdData = NavModel::field('id')->where('parent_id', '=', $id)->select();
        $childParentIdArray = $childParentIdData->toArray();
        if (!empty($childParentIdArray)) {
            $childParentIds = array_column($childParentIdArray, 'id');

            NavModel::where('id', 'in', $childParentIds)->save(['parent_id' => 0]);
        }

        // 批量删除子集分类
        NavModel::where('id', '=', $id)->delete();

        return ['id' => $id];
    }

    /**
     * 获取导航树列表
     * @param $filterName
     * @param int $pageNumber
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNavTreeList($filterName, int $pageNumber = 1): array
    {
        $nav = new NavModel();
        if (!empty($filterName)) {
            $nav = $nav->where('name', 'like', "%{$filterName}%");
        }

        // 查询数据，默认查找分页条数为 200 条
        $navData = $nav->page($pageNumber, 200)->order('index', 'asc')->select();

        if (empty($navData)) {
            return [];
        }

        // 生成树列表
        $navArray = $navData->toArray();
        if (!empty($navArray)) {
            $tree = new Tree("id", "parent_id");
            $tree->load($navArray);
            $navTree = $tree->DeepTree();
            if ($navTree !== false) {
                return $navTree;
            }
        }
        return [];
    }

    /**
     * 更新导航排序
     * @param array $data
     * @return array
     * @throws \exception
     */
    public function updateNavIndexSort(array $data): array
    {
        $navModel = new NavModel();
        $navModel->startTrans();
        try {
            foreach ($data as $item) {
                if (array_key_exists('id', $item) && array_key_exists('index', $item)) {
                    $navModel->where('id', '=', $item['id'])->save(['index' => $item['index']]);
                } else {
                    throw new \Exception('Id and index fields do not exist.');
                }
            }
            $navModel->commit();
        } catch (\Throwable $e) {
            $navModel->rollback();
            throw_http_exception($e->getMessage(), ErrorCode::UpdateNavIndexSortError);
        }

        return $data;
    }
}