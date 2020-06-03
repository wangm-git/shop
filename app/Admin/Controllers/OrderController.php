<?php

namespace App\Admin\Controllers;

use App\Model\Order;
use App\Model\OrderProduct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;
use App\Admin\Actions\Post\ConfirmDelivery;


class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', 'ID');
        $grid->column('user.name', '姓名');
        $grid->column('order_no', '订单号');
        $grid->column('origin_price', '原价格');
        $grid->column('actual_price', '实际价格');
        $grid->column('postage', '邮费');
        $grid->column('express_no', '快递单号');
        $grid->column('group_id', '团');
        $grid->column('integral', '使用积分');
        $grid->column('discount', '折扣');
        $grid->column('address', '收货人地址');
        $grid->column('name', '收货人姓名');
        $grid->column('phone', '收货人电话');
        $grid->column('product_status', '商品类型');
        $grid->column('status', '订单状态');

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            // 当前行的数据数组
            $order = $actions->row;
            // 进行判断
            if($order->status == 1){
                $actions->add(new ConfirmDelivery);
            }
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('order_no', __('Order no'));
        $show->field('origin_price', __('Origin price'));
        $show->field('actual_price', __('Actual price'));
        $show->field('postage', __('Postage'));
        $show->field('group_id', __('Group id'));
        $show->field('integral', __('Integral'));
        $show->field('discount', __('Discount'));
        $show->field('address', __('Address'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('product_status', __('Product status'));

        $show->orderProducts('订单商品', function ($orderProducts) {
            $orderProducts->id('id');
            $orderProducts->product_name('product.title');
            $orderProducts->spec_name('spec_id');
            $orderProducts->num('num');
            $orderProducts->price('price');

            $orderProducts->disableCreateButton();
            $orderProducts->disableFilter();
            $orderProducts->disableExport();
            $orderProducts->disableColumnSelector();
            $orderProducts->disablePagination();
            $orderProducts->disableRowSelector();

            $orderProducts->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });
        });

        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());

        $form->number('user_id', __('User id'));
        $form->number('order_no', __('Order no'));
        $form->decimal('origin_price', __('Origin price'));
        $form->decimal('actual_price', __('Actual price'));
        $form->decimal('postage', __('Postage'));
        $form->number('group_id', __('Group id'));
        $form->number('integral', __('Integral'));
        $form->decimal('discount', __('Discount'));
        $form->text('address', __('Address'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->switch('product_status', __('Product status'));
        $form->switch('status', __('Status'));

        return $form;
    }
}
