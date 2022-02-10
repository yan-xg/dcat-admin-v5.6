<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{
	
    use SoftDeletes;

    protected $table = 'order_cart';
    
}
