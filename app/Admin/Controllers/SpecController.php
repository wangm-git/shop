<?php

namespace App\Admin\Controllers;

use App\Model\Spec;
use App\Model\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SpecController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品规格';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Spec());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('product.title', 'product name');
        $grid->column('stock', __('Stock'));
        $grid->column('price', __('Price'));
        $grid->column('status', '是否上架')->display(function($status){
            return $status ? '是':'否';
        });
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
        $show = new Show(Spec::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('stock', __('Stock'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Spec());

        $form->text('name', __('Name'))->rules('required');
        $form->select('product_id', '商品')->options(Product::where('status', 1)->get()->pluck('title', 'id'))->rules('required');
        $form->number('stock', __('Stock'))->rules('required');
        $form->currency('price', __('Price'))->rules('required');
        $form->switch('status', __('Status'))->default(1);

        return $form;
    }
}
