<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Pic;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PicController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Pic(), function (Grid $grid) {

            if (request()->get('_view_') !== 'list') {
                // 设置自定义视图
                $grid->view('admin.grid.custom');
                $grid->setActionClass(Grid\Displayers\Actions::class);
            }

            $grid->column('id', __('ID'));
            $grid->column('pic_url')->image();
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->disableBatchActions();
            $grid->disableBatchDelete();
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
        return Show::make($id, new Pic(), function (Show $show) {
            $show->field('id');
            $show->field('goods_id');
            $show->field('pic_desc');
            $show->field('pic_url');
            $show->field('is_master');
            $show->field('pic_order');
            $show->field('pic_status');
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
        return Form::make(new Pic(), function (Form $form) {
            $form->display('id');
            $form->text('goods_id');
            $form->text('pic_desc');
            $form->text('pic_url');
            $form->text('is_master');
            $form->text('pic_order');
            $form->text('pic_status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
