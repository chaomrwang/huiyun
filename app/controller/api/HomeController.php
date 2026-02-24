<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\Announcement;
use app\model\Product;

class HomeController extends BaseController
{
    public function index(): array
    {
        return $this->success([
            'banners' => [
                ['id' => 1, 'title' => '云服务器限时折扣', 'image' => '/static/banner/cloud.png', 'link' => '/products'],
                ['id' => 2, 'title' => '高防IP上线', 'image' => '/static/banner/ddos.png', 'link' => '/security'],
            ],
            'recommendProducts' => Product::where('is_recommend', 1)->where('status', 1)->limit(6)->select()->toArray(),
            'announcements' => Announcement::where('status', 1)->order('id', 'desc')->limit(5)->select()->toArray(),
        ]);
    }
}
