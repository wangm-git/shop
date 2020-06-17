<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Category;
use App\Model\Product;
use App\Model\Comment;
use App\Model\GroupProduct;
use App\Model\SeckillProduct;
use App\Model\Postage;
use App\Model\Banner;


class ProductController extends Controller
{
    public function index()
    {
    	$categories = Category::all();
    	// banner
        $banners = Banner::where('status', 1)->get();

    	$recommendProducts = Product::with('images')->where('recommend', 1)->where('status', 1)->get();

    	$groupProducts = GroupProduct::with('product')->with('product.images')->where('start_at', '<', now())->where('expire_at', '>', now())->where('stock', '>', 0)->get();

    	$seckillProducts = SeckillProduct::with('product')->where('start_at', '<', now())->where('expire_at', '>', now())->where('stock', '>', 0)->get();

    	return json_encode(['category' => $categories, 'banner' => $banners, 'recommend_product' => $recommendProducts, 'group_product' => $groupProducts, 'seckill_product' => $seckillProducts]);
    }

    public function detail($id)
    {
    	$product = Product::findOrFail($id);
    	$comments = Comment::where('product_id', $id)->get();
    	$recommendProducts = Product::with('images')->where('recommend', 1)->where('status', 1)->get();
    	return json_encode(['product'=>$product, 'comment'=>$comments, 'recommend'=>$recommendProducts]);
    }

    public function getInfoByCategory($category_id)
    {
    	$products = Product::with('images')->where('category_id', $category_id)->where('status', 1)->get();

    	return json_encode($products);
    }

    public function addPostage()
    {
    	// $address = ['北海道'];
    	// $aaa = ['2'=>'700', '5'=>'820', '10'=>'940', '15'=>'1060', '20'=>'1180','25'=>'1300'];

    	// $address = ['青森県', '秋田県','岩手県'];
    	// $aaa = ['2'=>'560', '5'=>'680', '10'=>'800', '15'=>'920', '20'=>'1040','25'=>'1160'];

    	// $address = ['宮城県', '山形県','福島県'];
    	// $aaa = ['2'=>'520', '5'=>'640', '10'=>'760', '15'=>'880', '20'=>'1000','25'=>'1120'];

    	// $address = ['茨城県', '栃木県','埼玉県', '群馬県','千葉県', '神奈川県','東京都', '山梨県'];
    	// $aaa = ['2'=>'500', '5'=>'610', '10'=>'710', '15'=>'820', '20'=>'930','25'=>'1040'];

    	// $address = ['新潟県', '長野県'];
    	// $aaa = ['2'=>'520', '5'=>'640', '10'=>'760', '15'=>'880', '20'=>'1000','25'=>'1120'];

    	// $address = ['富山県', '石川県','福井県'];
    	// $aaa = ['2'=>'520', '5'=>'640', '10'=>'760', '15'=>'880', '20'=>'1000','25'=>'1120'];

    	// $address = ['静岡県', '愛知県','三重県','岐阜県'];
    	// $aaa = ['2'=>'520', '5'=>'640', '10'=>'760', '15'=>'880', '20'=>'1000','25'=>'1120'];

    	// $address = ['大阪府', '京都府','滋賀県','奈良県','和歌山県','兵庫県'];
    	// $aaa = ['2'=>'560', '5'=>'680', '10'=>'800', '15'=>'920', '20'=>'1040','25'=>'1160'];

    	// $address = ['岡山県', '広島県','山口県','鳥取県','島根県'];
    	// $aaa = ['2'=>'600', '5'=>'720', '10'=>'840', '15'=>'960', '20'=>'1080','25'=>'1200'];

    	// $address = ['香川県', '徳島県','愛媛県','高知県'];
    	// $aaa = ['2'=>'600', '5'=>'720', '10'=>'840', '15'=>'960', '20'=>'1080','25'=>'1200'];

    	// $address = ['福岡県', '佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県'];
    	// $aaa = ['2'=>'700', '5'=>'820', '10'=>'940', '15'=>'1060', '20'=>'1180','25'=>'1300'];

    	// $address = ['沖縄県'];
    	// $aaa = ['2'=>'1240', '5'=>'1740', '10'=>'2260', '15'=>'2760', '20'=>'3280','25'=>'3780'];


    	foreach ($address as $key => $value) {
    		
    		foreach ($aaa as $k => $price) {
    			$postage = new Postage;
    			$postage->province = $value;
    			$postage->weight = $k;
    			$postage->postage = $price;
    			$postage->save();
    		}
    	}
    }


}
