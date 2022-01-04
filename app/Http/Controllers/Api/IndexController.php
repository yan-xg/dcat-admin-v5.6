<?php

namespace App\Http\Controllers\Api;

use App\Models\Goods;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    public function index(){

        $where = [];
        $where['status'] = 1;
        $data = Goods::where($where)->select('id','category_id','goods_name','goods_shorttitle','goods_price')->get();
        foreach ($data as $v){
            echo $v->goods_name.'<br>';
            foreach ($v->goodsPic as $v2){
                echo $v2.'---';
            }
        }
        die;
    }
}
