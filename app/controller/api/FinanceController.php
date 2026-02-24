<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\FinanceRecord;
use app\model\User;

class FinanceController extends BaseController
{
    public function records(): array
    {
        $token = $this->request->get('token', '');
        $user = User::where('api_token', $token)->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $records = FinanceRecord::where('user_id', $user['id'])->order('id', 'desc')->select()->toArray();
        return $this->success($records);
    }

    public function recharge(): array
    {
        $payload = $this->payload(['token', 'amount', 'pay_method']);
        $user = User::where('api_token', $payload['token'])->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $record = FinanceRecord::create([
            'user_id' => $user['id'],
            'type' => 'recharge',
            'amount' => (float) $payload['amount'],
            'pay_method' => $payload['pay_method'],
            'trade_no' => 'RC' . date('YmdHis') . mt_rand(1000, 9999),
            'status' => 'pending',
            'remark' => '用户发起充值',
        ]);

        return $this->success($record->toArray(), '充值申请已创建');
    }
}
