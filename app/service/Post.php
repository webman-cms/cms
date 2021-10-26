<?php
/**
 * 文章相关操作 service 类
 */

namespace app\service;

use app\model\Post as PostModel;
use app\model\PostTag;
use app\model\Tag as TagModel;
use support\ErrorCode;

class Post
{

    /**
     * 处理已存在标签保存数据
     * @param array $tagData
     * @param array $existPostTags
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function checkTagExist(array $tagData = [], array $existPostTags = []): array
    {
        $tagNames = array_column($tagData, 'name');
        $tagExistNameObj = TagModel::field('id,name')->where('name', 'in', $tagNames)->select();

        if (empty($tagExistNameObj)) {
            return $tagData;
        }

        $tagExistNameData = $tagExistNameObj->toArray();
        $tagExistNameDict = array_column($tagExistNameData, 'id', 'name');
        $addTagData = [];
        $deleteTagData = [];
        if (!empty($existPostTags)) {
            foreach ($existPostTags as $existPostTagItem) {
                if (!in_array($existPostTagItem['name'], $tagNames)) {
                    $deleteTagData[] = $existPostTagItem['id'];
                }
            }

            $existPostTagsNames = array_column($existPostTags, 'name');
            foreach ($tagData as $tagItem) {
                if (array_key_exists($tagItem['name'], $tagExistNameDict)) {
                    if (!in_array($tagItem['name'], $existPostTagsNames)) {
                        $addTagData[] = $tagExistNameDict[$tagItem['name']];
                    }
                } else {
                    $addTagData[] = $tagItem;
                }
            }
        } else {
            foreach ($tagData as $tagItem) {
                if (array_key_exists($tagItem['name'], $tagExistNameDict)) {
                    $addTagData[] = $tagExistNameDict[$tagItem['name']];
                } else {
                    $addTagData[] = $tagItem;
                }
            }
        }

        return [
            'add' => $addTagData,
            'delete' => $deleteTagData
        ];
    }

    /**
     * 查询指定文章数据
     * @param int $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function findOnePost(int $id): array
    {
        $data = PostModel::with(['category', 'media', 'user', 'tag'])
            ->find($id);

        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * 创建文章
     * @param $userData
     * @param array $tagData
     * @return array
     * @throws \exception
     */
    public function addPost($userData, array $tagData = []): array
    {
        try {
            // 增加数据
            $post = new PostModel();
            foreach ($userData as $key => $value) {
                $post->$key = $value;
            }

            $post->save();

            // 批量新增tags
            if (!empty($tagData)) {
                $saveTagData = $this->checkTagExist($tagData);
                if (!empty($saveTagData['add'])) {
                    $post->tag()->saveAll($saveTagData['add']);
                }
            }

            return $this->findOnePost($post->getData('id'));

        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddOptionsError);
        }
        return [];
    }

    /**
     * 更新文章
     * @param $userData
     * @param array $tagData
     * @return array
     * @throws \exception
     */
    public function updatePost($userData, array $tagData = []): array
    {
        // 检查数据是否存在
        $existPostData = $this->findOnePost($userData['id']);
        if (empty($existPostData)) {
            throw_http_exception("Data id={$userData['id']} record does not exist.", ErrorCode::DbNotExist);
        }

        try {
            $post = new PostModel();
            foreach ($userData as $key => $value) {
                $post->$key = $value;
            }

            $post->exists(true)->save();
            // 批量新增tags
            if (!empty($tagData)) {
                $existPostTags = $existPostData['tag'] ?? [];
                $saveTagData = $this->checkTagExist($tagData, $existPostTags);

                // 需要删除的tag
                if (!empty($saveTagData['delete'])) {
                    $post->tag()->detach($saveTagData['delete']);
                }

                // 新增的tag
                if (!empty($saveTagData['add'])) {
                    $post->tag()->saveAll($saveTagData['add']);
                }
            }

            return $this->findOnePost($userData['id']);
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelUpdateOptionsError);
        }

        return [];
    }

    /**
     * 删除文章
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function deletePost($id): array
    {
        // 检查数据是否存在
        $post = PostModel::with('tag')
            ->find($id);

        if (empty($post)) {
            throw_http_exception("Data id={$id} record does not exist.", ErrorCode::DbNotExist);
        }

        $existPostData = $post->toArray();
        if (!empty($existPostData['tag'])) {
            // 删除文章关联的标签
            $existPostTagIds = array_column($existPostData['tag'], 'id');
            $post->tag()->detach($existPostTagIds);
        }

        // 删除当前文章
        $post->delete();

        return ['id' => $id];
    }

    /**
     * 获取文章列表
     * @param $filterParam
     * @param $orderParam
     * @param int $pageNumber
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getPostList($filterParam, $orderParam, int $pageNumber = 1): array
    {
        // 处理过滤条件参数
        $filterCondition = [
            'title' => 'like',
            'status' => 'in',
            'type' => 'in',
            'content' => 'like',
            'user_id' => 'in',
            'category_id' => 'in',
            'create_time' => 'between',
            'update_time' => 'between'
        ];
        $filter = [];
        $existTagFilter = [];
        foreach ($filterParam as $field => $param) {
            if ($field === 'tags') {
                $existTagFilter = $param;
                continue;
            }

            if (array_key_exists($field, $filterCondition)) {
                switch ($filterCondition[$field]) {
                    case 'between':
                        if (in_array($field, ['create_time', 'update_time'])) {
                            $timeArray = explode(',', $param);
                            array_walk($timeArray, function (&$val) {
                                $val = strtotime($val);
                            });
                            $param = join(',', $timeArray);
                        }
                        break;
                    case 'like':
                        $param = "%{$param}%";
                        break;
                }

                $filter[] = [$field, $filterCondition[$field], $param];
            }
        }

        $post = new PostModel();
        // 判断tag数据
        if (!empty($existTagFilter)) {
            $tagExistNameObj = TagModel::field('id')->where('name', 'in', $existTagFilter)->select();
            if (!empty($tagExistNameObj)) {
                $tagExistNameData = $tagExistNameObj->toArray();
                $existTagIds = array_column($tagExistNameData, 'id');

                $postIdObj = PostTag::field('post_id')->where('tag_id', 'in', $existTagIds)->select();
                if (!empty($postIdObj)) {
                    $postIdData = $postIdObj->toArray();
                    $postIds = array_column($postIdData, 'post_id');
                    $filter[] = ["id", 'in', $postIds];
                } else {
                    $filter[] = ["id", '=', 0];
                }
            } else {
                $filter[] = ["id", '=', 0];
            }
        }

        if (!empty($filter)) {
            $post = $post->where($filter);
        }

        // 处理排序参数
        if (!empty($orderParam)) {
            $post = $post->order($orderParam);
        }

        // 查询数据，默认查找分页条数为 100 条
        $postData = $post->with(['category', 'media', 'user', 'tag'])
            ->page($pageNumber, 100)
            ->select();

        return !empty($postData) ? $postData->toArray() : [];
    }
}
