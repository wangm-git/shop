<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function list($user_id)
    {
    	$address = Address::where('user_id',$user_id)->get();
    	return json_encode(['code' => '200', 'data' => $address]);
    }

    public function add(Request $request)
    {
    	$address = New Address;

    	$address->name = $request->name;
    	$address->user_id = $request->user_id;
    	$address->phone = $request->phone;
    	$address->province = $request->province;
    	$address->city = $request->city;
    	$address->area = $request->area;
    	$address->address = $request->address;
    	$address->date = now();

    	$isDefault = Address::where('user_id', $request->user_id)->get();

    	if ($isDefault->count() == 0) {
    		$address->is_default = 1;
    	}
    	$data = $address->save();

    	if ($data == 1){
    		return json_encode(['code' => '200', 'data' =>'添加成功']);
    	} else{
    		return json_encode(['code' => '400', 'data' =>'添加失败']);
    	}

    }

    public function update($id, Request $request)
    {
    	$address = Address::find($id);
    	$address->name = $request->name;
    	$address->user_id = $request->user_id;
    	$address->phone = $request->phone;
    	$address->province = $request->province;
    	$address->city = $request->city;
    	$address->area = $request->area;
    	$address->address = $request->address;
    	$address->date = now();

    	$data = $address->save();

    	if ($data == 1){
    		return json_encode(['code' => '200', 'data' =>'修改成功']);
    	} else{
    		return json_encode(['code' => '400', 'data' =>'修改失败']);
    	}
    }

    public function delete($id)
    {
    	$data = Address::destroy($id);

        if ($data == 1){
            return json_encode(['code' => '200', 'data' =>'删除成功']);
        } else{
            return json_encode(['code' => '400', 'data' =>'删除失败']);
        }
    }

    public function setDefault(Request $request)
    {
    	$isDefault = Address::where('user_id', $request->user_id)->where('is_default', 1)->first();

        if (!empty($isDefault)) {
            $isDefault->is_default = 0;
            $isDefault->save();  
        }
    	

    	$address = Address::where('id', $request->id)->first();
    	$address->is_default = 1;
    	$data = $address->save();

    	if ($data == 1){
    		return json_encode(['code' => '200', 'data' =>'修改成功']);
    	} else{
    		return json_encode(['code' => '400', 'data' =>'修改失败']);
    	}
    }
}
