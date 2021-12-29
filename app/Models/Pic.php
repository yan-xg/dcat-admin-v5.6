<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{

    protected $table = 'pic';
    protected $fillable = ['pic_desc','pic_url','is_master','pic_order','pic_status'];

    public function goods()
    {
        return $this->belongsTo(Goods::class,'goods_id');
    }

}
