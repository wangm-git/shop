<?php

namespace App\Admin\Controllers;

use App\Model\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('wxname', __('Wxname'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('phone', __('Phone'));

        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });


        // $grid->disableCreateButton();
        // $grid->disableActions();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('wxname', __('Wxname'));
        $show->field('avatar', __('Avatar'));
        $show->field('phone', __('Phone'));
        $show->field('openid', __('Openid'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->text('wxname', __('Wxname'));
        $form->image('avatar', __('Avatar'));
        $form->text('phone', __('Phone'));
        $form->text('openid', __('Openid'));

        return $form;
    }
}
