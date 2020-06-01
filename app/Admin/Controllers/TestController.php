<?php

namespace App\Admin\Controllers;

use App\Model\Test;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class TestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Test';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Test());
        $grid->model()->orderby('id','desc');

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('pic', __('image'))->image();
        $grid->column('content', __('content'));
        $grid->column('email', __('email'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Test::findOrFail($id));

        $show->field('id', ('Id'));
        $show->field('name', ('Name'));
        $show->field('email', ('Email'));
        $show->avatar('pic', ('pic'))->image();
        $show->field('content', ('content'));
        $show->field('created_at', ('Created at'));
        $show->field('updated_at', ('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Test());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->image('pic', __('Pic'));
        $form->textarea('content', __('Content'));

        return $form;
    }
}
