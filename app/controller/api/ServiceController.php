<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\ServiceInstance;
use app\model\User;

class ServiceController extends BaseController
{
    public function lists(): array
    {
        $token = $this->request->get('token', '');
        $user = User::where('api_token', $token)->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $services = ServiceInstance::where('user_id', $user['id'])->order('id', 'desc')->select()->toArray();
        return $this->success($services);
    }

    public function action(int $id): array
    {
        $payload = $this->payload(['token', 'operation']);
        $user = User::where('api_token', $payload['token'])->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $service = ServiceInstance::where('id', $id)->where('user_id', $user['id'])->find();
        if (!$service) {
            return $this->error('服务不存在', 404);
        }

        $allowOperation = ['start', 'stop', 'reboot', 'renew'];
        if (!in_array($payload['operation'], $allowOperation, true)) {
            return $this->error('不支持的操作', 422);
        }

        $service->last_operation = $payload['operation'];
        $service->save();

        return $this->success($service->toArray(), '操作已受理');
    }
}
