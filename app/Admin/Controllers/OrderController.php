<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_sn');
            $grid->column('user_id');
            $grid->column('remark');
            $grid->column('order_status');
            $grid->column('consignee_name');
            $grid->column('consignee_mobile');
            $grid->column('province');
            $grid->column('city');
            $grid->column('district');
            $grid->column('address');
            $grid->column('payment_method');
            $grid->column('order_money');
            $grid->column('district_money');
            $grid->column('freight_money');
            $grid->column('payment_money');
            $grid->column('pay_time');
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
        return Show::make($id, new Order(), function (Show $show) {
            $show->field('id');
            $show->field('order_sn');
            $show->field('user_id');
            $show->field('remark');
            $show->field('order_status');
            $show->field('consignee_name');
            $show->field('consignee_mobile');
            $show->field('province');
            $show->field('city');
            $show->field('district');
            $show->field('address');
            $show->field('payment_method');
            $show->field('order_money');
            $show->field('district_money');
            $show->field('freight_money');
            $show->field('payment_money');
            $show->field('pay_time');
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
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('order_sn');
            $form->text('user_id');
            $form->text('remark');
            $form->text('order_status');
            $form->text('consignee_name');
            $form->text('consignee_mobile');
            $form->text('province');
            $form->text('city');
            $form->text('district');
            $form->text('address');
            $form->text('payment_method');
            $form->text('order_money');
            $form->text('district_money');
            $form->text('freight_money');
            $form->text('payment_money');
            $form->text('pay_time');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
