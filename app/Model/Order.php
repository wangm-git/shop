<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Model\OrderProduct', 'order_id');
    }
}
