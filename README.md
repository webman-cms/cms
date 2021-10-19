# cms
Based on webman and Vue

# API

## get_token

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




