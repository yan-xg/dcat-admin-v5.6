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
        return Grid::make(UserAddress::where('uid','=',$uid)->with(['province','city','district']), function (Grid $grid) {
            $grid->column('id', 'ID')->sortable();
            $grid->column('name','收货人');
            $grid->column('mobile','手机号');
            $grid->column('province.name','省份');
            $grid->column('city.name','城市');
            $grid->column('district.name','区县');
            $grid->column('address','具体地址')->limit(10);
            $grid->column('is_default','是否默认')->display(function ($default){
                return $this->is_default ? '是' : '否';
            });
            $grid->column('updated_at')->sortable();

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name','收货人')->width(4);
                $filter->like('mobile','手机号')->width(4);
                $filter->like('address','具体地址')->width(4);
            });
        });
    }
}
