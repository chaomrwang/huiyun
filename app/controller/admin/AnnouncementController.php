<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\Announcement;

class AnnouncementController extends BaseController
{
    public function lists(): array
    {
        return $this->success(Announcement::order('id', 'desc')->paginate(20)->toArray());
    }

    public function save(): array
    {
        $payload = $this->payload(['title', 'content']);
        $item = Announcement::create([
            'title' => $payload['title'],
            'content' => $payload['content'],
            'status' => (int) ($payload['status'] ?? 1),
        ]);

        return $this->success($item->toArray(), '公告创建成功');
    }
}
