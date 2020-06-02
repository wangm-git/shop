<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    protected $table = 'specs';

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}
