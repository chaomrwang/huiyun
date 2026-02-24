<?php

declare(strict_types=1);

namespace app\common;

use think\Request;

abstract class BaseController
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function success($data = [], string $message = 'ok', int $code = 0): array
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time(),
        ];
    }

    protected function error(string $message, int $code = 400, $data = []): array
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time(),
        ];
    }

    protected function payload(array $required = []): array
    {
        $payload = $this->request->post();
        foreach ($required as $field) {
            if (!array_key_exists($field, $payload) || $payload[$field] === '') {
                throw new \InvalidArgumentException('缺少参数: ' . $field);
            }
        }

        return $payload;
    }
}
