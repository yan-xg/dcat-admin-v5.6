<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{

    protected $table = 'order_cart';

    /**
     * 关联用户
     **/
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 关联商品
     **/
    public function goods()
    {
        return $this->belongsTo(Goods::class,'goods_id');
    }

}
