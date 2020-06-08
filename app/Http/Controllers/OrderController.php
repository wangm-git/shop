<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Order;
use App\Model\OrderProduct;
use App\Product;
use App\ProductImage;

class OrderController extends Controller
{
    public function list(Request $request)
    {
    	$orders = Order::with(['orderProducts'=>function($query){
    					$query->select('order_id','product_name','spec_name','num','price');
    				}])
    				->with(['orderProducts.productImages'=>function($query){
    					$query->select('product_id','path');
    				}])
    				->where('status', 1)
    				->select('id','order_no','origin_price','actual_price','postage')
    				->get();
    	return $orders;
    }
}
