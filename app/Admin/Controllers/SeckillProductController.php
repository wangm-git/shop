<?php

namespace App\Admin\Controllers;

use App\Model\SeckillProduct;
use App\Model\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SeckillProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\SeckillProduct';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SeckillProduct());

        $grid->column('id', __('Id'));
        $grid->column('product.title', __('Product id'));
        $grid->column('price', __('Price'));
        $grid->column('stock', __('Stock'));
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
        $show = new Show(SeckillProduct::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_id', __('Product id'));
        $show->field('price', __('Price'));
        $show->field('stock', __('Stock'));
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
        $form = new Form(new SeckillProduct());

        $form->select('product_id', '商品')->options(Product::where('status', 1)->get()->pluck('title', 'id'));
        $form->currency('price', __('Price'));
        $form->number('stock', __('Stock'));
        $form->datetime('start_at', __('start_at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('expire_at', __('Expire at'))->default(date('Y-m-d H:i:s'));


        return $form;
    }
}
