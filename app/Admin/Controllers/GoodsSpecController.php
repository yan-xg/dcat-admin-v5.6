<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GoodsSpec;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GoodsSpecController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GoodsSpec(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('goods_id');
            $grid->column('goods_key');
            $grid->column('goods_value');
            $grid->column('goods_desc');
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
        return Show::make($id, new GoodsSpec(), function (Show $show) {
            $show->field('id');
            $show->field('goods_id');
            $show->field('goods_key');
            $show->field('goods_value');
            $show->field('goods_desc');
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
        return Form::make(new GoodsSpec(), function (Form $form) {
            $form->display('id');
            $form->text('goods_id');
            $form->text('goods_key');
            $form->text('goods_value');
            $form->text('goods_desc');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
