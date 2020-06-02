<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SeckillProduct extends Model
{
    protected $table = 'product_seckill';

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}
