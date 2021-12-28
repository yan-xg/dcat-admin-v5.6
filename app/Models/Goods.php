<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public function pic()
    {
        return $this->hasOne(Pic::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
