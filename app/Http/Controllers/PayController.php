<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Model\Product;
use App\Model\Spec;
use App\Model\ProductImage;
use App\Model\OrderProduct;
use App\Model\Order;
use App\Model\Cart;
use App\Model\Address;

class PayController extends Controller
{
    public function createCode()
    {
        $code = date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $order = Order::where('order_no', $code)->first();
        if (empty($order)) {
            return $code;
        } else {
            $this->createCode();
        }
        
    }

    public function placeOrder(Request $request)
    {
    	if (!empty($request->spec_id)) {
    		$product = Spec::with('product')->findOrFail($request->spec_id);
    		$title = $product->name;
    	} else {
    		$product = Product::findOrFail($request->product_id);
    		$title = $product->title;
    	}

        $code = $this->createCode();

        if($request->num > $product->stock || $product->status != 1){
            return json_encode(['code'=>'400','data' => '下单失败，库存不足或商品已下架']);            
        }
        
        DB::beginTransaction();
        try {
            $order = new Order;
            $order->user_id = $request->user_id;
            $order->origin_price = $product->price * $request->num;
            $order->order_no = $code;
            $order->title = $title;
            $order->status = 0;
            $order->save();

            if (!empty($request->spec_id)) {
	    		$orderProduct = new OrderProduct;
	    		$orderProduct->order_id = $order->id;
	    		$orderProduct->num = $request->num;
	            $orderProduct->product_id = $product->product_id;
	            $orderProduct->spec_id = $product->id;
	            $orderProduct->price = $product->price;
	            $orderProduct->product_name = $product->product->title;
	            $orderProduct->spec_name = $product->name;
	            
	    	} else {
	    		$orderProduct = new OrderProduct;
	    		$orderProduct->order_id = $order->id;
	    		$orderProduct->num = $request->num;
	            $orderProduct->product_id = $product->id;
	            $orderProduct->spec_id = null;
	            $orderProduct->price = $product->price;
	            $orderProduct->product_name = $product->title;
	            $orderProduct->spec_name = null;
	    	}

	    	$orderProduct->save();
            

            DB::commit();
            return json_encode(['code' => '200', 'order_no'=>$code]);
        } catch (Exception $e) {
            DB::rollBack();
            return json_encode(['code' => '400', 'data' =>'下单失败']);
        }
    }

    public function placeOrderFromCart(Request $request)
    {
        $code = $this->createCode();

        DB::beginTransaction();
        try {
            $order = new Order;

            $order->user_id = $request->user_id;
            $order->origin_price = 0;
            $order->order_no = $code;
            $order->title = '商品类集合';
            $order->status = 0;
            $order->save();

            $total = 0;
            $carts = explode(',', $request->carts);
            foreach ($carts as $key => $cart) {
                $cartData = Cart::find($cart);
                if (!empty($cartData->spec_id)) {
		    		$product = Spec::with('product')->findOrFail($cartData->spec_id);
		    		$product_name = $product->name;
		    		$spec_name = $product->product->title;
		    		$product_id = $product->product->id;
		    		$spec_id = $product->id;
		    	} else {
		    		$product = Product::findOrFail($cartData->product_id);
		    		$product_name = $product->title;
		    		$spec_name = null;
		    		$product_id = $product->id;
		    		$spec_id = null;
		    	}

                if($cartData->num > $product->stock ||  $product->status != 1){
                    return json_encode(['code'=>'400','data' => '下单失败，库存不足或商品已下架']);
                }

                $orderProduct = new OrderProduct;
	    		$orderProduct->order_id = $order->id;
	    		$orderProduct->num = $cartData->num;
	            $orderProduct->product_id = $product_id;
	            $orderProduct->spec_id = $spec_id;
	            $orderProduct->price = $product->price;
	            $orderProduct->product_name = $product_name;
	            $orderProduct->spec_name = $spec_name;

	            $orderProduct->save();

                $total += $product->price * $cartData->num;
                $cartData->delete_at = 1;
                $cartData->save();
            }

            $order->origin_price = $total;
            $order->save();
            DB::commit();
            return json_encode(['code' => '200', 'order_no' =>$code]);
        } catch (Exception $e) {
            DB::rollBack();
            return json_encode(['code' => '400', 'data' =>'下单失败']);
        }
    }

    public function show(Request $request)
    {
		Redis::set('name', 'getcharmcx');
		var_dump(Redis::get('name'));exit;


        $order = Order::where('order_no', $request->order_no)
                        ->with(['orderProducts'=>function($query){
	    					$query->select('order_id','product_name','spec_name','num','price');
	    				}])
	    				->with(['orderProducts.productImages'=>function($query){
	    					$query->select('product_id','path');
	    				}])
                        ->first();

        if (!empty($order)) {
            $address = Address::where('user_id', $request->user_id)->where('is_default', 1)->first();

            return json_encode(['code' => 200, 'data' => $order, 'address'=>$address]);
        } else {
            return [];
        }
        
    }

    public function notify()
    {
        $pay = Pay::wechat(config('pay.wechat'));

        try{
            $data = $pay->verify(); //验签

            Log::debug('Wechat notify', $data->return_code);
            Log::debug('Wechat notify', $data->result_code);
            if ($data->return_code == 'SUCCESS') {
                $order = Order::where('order_no', $data->out_trade_no)->with('orderProducts')->first();
                Log::debug('order', $order);
                $order->status = 1;
                $order->ok_date = now();
                $order->transaction_id = $data->transaction_id;
                $order->save();

                foreach ($order->orderProducts as $key => $orderProduct) {
                	if (!empty($orderProduct->spec_id)) {
                		Spec::where('id',$orderProducts->spec_id)->increment('sale', $orderProduct->num);
                    	Spec::where('id', $orderProducts->spec_id)->decrement('stock', $orderProduct->num);
                	} else {
                		Product::where('id',$orderProducts->product_id)->increment('sale', $orderProduct->num);
                    	Product::where('id', $orderProducts->product_id)->decrement('stock', $orderProduct->num);
                	}
                }
            }
            
            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            // $e->getMessage();
        }
        
        return $pay->success();// laravel 框架中请直接 `return $pay->success()`
    }
}
