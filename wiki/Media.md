# 媒体相关接口

当前CMS系统并没有实现文件上传接口，直接对接外部符合 S3 对象存储协议的服务，例如 阿里云oss、腾讯云cos、自建minio等。

系统参考 wordpress 设计了独立的媒体库，需要使用的地方引用就行了。

## 对接流程

![image](./images/media_workflow.png)

