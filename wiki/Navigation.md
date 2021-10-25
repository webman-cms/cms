# 导航相关接口

## add_nav 新增导航

- url: /nav/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### type 参数说明

|字段|说明|
|---|---|
|post| 关联文章地址 |
|page| 关联单页地址 |
|link| 自定义链接跳转 |
|category| 关联分类 |

#### body data

```json
{
  "name": "导航22",
  "type": "link",
  "url": "https://www.baidu.com",
  "parent_id": 2
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "导航22",
    "type": "link",
    "url": "https://www.baidu.com",
    "parent_id": 2,
    "id": "5"
  }
}
```

## update_nav 更新导航

- url: /nav/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "name": "导航55",
  "type" : "link",
  "id" : 5
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "导航55",
    "type": "link",
    "id": 5
  }
}
```

## delete_nav 删除导航

- url: /category/delete
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id" : 5
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 5
  }
}
```


## get_tree_list 获取导航树列表

- url: /nav/get_tree_list
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "filter":{
    "name": ""
  },
  "page_number": 1
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": [
    {
      "id": 2,
      "name": "导航测试778",
      "type": "link",
      "url": "https://www.baidu.com",
      "parent_id": 0,
      "link_id": 0,
      "index": 1,
      "children": [
        {
          "id": 5,
          "name": "导航55",
          "type": "link",
          "url": "https://www.baidu.com",
          "parent_id": 2,
          "link_id": 0,
          "index": 4
        }
      ]
    },
    {
      "id": 3,
      "name": "导航测试228",
      "type": "link",
      "url": "https://www.baidu.com",
      "parent_id": 0,
      "link_id": 0,
      "index": 2
    },
    {
      "id": 4,
      "name": "导航测试22822",
      "type": "link",
      "url": "https://www.baidu.com",
      "parent_id": 0,
      "link_id": 0,
      "index": 3
    }
  ]
}
```

## update_index_sort 更新导航排序

- url: /nav/update_index_sort
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "data": [
    {
      "id": 2,
      "index": 1
    },
    {
      "id": 3,
      "index": 2
    },
    {
      "id": 4,
      "index": 3
    },
    {
      "id": 5,
      "index": 4
    }
  ]
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": [
    {
      "id": 2,
      "index": 1
    },
    {
      "id": 3,
      "index": 2
    },
    {
      "id": 4,
      "index": 3
    },
    {
      "id": 5,
      "index": 4
    }
  ]
}
```