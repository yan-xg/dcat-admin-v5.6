<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\UserAddress;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserAddressController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserAddress('user'), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user.name','所属用户')->label('primary');
            $grid->column('shipping_user');
            $grid->column('shipping_ipone');
            $grid->column('province');
            $grid->column('city');
            $grid->column('district');
            $grid->column('address')->limit(20);
            $grid->column('is_default')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableEditButton();     //禁用编辑按钮
            $grid->disableViewButton();     //禁用查看按钮
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();    //禁用批量删除
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
        return Show::make($id, new UserAddress(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('shipping_user');
            $show->field('shipping_ipone');
            $show->field('zip');
            $show->field('province');
            $show->field('city');
            $show->field('district');
            $show->field('address');
            $show->field('is_default');
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
        return Form::make(new UserAddress(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('shipping_user');
            $form->mobile('shipping_ipone');
            $form->text('zip');
            $form->text('province');
            $form->text('city');
            $form->text('district');
            $form->text('address');
            $form->switch('is_default')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
