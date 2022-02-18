<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\OrderDetail;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderDetailController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OrderDetail(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_sn');
            $grid->column('goods_id');
            $grid->column('goods_name');
            $grid->column('goods_count');
            $grid->column('goods_price');
            $grid->column('goods_pic');
        
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
        return Show::make($id, new OrderDetail(), function (Show $show) {
            $show->field('id');
            $show->field('order_sn');
            $show->field('goods_id');
            $show->field('goods_name');
            $show->field('goods_count');
            $show->field('goods_price');
            $show->field('goods_pic');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new OrderDetail(), function (Form $form) {
            $form->display('id');
            $form->text('order_sn');
            $form->text('goods_id');
            $form->text('goods_name');
            $form->text('goods_count');
            $form->text('goods_price');
            $form->text('goods_pic');
        });
    }
}
