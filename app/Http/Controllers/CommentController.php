<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Comment;
use Storage;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        $image = $request->file('image');
        
        $fileExtension = $image->getClientOriginalExtension();
        $tmpFile = $image->getRealPath();
        $fileName = md5(time().rand(0,10000)).'.'.$fileExtension;
        $savePath = 'images/'.$fileName;
        Storage::disk('public')->put($savePath, file_get_contents($tmpFile));
        
        $comment = New Comment;
        $comment->user_id = $request->user_id;
        $comment->product_id = $request->product_id;
        $comment->content = $request->content;
        $comment->image = $savePath;
        $data = $comment->save();

        if ($data == 1){
            return json_encode(['code' => '200', 'data' =>'添加成功']);
        } else{
            return json_encode(['code' => '400', 'data' =>'添加失败']);
        }
    }
}
