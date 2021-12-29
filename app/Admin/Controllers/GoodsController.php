<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Goods;
use App\Models\GoodsSpec;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form\NestedForm;
use App\Admin\Actions\Post\Restore;
use App\Admin\Actions\Post\BatchRestore;

class GoodsController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Goods('category'), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('category.title','类别')->label('default');
            $grid->column('goods_name')->limit(15);
            $grid->column('goods_shorttitle');
            $grid->column('goods_price');
            $grid->column('goods_original_price');
            $grid->column('goods_cost');
            $grid->column('goods_sell_num');
            $grid->column('goods_stock');
            $grid->column('status')->switch();
            $grid->column('created_at','上架时间');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('goods_name');

                $filter->scope('trashed', '回收站')->onlyTrashed();

            });

            // 单行恢复操作
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(\App\Models\Goods::class));
                }
            });

            // 批量恢复操作
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(\App\Models\Goods::class));
                }
            });


            $grid->disableViewButton();     //禁用查看按钮
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

        return Form::make(new Goods(['goodsPic','goodsSpec']), function (Form $form) {
            $form->disableListButton();     //禁用列表按钮
            $form->display('id');

            $form->tab('基本信息', function (Form $form) {
                $form->column(6, function (Form $form) {
                    $categoryModel = config('admin.database.category_model');

                    $form->select('category_id')->options($categoryModel::selectOptions())->required();
                    $form->text('goods_name')->required()->saveAsString();
                    $form->text('goods_shorttitle')->saveAsString();
                    $form->tags('goods_keywords')->help('插入逗号(,)后回车，隔开字符')->saveAsString();
                    $form->checkbox('goods_property')
                        ->options([1 => '推荐', 2 => '新品', '3' => '热卖'])
                        ->saving(function ($value) {
                            // 转化成json字符串保存到数据库
                            return json_encode($value);
                        })->canCheckAll();
                });

                $form->column(6, function (Form $form) {
                    $form->currency('goods_price')->required();
                    $form->currency('goods_original_price');
                    $form->currency('goods_cost');
                    $form->number('goods_sell_num');
                    $form->number('goods_stock');
                    $form->switch('status')->default(1);
                });

            })->tab('描述', function (Form $form) {

                $form->editor('goods_description')->saveAsString();

            })->tab('商品图片', function (Form $form) {

                $form->hasMany('goods_pic','商品图', function (Form\NestedForm $form) {
                    $form->image('pic_url','图片')
                        ->accept('jpg,png,gif,jpeg', 'image/*')
                        ->autoUpload()
                        ->maxSize(1024)
                        ->uniqueName()
                        ->disk('goods_uploads')
                        ->saveAsJson()->help('只能上传图片');

                    $form->text('pic_desc','描述');
                    $form->number('pic_order','排序');
                    $form->switch('is_master','是否主图')->default(0);
                })->useTable();

            })->tab('规格',function (Form $form){

                $form->hasMany('goods_spec','商品规格', function (Form\NestedForm $form) {
                    $form->text('goods_key','规格名称');
                    $form->text('goods_value','规格值');
                    $form->text('goods_desc','规格描述');
                })->useTable();

            });
            $form->display('created_at');
            $form->display('updated_at');
            $form->display('deleted_at');

            $form->disableViewButton();
            $form->disableCreatingCheck();
            $form->disableViewCheck();
        });
    }
}
