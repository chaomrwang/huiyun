<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\Product;

class ProductController extends BaseController
{
    public function lists(): array
    {
        $category = $this->request->get('category', '');
        $query = Product::where('status', 1);
        if ($category !== '') {
            $query->where('category', $category);
        }

        return $this->success($query->order('sort', 'asc')->select()->toArray());
    }

    public function detail(int $id): array
    {
        $product = Product::where('id', $id)->where('status', 1)->find();
        if (!$product) {
            return $this->error('产品不存在', 404);
        }

        return $this->success($product->toArray());
    }
}
