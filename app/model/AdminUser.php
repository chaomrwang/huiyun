<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class AdminUser extends Model
{
    protected $name = 'admin_users';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
