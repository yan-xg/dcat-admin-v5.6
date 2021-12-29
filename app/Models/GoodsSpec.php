<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GoodsSpec extends Model
{

    protected $table = 'goods_spec';
    protected $fillable = ['goods_key', 'goods_value', 'goods_desc'];

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id');
    }
}
