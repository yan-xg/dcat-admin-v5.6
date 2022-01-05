<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    /**
     * 关联商品图片库
    **/
    public function goodsPic()
    {
        return $this->hasMany(Pic::class,'goods_id')->orderBy('is_master','desc');
    }

    /**
     * 关联商品规格表
    **/
    public function goodsSpec()
    {
        return $this->hasMany(GoodsSpec::class,'goods_id');
    }

    /**
     * 关联商品类型（反向）
    **/
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
