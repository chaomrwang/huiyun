<?php

declare(strict_types=1);

use think\facade\Route;

Route::group('api', function () {
    Route::post('auth/register', 'api.AuthController/register');
    Route::post('auth/login', 'api.AuthController/login');
    Route::get('auth/profile', 'api.AuthController/profile');

    Route::get('home/index', 'api.HomeController/index');
    Route::get('products', 'api.ProductController/lists');
    Route::get('products/:id', 'api.ProductController/detail');

    Route::post('orders', 'api.OrderController/create');
    Route::get('orders', 'api.OrderController/lists');

    Route::get('services', 'api.ServiceController/lists');
    Route::post('services/:id/action', 'api.ServiceController/action');

    Route::post('tickets', 'api.TicketController/create');
    Route::get('tickets', 'api.TicketController/lists');

    Route::get('finance/records', 'api.FinanceController/records');
    Route::post('finance/recharge', 'api.FinanceController/recharge');
});

Route::group('admin', function () {
    Route::post('auth/login', 'admin.AuthController/login');
    Route::get('dashboard/stats', 'admin.DashboardController/stats');

    Route::get('users', 'admin.UserController/lists');
    Route::put('users/:id/status', 'admin.UserController/updateStatus');

    Route::get('products', 'admin.ProductController/lists');
    Route::post('products', 'admin.ProductController/save');

    Route::get('orders', 'admin.OrderController/lists');
    Route::put('orders/:id/deliver', 'admin.OrderController/deliver');

    Route::get('services', 'admin.ServiceController/lists');
    Route::put('services/:id/suspend', 'admin.ServiceController/suspend');

    Route::get('tickets', 'admin.TicketController/lists');
    Route::post('tickets/:id/reply', 'admin.TicketController/reply');

    Route::get('finance/records', 'admin.FinanceController/lists');
    Route::put('finance/records/:id/approve', 'admin.FinanceController/approve');

    Route::get('announcements', 'admin.AnnouncementController/lists');
    Route::post('announcements', 'admin.AnnouncementController/save');
});
