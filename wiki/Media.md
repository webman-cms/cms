# 媒体相关接口

当前CMS系统并没有实现文件上传接口，直接对接外部符合 S3 对象存储协议的服务，例如 阿里云oss、腾讯云cos、自建minio等。

系统参考 wordpress 设计了独立的媒体库，需要使用的地方引用就行了。

## 对接流程

![image](./images/media_workflow.png)

## get_presigned_put_object_url 获取存储对象预上传地址

- url: /options/get_presigned_put_object_url
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### 参数说明

|字段|说明|
|---|---|
|object_name| 上传文件名包含后缀，如果要上传到子文件夹,在文件名前面加上目录路径例如 test/test.jpg|
|bucket_name| 存储桶名（选填） |

#### body data

```json
{
  "bucket_name": "cms",
  "object_name": "BrickCheap01.jpg"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "url": "http://10.168.30.17:19835/cms/BrickCheap01.jpg?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAIOSFODNN7EXAMPLE%2F20211022%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20211022T062254Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1200&X-Amz-Signature=20a0ab84d64badc6a90582e1ea240e89611545386049fe2059e40e0e976d3c9b"
  }
}
```

## 参数说明

|字段|说明|
|---|---|
|type| image（图片）,video（视频需要在线播放自己转码）,audio（音频）,file（其他格式文件）|
|path| bucket / 文件.后缀 |
|size| 文件大小，自己客户端计算大小 |
|description| 可以选填写文件描述 |

## add_media 新增媒体

- url: /media/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "type": "image",
  "path": "cms/test.jpg",
  "size": 123456.2,
  "description": "这是一个图片描述"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "type": "image",
    "path": "cms/test.jpg",
    "size": 123456.2,
    "description": "这是一个图片描述",
    "created_by": 1,
    "create_time": "2021-10-21 14:47:31",
    "id": "7"
  }
}
```

## update_media 更新媒体

- url: /media/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": 7,
  "type": "image",
  "path": "cms/test22.jpg",
  "size": 12356.2,
  "description": "这是一个图片描述22"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 7,
    "type": "image",
    "path": "cms/test22.jpg",
    "size": 12356.2,
    "description": "这是一个图片描述22",
    "created_by": 1
  }
}
```

## delete_media 删除媒体

- url: /media/delete
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": 5
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

## get_media_details 获取指定媒体详情

- url: /media/get_details
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": 3
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 3,
    "type": "image",
    "path": "cms/test.jpg",
    "size": "123456.2",
    "description": "这是一个图片描述",
    "created_by": 1,
    "create_time": "2021-10-21 14:38:13",
    "create_by_name": "管理员"
  }
}
```

## get_media_list 获取媒体列表

- url: /media/get_list
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

- 请求参数说明

|字段|说明|
|---|---|
|filter| 过滤条件参数|
|filter.create_time| 创建时间，需要给定两个时间形成一个范围，用”,“隔开 |
|filter.type| 文件类型，image,video,audio,file一种或者多个用”,“隔开 |
|filter.description| 文件描述，支持模糊查询 |
|filter.created_by| 创建人id，多个人用”,“隔开 |
|order| 排序参数|
|order.create_time| 以创建时间排序|
|page_number| 当前页数，后端限制死了每次查询为100条，不会返回总条数需要前端采用滚动分页模式|

```json
{
  "filter": {
    "create_time": "2021-10-20,2021-10-22",
    "type": "image,video,audio,file",
    "description": "图片",
    "created_by": "1,2"
  },
  "order": {
    "create_time": "asc"
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
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-21 14:38:13",
      "create_by_name": "管理员"
    },
    {
      "id": 4,
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-21 14:40:36",
      "create_by_name": "管理员"
    },
    {
      "id": 6,
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-21 14:41:35",
      "create_by_name": "管理员"
    },
    {
      "id": 7,
      "type": "image",
      "path": "cms/test.jpg",
      "size": "123456.2",
      "description": "这是一个图片描述",
      "created_by": 1,
      "create_time": "2021-10-21 14:47:31",
      "create_by_name": "管理员"
    }
  ]
}
```