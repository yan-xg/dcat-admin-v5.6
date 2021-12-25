<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Category(), function (Grid $grid) {
            $grid->id('ID')->bold()->sortable();
            $grid->title->tree(); // 开启树状表格功能
            $grid->order->orderable();

            $grid->created_at;
            $grid->updated_at->sortable();

            $grid->disableEditButton();     //禁用编辑按钮
            $grid->showQuickEditButton();   //显示快速编辑按钮
            $grid->enableDialogCreate();    //启用对话框创建
            $grid->disableBatchDelete();    //禁用批量删除
            $grid->disableViewButton();     //禁用查看按钮

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');
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
        return Show::make($id, new Category(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('order');
            $show->field('title');
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
        return Form::make(new Category(), function (Form $form) {
            $form->display('id');
            $form->select('parent_id')->options(['0','1','2'])->required();
            $form->text('order');
            $form->text('title')->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
