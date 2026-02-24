<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class Ticket extends Model
{
    protected $name = 'tickets';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
