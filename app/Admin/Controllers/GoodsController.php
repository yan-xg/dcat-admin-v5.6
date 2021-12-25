<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Goods;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GoodsController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Goods(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('category_id');
            $grid->column('goods_name');
            $grid->column('goods_shorttitle');
            $grid->column('goods_keywords');
            $grid->column('goods_property');
            $grid->column('goods_description');
            $grid->column('goods_price');
            $grid->column('goods_original_price');
            $grid->column('goods_cost');
            $grid->column('goods_sell_num');
            $grid->column('goods_stock');
            $grid->column('status');
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
        return Show::make($id, new Goods(), function (Show $show) {
            $show->field('id');
            $show->field('category_id');
            $show->field('goods_name');
            $show->field('goods_shorttitle');
            $show->field('goods_keywords');
            $show->field('goods_property');
            $show->field('goods_description');
            $show->field('goods_price');
            $show->field('goods_original_price');
            $show->field('goods_cost');
            $show->field('goods_sell_num');
            $show->field('goods_stock');
            $show->field('status');
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
        return Form::make(new Goods(), function (Form $form) {
            $form->display('id');
            $form->text('category_id');
            $form->text('goods_name');
            $form->text('goods_shorttitle');
            $form->text('goods_keywords');
            $form->text('goods_property');
            $form->text('goods_description');
            $form->text('goods_price');
            $form->text('goods_original_price');
            $form->text('goods_cost');
            $form->text('goods_sell_num');
            $form->text('goods_stock');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
