# 文章相关接口

## add_post 新增文章

- url: /post/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### 字段参数说明

|字段|说明|
|---|---|
|post| 文章新增相关数据 |
|post.title| 文章标题 |
|post.status| 文章状态，draft 草稿，publish 发布 |
|post.type| 文章类型，post 文章，page 页面 |
|post.content| 文章内容，最大5万个中文字符 |
|post.thumb_media_id| 文章缩略图 |
|post.category_id| 文章所属分类 |
|tag| 文章关联标签属性 |

#### body data

```json
{
  "post": {
    "title": "文章标题测试",
    "status": "draft",
    "type": "post",
    "content": "文章内容测试",
    "category_id": 1,
    "thumb_media_id" : 1
  },
  "tag": [
    {
      "name": "tag1"
    },
    {
      "name": "tag6"
    },
    {
      "name": "tag4"
    }
  ]
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 24,
    "title": "文章标题测试",
    "status": "draft",
    "type": "post",
    "content": "文章内容测试",
    "thumb_media_id": 1,
    "user_id": 1,
    "category_id": 1,
    "create_time": "2021-10-26 11:35:16",
    "update_time": "2021-10-26 11:35:16",
    "category": {
      "id": 1,
      "name": "分类测试228",
      "code": "test_catagory_228",
      "parent_id": 0
    },
    "media": {
      "id": 1,
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-26 11:35:13"
    },
    "tag": [
      {
        "id": 1,
        "name": "tag1",
        "pivot": {
          "id": 34,
          "post_id": 24,
          "tag_id": 1
        }
      },
      {
        "id": 7,
        "name": "tag6",
        "pivot": {
          "id": 35,
          "post_id": 24,
          "tag_id": 7
        }
      },
      {
        "id": 6,
        "name": "tag4",
        "pivot": {
          "id": 36,
          "post_id": 24,
          "tag_id": 6
        }
      }
    ]
  }
}
```

## update_post 更新文章

- url: /post/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "post": {
    "id" : 12,
    "title": "文章标题测试",
    "status": "draft",
    "type": "post",
    "content": "文章内容测试",
    "category_id": 1,
    "thumb_media_id" : 1
  },
  "tag": [
    {
      "name": "tag4"
    },
    {
      "name": "tag8"
    }
  ]
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 12,
    "title": "文章标题测试",
    "status": "draft",
    "type": "post",
    "content": "文章内容测试",
    "thumb_media_id": 1,
    "user_id": 1,
    "category_id": 1,
    "create_time": "2021-10-26 11:11:01",
    "update_time": "2021-10-26 13:46:56",
    "category": {
      "id": 1,
      "name": "分类测试228",
      "code": "test_catagory_228",
      "parent_id": 0
    },
    "media": {
      "id": 1,
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-26 11:35:13"
    },
    "tag": [
      {
        "id": 6,
        "name": "tag4",
        "pivot": {
          "id": 6,
          "post_id": 12,
          "tag_id": 6
        }
      },
      {
        "id": 8,
        "name": "tag8",
        "pivot": {
          "id": 47,
          "post_id": 12,
          "tag_id": 8
        }
      }
    ]
  }
}
```

## delete_post 删除文章

- url: /post/delete
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id" : 12
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 12
  }
}
```

## post_find_one 获取指定文章信息

- url: /post/find_one
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id" : 15
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 15,
    "title": "文章标题测试",
    "status": "draft",
    "type": "post",
    "content": "文章内容测试",
    "thumb_media_id": 0,
    "user_id": 1,
    "category_id": 1,
    "create_time": "2021-10-26 11:24:50",
    "update_time": "2021-10-26 11:24:50",
    "user_name": "管理员",
    "category": {
      "id": 1,
      "name": "分类测试228",
      "code": "test_catagory_228",
      "parent_id": 0
    },
    "media": null,
    "tag": [
      {
        "id": 1,
        "name": "tag1",
        "pivot": {
          "id": 7,
          "post_id": 15,
          "tag_id": 1
        }
      },
      {
        "id": 2,
        "name": "tag2",
        "pivot": {
          "id": 8,
          "post_id": 15,
          "tag_id": 2
        }
      },
      {
        "id": 6,
        "name": "tag4",
        "pivot": {
          "id": 9,
          "post_id": 15,
          "tag_id": 6
        }
      }
    ]
  }
}
```

## get_post_list 获取多条文章信息

- url: /post/get_list
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### 参数说明

```php
  /**
         * 支持文章标题过滤
         * 支持文章内容过滤
         * 支持文章类型过滤 draft：草稿，publish：已发布
         * 支持按类型过滤 post 文章，page 页面
         * 支持按创建者过滤
         * 支持按分类过滤
         * 支持按创建、更新时间排序、过滤
         * 支持按文章标签过滤
         *
         * 默认每次查询条数 100 条，不返回总条数，请客户端自行处理滚动加载分页！
         *
         */

        // 请求参数示例
//        $filter = [
//            "filter" => [
//                "title" => "文章标题",
//                "content" => "文章内容",
//                "status" => "draft,publish",
//                "type" => "post,page",
//                "user_id" => "1,2",
//                "category_id" => "1,2",
//                "create_time" => "2021-10-20,2021-10-21",
//                "update_time" => "2021-10-20,2021-10-21",
//                "tags" => "tag1,tag2,tag3"
//            ],
//            "order" => [
//                "create_time" => "asc"
//            ],
//            "page_number" => 1
//        ];
```

#### body data

```json
{
  "filter": {
    "tags": "tag3"
  },
  "order": {
    "create_time": "asc"
  },
  "page_number" : 1
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": [
    {
      "id": 9,
      "title": "文章标题测试",
      "status": "draft",
      "type": "post",
      "content": "文章内容测试",
      "thumb_media_id": 0,
      "user_id": 1,
      "category_id": 1,
      "create_time": "2021-10-26 10:43:54",
      "update_time": "2021-10-26 10:43:54",
      "user_name": "管理员",
      "category": {
        "id": 1,
        "name": "分类测试228",
        "code": "test_catagory_228",
        "parent_id": 0
      },
      "media": null,
      "tag": [
        {
          "id": 1,
          "name": "tag1",
          "pivot": {
            "id": 1,
            "post_id": 9,
            "tag_id": 1
          }
        },
        {
          "id": 2,
          "name": "tag2",
          "pivot": {
            "id": 2,
            "post_id": 9,
            "tag_id": 2
          }
        },
        {
          "id": 3,
          "name": "tag3",
          "pivot": {
            "id": 3,
            "post_id": 9,
            "tag_id": 3
          }
        }
      ]
    }
  ]
}
```