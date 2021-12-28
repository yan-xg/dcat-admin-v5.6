<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{

    protected $table = 'pic';

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

}
