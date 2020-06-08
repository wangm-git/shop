<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
	protected $table = 'order_products';

    public $timestamps=false;

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    public function spec()
    {
        return $this->belongsTo('App\Model\Spec', 'spec_id');
    }

    public function productImages()
    {
        return $this->hasMany('App\Model\productImage', 'product_id','product_id');
    }

}
