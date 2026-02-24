SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `huiyun` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `huiyun`;

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` varchar(60) NOT NULL COMMENT '管理员账号',
  `password_hash` varchar(255) NOT NULL COMMENT '管理员密码哈希',
  `role` varchar(30) NOT NULL DEFAULT 'super_admin' COMMENT '角色标识',
  `token` varchar(128) DEFAULT NULL COMMENT '后台登录令牌',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态:1启用,0禁用',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_admin_username` (`username`)
) ENGINE=InnoDB COMMENT='后台管理员表';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `email` varchar(120) NOT NULL COMMENT '邮箱',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `password_hash` varchar(255) NOT NULL COMMENT '登录密码哈希',
  `nickname` varchar(60) NOT NULL COMMENT '昵称',
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '账户余额',
  `api_token` varchar(128) DEFAULT NULL COMMENT '前台API令牌',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态:1正常,0禁用',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_email` (`email`),
  UNIQUE KEY `uk_user_mobile` (`mobile`),
  KEY `idx_user_token` (`api_token`)
) ENGINE=InnoDB COMMENT='前台用户表';

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(120) NOT NULL COMMENT '产品名称',
  `category` varchar(50) NOT NULL COMMENT '产品分类',
  `price` decimal(10,2) NOT NULL COMMENT '产品价格',
  `description` text COMMENT '产品描述',
  `is_recommend` tinyint NOT NULL DEFAULT 0 COMMENT '是否推荐:1是,0否',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态:1上架,0下架',
  `sort` int NOT NULL DEFAULT 100 COMMENT '排序值(越小越靠前)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_products_category` (`category`)
) ENGINE=InnoDB COMMENT='产品表';

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_no` varchar(40) NOT NULL COMMENT '订单编号',
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `product_id` bigint unsigned NOT NULL COMMENT '产品ID',
  `billing_cycle` varchar(30) NOT NULL COMMENT '计费周期(月付/季付/年付)',
  `amount` decimal(10,2) NOT NULL COMMENT '订单金额',
  `status` varchar(30) NOT NULL DEFAULT 'pending' COMMENT '订单状态',
  `pay_status` varchar(30) NOT NULL DEFAULT 'unpaid' COMMENT '支付状态',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_order_no` (`order_no`),
  KEY `idx_orders_user` (`user_id`),
  KEY `idx_orders_product` (`product_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_orders_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB COMMENT='订单表';

DROP TABLE IF EXISTS `service_instances`;
CREATE TABLE `service_instances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` bigint unsigned NOT NULL COMMENT '所属用户ID',
  `order_id` bigint unsigned NOT NULL COMMENT '来源订单ID',
  `instance_name` varchar(100) NOT NULL COMMENT '实例名称',
  `instance_ip` varchar(45) DEFAULT NULL COMMENT '实例IP地址',
  `status` varchar(30) NOT NULL DEFAULT 'running' COMMENT '实例状态',
  `expired_at` datetime DEFAULT NULL COMMENT '到期时间',
  `last_operation` varchar(30) DEFAULT NULL COMMENT '最后一次操作',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_instances_user` (`user_id`),
  KEY `idx_instances_order` (`order_id`),
  CONSTRAINT `fk_instances_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_instances_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB COMMENT='服务实例表';

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `subject` varchar(150) NOT NULL COMMENT '工单主题',
  `content` text NOT NULL COMMENT '工单内容',
  `admin_reply` text COMMENT '管理员回复',
  `priority` varchar(20) NOT NULL DEFAULT 'normal' COMMENT '优先级(normal/high/urgent)',
  `status` varchar(20) NOT NULL DEFAULT 'open' COMMENT '工单状态(open/closed)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_tickets_user` (`user_id`),
  CONSTRAINT `fk_tickets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB COMMENT='工单表';

DROP TABLE IF EXISTS `finance_records`;
CREATE TABLE `finance_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `type` varchar(30) NOT NULL COMMENT '流水类型(recharge/consume/refund)',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `pay_method` varchar(30) DEFAULT NULL COMMENT '支付方式(alipay/wechat/bank)',
  `trade_no` varchar(40) DEFAULT NULL COMMENT '交易流水号',
  `status` varchar(20) NOT NULL DEFAULT 'pending' COMMENT '状态(pending/success/failed)',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_finance_user` (`user_id`),
  CONSTRAINT `fk_finance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB COMMENT='财务流水表';

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(150) NOT NULL COMMENT '公告标题',
  `content` text NOT NULL COMMENT '公告内容',
  `status` tinyint NOT NULL DEFAULT 1 COMMENT '状态:1发布,0下线',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT='公告表';

INSERT INTO `admin_users` (`username`, `password_hash`, `role`, `status`) VALUES
('admin', '$2y$10$7lI6JiP2L2ODzy4DB44FNOzbKz7LxyzKDn5XxhxL7sRKqzZo4PM5S', 'super_admin', 1);

INSERT INTO `products` (`name`, `category`, `price`, `description`, `is_recommend`, `status`, `sort`) VALUES
('轻量云主机-2C4G', 'cloud_server', 88.00, '适合个人站点与小程序业务', 1, 1, 1),
('高防IP-100G', 'security', 399.00, '支持CC防护，适合游戏与金融业务', 1, 1, 2),
('对象存储-100G', 'storage', 19.90, '高可用对象存储服务', 0, 1, 3);

INSERT INTO `announcements` (`title`, `content`, `status`) VALUES
('春节运维公告', '春节期间7x24小时值守，工单响应不受影响。', 1),
('新产品发布', '高防IP与WAF产品已上线，欢迎体验。', 1);

SET FOREIGN_KEY_CHECKS = 1;
