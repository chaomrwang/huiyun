<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\User;

class UserController extends BaseController
{
    public function lists(): array
    {
        return $this->success(User::order('id', 'desc')->paginate(20)->toArray());
    }

    public function updateStatus(int $id): array
    {
        $payload = $this->payload(['status']);
        $user = User::find($id);
        if (!$user) {
            return $this->error('用户不存在', 404);
        }

        $user->status = (int) $payload['status'];
        $user->save();

        return $this->success($user->visible(['id', 'status'])->toArray(), '状态已更新');
    }
}
