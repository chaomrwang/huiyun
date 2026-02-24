<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\Product;

class ProductController extends BaseController
{
    public function lists(): array
    {
        return $this->success(Product::order('sort', 'asc')->paginate(20)->toArray());
    }

    public function save(): array
    {
        $payload = $this->payload(['name', 'category', 'price']);
        $product = Product::create([
            'name' => $payload['name'],
            'category' => $payload['category'],
            'price' => (float) $payload['price'],
            'status' => (int) ($payload['status'] ?? 1),
            'is_recommend' => (int) ($payload['is_recommend'] ?? 0),
            'sort' => (int) ($payload['sort'] ?? 100),
            'description' => $payload['description'] ?? '',
        ]);

        return $this->success($product->toArray(), '保存成功');
    }
}
