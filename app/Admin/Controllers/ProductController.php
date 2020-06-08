<?php

namespace App\Admin\Controllers;

use App\Model\Product;
use App\Model\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', 'ID');
        $grid->column('title', '商品标题');
        $grid->column('content', '商品描述');
        $grid->column('category.name', '商品分类');
        $grid->column('price', '价格');
        $grid->column('status', '是否上架')->display(function($status){
            return $status ? '是':'否';
        });
        $grid->column('recommend', '是否推荐')->display(function($recommend){
            return $recommend ? '是':'否';
        });
        $grid->column('sale', '销量');
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('category_id', __('Category id'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
        $show->field('sale', __('Sale'));
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
        $form = new Form(new Product());

        $form->text('title', '商品名称')->rules('required');
        $form->editor('content', '商品描述')->rules('required');
        $form->select('category_id', '商品分类')->options(Category::all()->pluck('name', 'id'))->rules('required');
        $form->multipleImage('images', '图片')->pathColumn('path')->removable();
        $form->currency('price', '价格')->rules('required');
        $form->decimal('weight', '重量')->rules('required');
        $form->switch('status', '是否上架')->default(1);
        $form->switch('recommend', '是否推荐')->default(0);

        return $form;
    }
}
