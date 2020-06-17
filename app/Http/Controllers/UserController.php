<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserOpenId(Request $request)
    {
    	//CURL微信的接口，返回OPENID
		$code = $request->code;
		$appid = env('APPID');//微信的APPID
		$secret = env('SECRET');//微信的
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 500 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl, CURLOPT_URL, $url );
		$res = curl_exec( $curl );
		curl_close( $curl );
		$json_obj = json_decode( $res, true );
		$openid = $json_obj[ "openid" ];
		$array=array();
		$array['data']['openid']=$openid;
		$array['code']=200;
		//根据OPENID 判断
		$table = 'clothes_openid';
		$db->select_table($table);
		$where="openid ='$openid'";
		$limit="0,1";
		$admin= $db->where($where)->order('id')->limit($limit)->find();
		//判断openid,如果不存在就插入数据库

		//根据OPENID查询用户的信息
    }
}
