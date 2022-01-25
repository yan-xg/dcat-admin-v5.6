<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Region;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class RegionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Region(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('parent_id');
            $grid->column('name');
            $grid->column('type');
            $grid->column('agency_id');
            $grid->column('area');
            $grid->column('area_code');
            $grid->column('far_area');
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
        return Show::make($id, new Region(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('name');
            $show->field('type');
            $show->field('agency_id');
            $show->field('area');
            $show->field('area_code');
            $show->field('far_area');
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
        return Form::make(new Region(), function (Form $form) {
            $form->display('id');
            $form->text('parent_id');
            $form->text('name');
            $form->text('type');
            $form->text('agency_id');
            $form->text('area');
            $form->text('area_code');
            $form->text('far_area');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
