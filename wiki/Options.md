# 配置相关接口

## add_options 新增配置

- url: /options/add
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "name": "test_options",
  "code": "test_options",
  "config": {
    "test_key": "test_value"
  }
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "name": "test_options",
    "code": "test_options",
    "config": {
      "test_key": "test_value"
    },
    "id": "1"
  }
}
```

## update_options 更新配置

- url: /options/update
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "id": 3,
  "name": "test_options22",
  "code": "test_options22",
  "config": {
    "test_key": "test_value22"
  }
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 3,
    "name": "test_options22",
    "code": "test_options22",
    "config": {
      "test_key": "test_value22"
    }
  }
}
```

## delete_options 删除配置

- url: /options/delete
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
    "id": 3
  }
}
```

## get_by_code 通过获取指定配置

- url: /options/get_by_code
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

- 媒体服务配置
```json
{
  "code": "media_service"
}
```

- 备案号配置
```json
{
  "code": "beian_number"
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "port": 9000,
    "bucket": "cms",
    "use_ssl": false,
    "end_point": "127.0.0.1",
    "access_key": "xxx",
    "secret_key": "xxx"
  }
}
```

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "url": "https://beian.miit.gov.cn",
    "record": "京ICP备 88888888号 "
  }
}
```