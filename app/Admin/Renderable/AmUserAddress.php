<?php

namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Model;

class AmUserAddress extends LazyRenderable
{
    public function grid(): Grid
    {
        $uid = $this->uid;
        return Grid::make(UserAddress::where('uid','=',$uid), function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();
            $grid->column('shipping_user','收货人');
            $grid->column('shipping_ipone','手机号');
            $grid->column('province','身份');
            $grid->column('city','城市');
            $grid->column('district','区县');
            $grid->column('address','具体地址')->limit(10);
            $grid->column('is_default','是否默认')->display(function ($default){
                return $this->is_default ? '是' : '否';
            });
            $grid->column('updated_at')->sortable();

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('shipping_user','收货人')->width(4);
                $filter->like('shipping_ipone','手机号')->width(4);
                $filter->like('address','具体地址')->width(4);
            });
        });
    }
}
