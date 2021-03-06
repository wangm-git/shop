<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

    public function specs()
    {
        return $this->hasMany('App\Model\Spec', 'product_id');
    }

    public function images()
    {
        return $this->hasMany('App\Model\ProductImage', 'product_id');
    }

    public function seckillProducts()
    {
        return $this->hasMany('App\Model\SeckillProduct', 'product_id');
    }

    public function groupProducts()
    {
        return $this->hasMany('App\Model\GroupProduct', 'product_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Model\Comment', 'product_id');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Model\OrderProduct', 'product_id');
    }

    public function setImagesAttribute($images)
	{
		if (is_array($images)) {
			$this->attributes['images'] = json_encode($images);
		}
	}

	public function getImagesAttribute($images)
	{
		return json_decode($images, true);
	}
}
