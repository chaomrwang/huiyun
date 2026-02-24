<?php

declare(strict_types=1);

namespace app\model;

use think\Model;

class Product extends Model
{
    protected $name = 'products';
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
