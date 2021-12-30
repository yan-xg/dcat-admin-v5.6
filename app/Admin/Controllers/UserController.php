<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use App\Models\UserAddress;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    public $sex;
    public $status;
    public function __construct()
    {
        $this->sex = config('dictionary.user.sex');
        $this->status = config('dictionary.user.status');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('headimg')->image('','50','50');
            $grid->column('sex')->select($this->sex);
            $grid->column('ipone');
            $grid->column('address','地址')->display('我的地址')->modal('我的地址', UserAddress::make());
            $grid->column('status')->radio($this->status);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');

            });

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->selectOne('sex', '性别', $this->sex);
                $selector->selectOne('status', '状态', $this->status);
            });

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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('password');
            $show->field('email');
            $show->field('remember_token');
            $show->field('headimg');
            $show->field('sex');
            $show->field('ipone');
            $show->field('appid');
            $show->field('token');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->password('password');
            $form->email('email');
            $form->image('headimg')
                ->accept('jpg,png,gif,jpeg', 'image/*')
                ->autoUpload()
                ->maxSize(1024)
                ->help('只能上传图片,且大小不能超过1MB');
            $form->radio('sex')->options($this->sex)->default(0);
            $form->mobile('ipone');
            $form->radio('status')->options($this->status)->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
