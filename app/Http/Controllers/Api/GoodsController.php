<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\Goods;

class GoodsController extends ApiController
{
    public function count(){
        $data['goodsCount'] = Goods::where('status',1)->count();
        return $this->success($data);
    }
}
