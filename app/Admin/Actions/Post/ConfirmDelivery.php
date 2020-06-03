<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Model\Order;

class ConfirmDelivery extends RowAction
{
    public $name = '确认发货';

    public function form()
	{
		$this->hidden('id');
	    $this->text('express_no', '快递单号')->rules('required');
	}

    public function handle(Model $model,Request $request)
    {
        $expressNo = $request->get('express_no');
        $id = $model->id;
        $order = Order::findOrFail($id);
        $order->express_no = $expressNo;
        $order->status = 2;
        $order->save();

        return $this->response()->success('Success message.')->refresh();
    }

}