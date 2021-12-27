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
            $grid->column('goods_property');
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
            $form->disableListButton();     //禁用列表按钮
            $form->display('id');

            $form->tab('基本信息', function (Form $form) {
                $form->column(6, function (Form $form) {
                    $categoryModel = config('admin.database.category_model');

                    $form->select('category_id')->options($categoryModel::selectOptions())->required();
                    $form->text('goods_name')->required()->saveAsString();
                    $form->text('goods_shorttitle')->saveAsString();
                    $form->tags('goods_keywords')->help('插入逗号 (,) 隔开的字符')->saveAsString();
                    $form->text('goods_property')->saveAsString();
                });

                $form->column(6, function (Form $form) {
                    $form->decimal('goods_price')->width(3);
                    $form->decimal('goods_original_price')->width(3);
                    $form->decimal('goods_cost')->width(3);
                    $form->number('goods_sell_num');
                    $form->number('goods_stock');
                    $form->radio('status')->options([0=>'下架',1=>'上架'])->default(1);
                });

            })->tab('描述', function (Form $form) {
                $form->editor('goods_description')->saveAsString();
            });
//                ->tab('商品图', function (Form $form) {
//                $form->hasMany('Image', function ($form) {
//                    $form->multipleImage('image')->accept('jpg,png,gif,jpeg', 'image/*')->sortable();
//                });
//            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
