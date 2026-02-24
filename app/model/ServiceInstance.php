<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class ServiceInstance extends Model
{
    protected $name = 'service_instances';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
