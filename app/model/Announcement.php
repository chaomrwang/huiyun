<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class Announcement extends Model
{
    protected $name = 'announcements';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
