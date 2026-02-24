# huiyun

汇云服务商（ThinkPHP6 API 版本）。

## 技术栈
- PHP 7.4+
- ThinkPHP 6.1
- MySQL 5.7/8.0

## 已实现
- 前台 API（注册登录、产品、订单、服务、工单、财务）
- 管理后台 API（仪表盘、用户、产品、订单、实例、工单、财务、公告）
- 数据库 SQL 初始化脚本
- 接口文档

## 目录
- `route/app.php`：全部接口路由
- `app/controller/api`：前台控制器
- `app/controller/admin`：后台控制器
- `database/huiyun.sql`：可执行建库建表 SQL
- `docs/api.md`：接口文档

## 快速开始
```bash
composer install
mysql -uroot -p < database/huiyun.sql
php think run
```
