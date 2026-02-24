<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class User extends Model
{
    protected $name = 'users';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $hidden = ['password_hash'];
}
