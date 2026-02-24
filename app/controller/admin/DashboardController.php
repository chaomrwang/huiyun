<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use think\facade\Db;

class DashboardController extends BaseController
{
    public function stats(): array
    {
        return $this->success([
            'user_total' => Db::name('users')->count(),
            'order_total' => Db::name('orders')->count(),
            'service_total' => Db::name('service_instances')->count(),
            'ticket_open_total' => Db::name('tickets')->where('status', 'open')->count(),
            'today_recharge' => Db::name('finance_records')
                ->where('type', 'recharge')
                ->whereDay('created_at')
                ->sum('amount'),
        ]);
    }
}
