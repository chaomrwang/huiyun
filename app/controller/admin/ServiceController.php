<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\ServiceInstance;

class ServiceController extends BaseController
{
    public function lists(): array
    {
        return $this->success(ServiceInstance::order('id', 'desc')->paginate(20)->toArray());
    }

    public function suspend(int $id): array
    {
        $service = ServiceInstance::find($id);
        if (!$service) {
            return $this->error('实例不存在', 404);
        }

        $service->status = 'suspended';
        $service->save();

        return $this->success($service->toArray(), '实例已暂停');
    }
}
