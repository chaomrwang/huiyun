<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\AdminUser;

class AuthController extends BaseController
{
    public function login(): array
    {
        $payload = $this->payload(['username', 'password']);
        $admin = AdminUser::where('username', $payload['username'])->find();
        if (!$admin || !password_verify($payload['password'], $admin['password_hash'])) {
            return $this->error('账号或密码错误', 401);
        }

        $token = bin2hex(random_bytes(32));
        $admin->token = $token;
        $admin->save();

        return $this->success([
            'token' => $token,
            'admin' => $admin->visible(['id', 'username', 'role', 'status'])->toArray(),
        ]);
    }
}
