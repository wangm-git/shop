<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    protected $table = 'product_group';

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}
