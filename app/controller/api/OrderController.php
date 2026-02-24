<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\Order;
use app\model\User;

class OrderController extends BaseController
{
    public function create(): array
    {
        $payload = $this->payload(['token', 'product_id', 'billing_cycle', 'amount']);
        $user = User::where('api_token', $payload['token'])->find();
        if (!$user) {
            return $this->error('登录状态失效', 401);
        }

        $order = Order::create([
            'order_no' => 'HY' . date('YmdHis') . mt_rand(1000, 9999),
            'user_id' => $user['id'],
            'product_id' => (int) $payload['product_id'],
            'billing_cycle' => $payload['billing_cycle'],
            'amount' => (float) $payload['amount'],
            'status' => 'pending',
            'pay_status' => 'unpaid',
        ]);

        return $this->success($order->toArray(), '订单创建成功');
    }

    public function lists(): array
    {
        $token = $this->request->get('token', '');
        $user = User::where('api_token', $token)->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $orders = Order::where('user_id', $user['id'])->order('id', 'desc')->select()->toArray();
        return $this->success($orders);
    }
}
