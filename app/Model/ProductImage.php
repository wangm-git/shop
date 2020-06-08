<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
	public $timestamps=false;

    protected $table = 'product_images';

    protected $fillable = ['product_id', 'path'];

}
