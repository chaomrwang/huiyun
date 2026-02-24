<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\User;
use think\facade\Db;

class AuthController extends BaseController
{
    public function register(): array
    {
        $payload = $this->payload(['email', 'password', 'mobile']);

        if (User::where('email', $payload['email'])->find()) {
            return $this->error('邮箱已注册', 409);
        }

        $user = User::create([
            'email' => $payload['email'],
            'mobile' => $payload['mobile'],
            'password_hash' => password_hash($payload['password'], PASSWORD_BCRYPT),
            'nickname' => $payload['nickname'] ?? '新用户',
            'status' => 1,
            'balance' => 0,
            'api_token' => bin2hex(random_bytes(32)),
        ]);

        return $this->success($user->visible(['id', 'email', 'mobile', 'nickname', 'api_token'])->toArray(), '注册成功');
    }

    public function login(): array
    {
        $payload = $this->payload(['email', 'password']);
        $user = User::where('email', $payload['email'])->find();
        if (!$user || !password_verify($payload['password'], $user['password_hash'])) {
            return $this->error('账号或密码错误', 401);
        }

        $token = bin2hex(random_bytes(32));
        Db::name('users')->where('id', $user['id'])->update(['api_token' => $token]);

        return $this->success([
            'token' => $token,
            'user' => $user->visible(['id', 'email', 'mobile', 'nickname', 'balance'])->toArray(),
        ], '登录成功');
    }

    public function profile(): array
    {
        $token = $this->request->header('Authorization');
        $user = User::where('api_token', $token)->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        return $this->success($user->visible(['id', 'email', 'mobile', 'nickname', 'balance', 'status', 'created_at'])->toArray());
    }
}
