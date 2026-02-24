<?php

declare(strict_types=1);

namespace app\controller\api;

use app\common\BaseController;
use app\model\Ticket;
use app\model\User;

class TicketController extends BaseController
{
    public function create(): array
    {
        $payload = $this->payload(['token', 'subject', 'content']);
        $user = User::where('api_token', $payload['token'])->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $ticket = Ticket::create([
            'user_id' => $user['id'],
            'subject' => $payload['subject'],
            'content' => $payload['content'],
            'status' => 'open',
            'priority' => $payload['priority'] ?? 'normal',
        ]);

        return $this->success($ticket->toArray(), '工单已提交');
    }

    public function lists(): array
    {
        $token = $this->request->get('token', '');
        $user = User::where('api_token', $token)->find();
        if (!$user) {
            return $this->error('无效token', 401);
        }

        $tickets = Ticket::where('user_id', $user['id'])->order('id', 'desc')->select()->toArray();
        return $this->success($tickets);
    }
}
