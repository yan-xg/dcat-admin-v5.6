<?php

namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Models\Pic;
use Illuminate\Database\Eloquent\Model;

class GoodsPic extends LazyRenderable
{
    public function grid(): Grid
    {
        $goods_id = $this->goods_id;
        return Grid::make(Pic::where('goods_id','=',$goods_id), function (Grid $grid) {
            if (request()->get('_view_') !== 'list') {
                // 设置自定义视图
                $grid->view('admin.grid.custom');
                $grid->setActionClass(Grid\Displayers\Actions::class);
            }

            $grid->column('id', __('ID'));
            $grid->column('pic_url')->image(config('dictionary.goods.goods_url'));

            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->disableBatchActions();
            $grid->disableBatchDelete();
        });
    }
}
