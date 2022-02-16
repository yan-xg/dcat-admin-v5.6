<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\OrderCart;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderCartController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OrderCart(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('goods_id');
            $grid->column('goods_amount');
            $grid->column('goods_price');
            $grid->column('checked');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new OrderCart(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('goods_id');
            $show->field('goods_amount');
            $show->field('goods_price');
            $show->field('checked');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new OrderCart(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('goods_id');
            $form->text('goods_amount');
            $form->text('goods_price');
            $form->text('checked');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
