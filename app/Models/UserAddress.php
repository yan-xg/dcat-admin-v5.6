<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    use SoftDeletes;

    protected $table = 'users_address';

    /**
     * 关联用户
     **/
    public function user(){
        return $this->belongsTo(User::class,'uid');
    }

}
