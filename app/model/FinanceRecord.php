<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class FinanceRecord extends Model
{
    protected $name = 'finance_records';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
