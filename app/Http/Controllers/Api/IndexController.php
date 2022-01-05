<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Category;

class IndexController extends Controller
{
    public function index(){

        $data = [];
        $where['status'] = 1;

        $category = Category::select('id','title','icon')->where('parent_id','=','0')->orderBy('order','asc')->get();
        foreach ($category as $ck=>$cv){
            $cv->icon = env('APP_URL').'/storage/'.$cv->icon;
            $where['category_id'] = $cv->id;

            $goods = Goods::where($where)->select('id','category_id','goods_name','goods_shorttitle','goods_price')->limit(6)->get();
            foreach ($goods as $gk=>$gv){
                foreach ($gv->goodsPic as $pk=>$pv){
                    if($pk == 0){
                        $goods[$gk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                    }
                }
            }

            $category[$ck]['goodsList'] = $goods;
        }
        $data['data'] = $category;
        return response()->json($data);
    }
}
