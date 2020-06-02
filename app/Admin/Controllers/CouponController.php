<?php

namespace App\Admin\Controllers;

use App\Model\Coupon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\Coupon';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupon());

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('max', __('Max'));
        $grid->column('reduce', __('Reduce'));
        $grid->column('discount', __('Discount'));
        $grid->column('expire_at', __('Expire at'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Coupon::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('max', __('Max'));
        $show->field('reduce', __('Reduce'));
        $show->field('discount', __('Discount'));
        $show->field('expire_at', __('Expire at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Coupon());

        $form->radio('type', '类型')->options(['1' => '满减', '2'=> '折扣'])->default('1');
        $form->currency('max', '满');
        $form->currency('reduce', '减');
        $form->decimal('discount', '折扣率');
        $form->datetime('expire_at', '到期时间')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
