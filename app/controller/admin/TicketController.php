<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\Ticket;

class TicketController extends BaseController
{
    public function lists(): array
    {
        return $this->success(Ticket::order('id', 'desc')->paginate(20)->toArray());
    }

    public function reply(int $id): array
    {
        $payload = $this->payload(['reply']);
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return $this->error('工单不存在', 404);
        }

        $ticket->admin_reply = $payload['reply'];
        $ticket->status = 'closed';
        $ticket->save();

        return $this->success($ticket->toArray(), '回复成功');
    }
}
