# 分类相关接口

## add_category 新增分类

- url: /category/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "name": "分类测试78",
  "code": "test_catagory_78",
  "parent_id" : 0
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "分类测试78",
    "code": "test_catagory_78",
    "parent_id": 0,
    "id": "12"
  }
}
```

## update_category 更新分类

- url: /category/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "name": "分类测试778",
  "code": "test_catagory_778",
  "id" : 8
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "分类测试778",
    "code": "test_catagory_778",
    "id": 8
  }
}
```

## delete_category 删除分类

- url: /category/delete
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id" : 9
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 9
  }
}
```


## get_tree_list 获取分类树列表

- url: /category/get_tree_list
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
      "id": 1,
      "name": "分类测试1",
      "code": "test_catagory_1",
      "parent_id": 0,
      "children": [
        {
          "id": 2,
          "name": "分类测试22",
          "code": "test_catagory_22",
          "parent_id": 1
        },
        {
          "id": 3,
          "name": "分类测试33",
          "code": "test_catagory_33",
          "parent_id": 1,
          "children": [
            {
              "id": 6,
              "name": "分类测试66",
              "code": "test_catagory_66",
              "parent_id": 3
            },
            {
              "id": 7,
              "name": "分类测试77",
              "code": "test_catagory_77",
              "parent_id": 3
            }
          ]
        }
      ]
    },
    {
      "id": 4,
      "name": "分类测试44",
      "code": "test_catagory_44",
      "parent_id": 0,
      "children": [
        {
          "id": 10,
          "name": "分类测试58",
          "code": "test_catagory_58",
          "parent_id": 4
        }
      ]
    },
    {
      "id": 5,
      "name": "分类测试55",
      "code": "test_catagory_55",
      "parent_id": 0
    }
  ]
}
```