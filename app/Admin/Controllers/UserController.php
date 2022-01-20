<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use App\Models\UserAddress;
use App\Admin\Renderable\AmUserAddress;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    public $gender;
    public $status;
    public function __construct()
    {
        $this->gender = config('dictionary.user.gender');
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
            $grid->column('nickname');
            $grid->column('avatar_url')->image('','50','50');
            $grid->column('gender')->select($this->gender);
            $grid->column('ipone');
            $grid->column('address','地址')->display('我的地址')->modal('我的地址', function (Grid\Displayers\Modal $modal){
                return AmUserAddress::make()->payload(['uid'=>$this->id]);
            });
            $grid->column('status')->radio($this->status);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();


            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('nickname');

            });

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->selectOne('gender', '性别', $this->gender);
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
            $show->field('nickname');
            $show->field('password');
            $show->field('email');
            $show->field('avatar_url');
            $show->field('gender');
            $show->field('ipone');
            $show->field('openid');
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
            $form->text('nickname')->required();
            $form->password('password');
            $form->email('email');
            $form->image('avatar_url')
                ->accept('jpg,png,gif,jpeg', 'image/*')
                ->autoUpload()
                ->maxSize(1024)
                ->help('只能上传图片,且大小不能超过1MB');
            $form->radio('gender')->options($this->gender)->default(0);
            $form->mobile('ipone');
            $form->radio('status')->options($this->status)->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
