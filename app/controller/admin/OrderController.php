<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\Order;

class OrderController extends BaseController
{
    public function lists(): array
    {
        return $this->success(Order::order('id', 'desc')->paginate(20)->toArray());
    }

    public function deliver(int $id): array
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->error('订单不存在', 404);
        }

        $order->status = 'delivered';
        $order->pay_status = 'paid';
        $order->save();

        return $this->success($order->toArray(), '订单已交付');
    }
}
