<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\Product;
use App\Model\Spec;
use App\Model\ProductImage;


class CartController extends Controller
{
    public function add(Request $request)
    {
    	$oldCart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->where('spec_id', $request->spec_id)->first();
    	if (!empty($request->spec_id)) {
    		$spec = Spec::findOrFail($request->spec_id);
    		$stock = $spec->stock;
    	} else {
    		$product = Product::findOrFail($request->product_id);
    		$stock = $product->stock;
    	}

        if (!empty($oldCart)) {
            if ($request->num + $oldCart->num > $stock) {
                return json_encode(['code'=>'400','data'=>'数量大于库存']);
            }
            $oldCart->num = $request->num + $oldCart->num;
            $data = $oldCart->save();
        } else {
            if ($request->num > $stock) {
                return json_encode(['code'=>'400','data'=>'数量大于库存']);
            }
            $cart = New Cart;

            $cart->product_id = $request->product_id;
            $cart->user_id = $request->user_id;
            $cart->spec_id = $request->spec_id;
            $cart->num = $request->num;

            $data = $cart->save();
        }

        if ($data == 1){
            return json_encode(['code' => '200', 'data' =>'添加成功']);
        } else{
            return json_encode(['code' => '400', 'data' =>'添加失败']);
        }
    }

    public function update(Request $request)
    {
        $cart = Cart::findOrFail($request->id);
        if (!empty($cart->spec_id)) {
    		$spec = Spec::findOrFail($cart->spec_id);
    		$stock = $spec->stock;
    	} else {
    		$product = Product::findOrFail($cart->product_id);
    		$stock = $product->stock;
    	}

        if ($request->num > $stock) {
            return json_encode(['code'=>'400','data'=>'数量大于库存']);
        }

        $cart->num = $request->num;
        $data = $cart->save();

        if ($data == 1){
            return json_encode(['code' => '200', 'data' =>'修改成功']);
        } else{
            return json_encode(['code' => '400', 'data' =>'修改失败']);
        }
    }

    public function delete($id)
    {
    	$cart = Cart::find($id);

        $cart->delete_at = 1;
        $data = $cart->save();

        if ($data == 1){
            return json_encode(['code' => '200', 'data' =>'删除成功']);
        } else{
            return json_encode(['code' => '400', 'data' =>'删除失败']);
        }
    }

    public function list(Request $request)
    {
        $carts = Cart::where('user_id', $request->user_id)
                    ->leftJoin('products', 'carts.product_id', '=', 'products.id')
                    ->leftJoin('specs', 'carts.spec_id', '=', 'specs.id')
                    ->select('carts.id', 'carts.num', 'carts.product_id','carts.spec_id','products.title', 'products.price as product_price', 'specs.name', 'specs.price as spec_price')
                    ->get();

        $total = 0;
        foreach ($carts as $key => &$cart) {
        	$image = ProductImage::where('product_id',$cart->product_id)->first();
        	$cart->image = $image->path;
        	if (!empty($cart->spec_id)) {
        		$total += $cart->num * $cart->spec_price;
        	} else {
        		$total += $cart->num * $cart->product_price;
        	}
        	
        }

        return json_encode(['total'=>$total,'data'=>$carts]);
    }
}
