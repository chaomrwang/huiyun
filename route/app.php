<?php

declare(strict_types=1);

use think\facade\Route;

Route::group('api', function () {
    // 用户注册接口
    Route::post('auth/register', 'api.AuthController/register');
    // 用户登录接口
    Route::post('auth/login', 'api.AuthController/login');
    // 获取当前登录用户资料
    Route::get('auth/profile', 'api.AuthController/profile');

    // 前台首页聚合数据（Banner/推荐产品/公告）
    Route::get('home/index', 'api.HomeController/index');
    // 产品列表接口（支持按分类筛选）
    Route::get('products', 'api.ProductController/lists');
    // 产品详情接口
    Route::get('products/:id', 'api.ProductController/detail');

    // 创建订单接口
    Route::post('orders', 'api.OrderController/create');
    // 当前用户订单列表接口
    Route::get('orders', 'api.OrderController/lists');

    // 当前用户服务实例列表接口
    Route::get('services', 'api.ServiceController/lists');
    // 服务实例操作接口（开机/关机/重启/续费）
    Route::post('services/:id/action', 'api.ServiceController/action');

    // 创建工单接口
    Route::post('tickets', 'api.TicketController/create');
    // 当前用户工单列表接口
    Route::get('tickets', 'api.TicketController/lists');

    // 当前用户财务流水列表接口
    Route::get('finance/records', 'api.FinanceController/records');
    // 发起充值接口
    Route::post('finance/recharge', 'api.FinanceController/recharge');
});

Route::group('admin', function () {
    // 管理员登录接口
    Route::post('auth/login', 'admin.AuthController/login');
    // 后台仪表盘统计接口
    Route::get('dashboard/stats', 'admin.DashboardController/stats');

    // 后台用户分页列表接口
    Route::get('users', 'admin.UserController/lists');
    // 更新用户状态接口
    Route::put('users/:id/status', 'admin.UserController/updateStatus');

    // 后台产品分页列表接口
    Route::get('products', 'admin.ProductController/lists');
    // 新增产品接口
    Route::post('products', 'admin.ProductController/save');

    // 后台订单分页列表接口
    Route::get('orders', 'admin.OrderController/lists');
    // 订单交付接口
    Route::put('orders/:id/deliver', 'admin.OrderController/deliver');

    // 后台服务实例分页列表接口
    Route::get('services', 'admin.ServiceController/lists');
    // 暂停服务实例接口
    Route::put('services/:id/suspend', 'admin.ServiceController/suspend');

    // 后台工单分页列表接口
    Route::get('tickets', 'admin.TicketController/lists');
    // 工单回复并关闭接口
    Route::post('tickets/:id/reply', 'admin.TicketController/reply');

    // 后台财务记录分页列表接口
    Route::get('finance/records', 'admin.FinanceController/lists');
    // 审核通过财务记录接口
    Route::put('finance/records/:id/approve', 'admin.FinanceController/approve');

    // 后台公告分页列表接口
    Route::get('announcements', 'admin.AnnouncementController/lists');
    // 创建公告接口
    Route::post('announcements', 'admin.AnnouncementController/save');
});
