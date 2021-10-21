# 标签相关接口

## add_tag 新增标签

- url: /tag/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "name": "这是一个标签3"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "这是一个标签3",
    "id": "4"
  }
}
```

## update_tag 更新标签

- url: /tag/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": "3",
  "name": "这是一个标签32"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": "3",
    "name": "这是一个标签32"
  }
}
```

## delete_tag 删除标签

- url: /tag/delete
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": "2"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": "2"
  }
}
```

## get_tag_list 获取标签列表

- url: /tag/get_list
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "filter":{
    "name": "标签3"
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
      "id": 3,
      "name": "这是一个标签32"
    },
    {
      "id": 4,
      "name": "这是一个标签3"
    }
  ]
}
```