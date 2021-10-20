# 用户相关接口

## get_token 获取令牌

- url: /user/get_token
- method: POST
- Content-Type: application/json

#### body data

```json
{
    "login_name": "admin",
    "password": "Cms@Admin"
}
```

#### response data

```json
{
    "code": 0,
    "msg": "",
    "data": {
        "user_data": {
            "id": 1,
            "login_name": "admin",
            "name": "管理员",
            "sex": "male",
            "phone": "18888888888",
            "email": "admin@cms.com"
        },
        "token": {
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cuY3JtLmNvbSIsImF1ZCI6Ind3dy5jcm0uY29tIiwianRpIjoiR1RxcUl5MFIiLCJpYXQiOjE2MzQ2MzA0OTQuOTMwNzQxLCJuYmYiOjE2MzQ2MzA1NTQuOTMwNzQxLCJleHAiOjMyNjkyNjQ1ODguOTMwNzQxLCJpZCI6MSwicGhvbmUiOiIxODg4ODg4ODg4OCIsImlwIjoiMTcyLjE2LjIwLjIzIn0.yk8LevoeWD2NhdH77b81ufXOMMhhf6mgh2bcQo0rYdw",
            "access_token_expires": 1634634094,
            "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cuY3JtLmNvbSIsImF1ZCI6Ind3dy5jcm0uY29tIiwianRpIjoiR1RxcUl5MFIiLCJpYXQiOjE2MzQ2MzA0OTQuOTMxMDUyLCJuYmYiOjE2MzQ2MzA1NTQuOTMxMDUyLCJleHAiOjMyNjk4NjU3ODguOTMxMDUyLCJpZCI6MSwicGhvbmUiOiIxODg4ODg4ODg4OCIsImlwIjoiMTcyLjE2LjIwLjIzIn0.Bl1JDlBdz-LI-KtWamTyVahz_1Ur41OFfvjFJjQAUxk",
            "refresh_token_expires": 1635235294
        }
    }
}
```

## refresh_token 刷新令牌

- url: /user/refresh_token
- method: POST
- Content-Type: application/json

#### body data

```json
{
  "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cuY3JtLmNvbSIsImF1ZCI6Ind3dy5jcm0uY29tIiwianRpIjoiR1RxcUl5MFIiLCJpYXQiOjE2MzQ2OTcxNjIuOTgzMTIyLCJuYmYiOjE2MzQ2OTcyMjIuOTgzMTIyLCJleHAiOjE2MzUzMDE5NjIuOTgzMTIyLCJpZCI6MSwicGhvbmUiOiIxODg4ODg4ODg4OCIsImlwIjoiMTcyLjE2LjIwLjIzIn0.gIcCjaL1a3WVJjxfQrfNs0JYzZM59_E_PbJ6cMnBG-I"
}
```

#### response data

```json
{
    "code": 0,
    "msg": "",
    "data": {
        "user_data": {
            "id": 1,
            "login_name": "admin",
            "name": "管理员",
            "sex": "male",
            "phone": "18888888888",
            "email": "admin@cms.com"
        },
        "token": {
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cuY3JtLmNvbSIsImF1ZCI6Ind3dy5jcm0uY29tIiwianRpIjoiR1RxcUl5MFIiLCJpYXQiOjE2MzQ2OTcxODEuMDcyMDYyLCJuYmYiOjE2MzQ2OTcyNDEuMDcyMDYyLCJleHAiOjE2MzQ3MDA3ODEuMDcyMDYyLCJpZCI6MSwicGhvbmUiOiIxODg4ODg4ODg4OCIsImlwIjoiMTcyLjE2LjIwLjIzIn0.aNg43yZNoWEA6FzlBQ4JnH9g3B6gxmxh5fMipyCG9W0",
            "access_token_expires": 1634700781,
            "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cuY3JtLmNvbSIsImF1ZCI6Ind3dy5jcm0uY29tIiwianRpIjoiR1RxcUl5MFIiLCJpYXQiOjE2MzQ2OTcxODEuMDcyMzc4LCJuYmYiOjE2MzQ2OTcyNDEuMDcyMzc4LCJleHAiOjE2MzUzMDE5ODEuMDcyMzc4LCJpZCI6MSwicGhvbmUiOiIxODg4ODg4ODg4OCIsImlwIjoiMTcyLjE2LjIwLjIzIn0.N0M5LMcNNva7JFfxWnnjVRBcfDp7_osvB37Td0BRNLo",
            "refresh_token_expires": 1635301981
        }
    }
}
```

## get_user_info 获取用户信息

- url: /user/get_user_info
- method: POST
- Content-Type: application/json
- Authorization: Bearer xxxxxxxxx(access_token)

#### body data

```json
{
  "user_id": 1
}
```

#### response data

```json
{
  "code": 0,
  "msg": "",
  "data": {
    "id": 1,
    "login_name": "admin",
    "name": "管理员",
    "sex": "male",
    "phone": "18888888888",
    "email": "admin@cms.com",
    "last_visit_time": null,
    "create_time": "2021-10-15 17:00:28"
  }
}
```


