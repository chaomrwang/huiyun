# 汇云 ThinkPHP6 接口文档（PHP 7.4）

> 说明：基于 `maoyun.com` 常见服务商功能重构，包含前台 API 与管理后台 API，仅提供接口层，不含页面。

## 1. 基础约定
- Base URL：`/api`（前台）与 `/admin`（后台）
- 响应结构：
```json
{
  "code": 0,
  "message": "ok",
  "data": {},
  "timestamp": 1710000000
}
```
- 鉴权：前台通过 `token` 参数或 `Authorization` 请求头；后台通过登录接口返回 token（示例里已预留字段）。

---

## 2. 前台 API

### 2.1 认证
1. `POST /api/auth/register` 用户注册  
2. `POST /api/auth/login` 用户登录  
3. `GET /api/auth/profile` 获取个人资料

### 2.2 首页与产品
4. `GET /api/home/index` 首页聚合（banner + 推荐产品 + 公告）  
5. `GET /api/products?category=cloud_server` 产品列表  
6. `GET /api/products/{id}` 产品详情

### 2.3 订单与服务
7. `POST /api/orders` 创建订单  
8. `GET /api/orders?token=xxx` 订单列表  
9. `GET /api/services?token=xxx` 服务实例列表  
10. `POST /api/services/{id}/action` 服务操作（start/stop/reboot/renew）

### 2.4 工单与财务
11. `POST /api/tickets` 创建工单  
12. `GET /api/tickets?token=xxx` 工单列表  
13. `GET /api/finance/records?token=xxx` 财务流水  
14. `POST /api/finance/recharge` 发起充值

---

## 3. 后台 API

### 3.1 登录与仪表盘
1. `POST /admin/auth/login` 管理员登录  
2. `GET /admin/dashboard/stats` 统计数据

### 3.2 用户与产品
3. `GET /admin/users` 用户分页  
4. `PUT /admin/users/{id}/status` 修改用户状态  
5. `GET /admin/products` 产品分页  
6. `POST /admin/products` 新增产品

### 3.3 订单/实例/工单/财务
7. `GET /admin/orders` 订单分页  
8. `PUT /admin/orders/{id}/deliver` 订单交付  
9. `GET /admin/services` 实例分页  
10. `PUT /admin/services/{id}/suspend` 暂停实例  
11. `GET /admin/tickets` 工单分页  
12. `POST /admin/tickets/{id}/reply` 工单回复并关闭  
13. `GET /admin/finance/records` 财务记录分页  
14. `PUT /admin/finance/records/{id}/approve` 审核充值

### 3.4 公告
15. `GET /admin/announcements` 公告分页  
16. `POST /admin/announcements` 创建公告

---

## 4. 关键请求示例

### 用户登录
`POST /api/auth/login`
```json
{
  "email": "demo@huiyun.com",
  "password": "123456"
}
```

### 创建订单
`POST /api/orders`
```json
{
  "token": "用户token",
  "product_id": 1,
  "billing_cycle": "monthly",
  "amount": 88.00
}
```

### 服务实例操作
`POST /api/services/1/action`
```json
{
  "token": "用户token",
  "operation": "reboot"
}
```

---

## 5. 数据库说明
- SQL 文件：`database/huiyun.sql`
- 核心表：
  - 用户：`users`
  - 产品：`products`
  - 订单：`orders`
  - 服务实例：`service_instances`
  - 工单：`tickets`
  - 财务：`finance_records`
  - 公告：`announcements`
  - 后台管理员：`admin_users`
- 已包含外键关系与初始化数据，可直接导入执行。

---

## 6. 初始化命令
```bash
mysql -uroot -p < database/huiyun.sql
```
