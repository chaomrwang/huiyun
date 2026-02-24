<?php

declare(strict_types=1);

namespace app\controller\admin;

use app\common\BaseController;
use app\model\FinanceRecord;

class FinanceController extends BaseController
{
    public function lists(): array
    {
        return $this->success(FinanceRecord::order('id', 'desc')->paginate(20)->toArray());
    }

    public function approve(int $id): array
    {
        $record = FinanceRecord::find($id);
        if (!$record) {
            return $this->error('记录不存在', 404);
        }

        $record->status = 'success';
        $record->save();

        return $this->success($record->toArray(), '已审核通过');
    }
}
