<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }
}
