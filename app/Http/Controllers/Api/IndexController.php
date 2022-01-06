<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Goods;
use App\Models\Category;

class IndexController extends ApiController
{
    public function index(){
        $filed = ['id','category_id','goods_name','goods_shorttitle','goods_price','goods_stock','goods_property'];
        $where['status'] = 1;
        // 首页banner展示推荐的4个商品
        $banner = Goods::where($where)->whereRaw('FIND_IN_SET(1,`goods_property`)')->select($filed)->limit(4)->orderBy('id','desc')->get();
        foreach ($banner as $bk=>$bv){
            foreach ($bv->goodsPic as $pk=>$pv){
                if($pk == 0){
                    $banner[$bk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
            }
        }

        $category = Category::select('id','title','icon')->where('parent_id','=','0')->orderBy('order','asc')->get();
        foreach ($category as $ck=>$cv){
            $cv->icon = env('APP_URL').'/storage/'.$cv->icon;
            $where['category_id'] = $cv->id;

            //每个分类模块下展示新品的6个
            $goods = Goods::where($where)->whereRaw('FIND_IN_SET(2,`goods_property`)')->select($filed)->limit(6)->get();
            foreach ($goods as $gk=>$gv){
                foreach ($gv->goodsPic as $pk=>$pv){
                    if($pk == 0){
                        $goods[$gk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                    }
                }
            }

            $category[$ck]['goodsList'] = $goods;
        }
        $data['categoryList'] = $category;
        $data['banner'] = $banner;
        return $this->success($data);
    }
}
