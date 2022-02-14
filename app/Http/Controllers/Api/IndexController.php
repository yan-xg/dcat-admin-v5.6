<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Goods;
use App\Models\Category;
use App\Models\OrderCart;
use Illuminate\Http\Request;

class IndexController extends ApiController
{
    public function index(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $filed = ['id','category_id','goods_name','goods_shorttitle','goods_price','goods_stock','goods_property'];
        $where['status'] = 1;
        // 首页banner展示推荐的4个商品
//        ->whereRaw('FIND_IN_SET(3,`goods_property`)')
        $banner = Goods::where($where)->select($filed)->limit(4)->orderBy('id','desc')->get();
        foreach ($banner as $bk=>$bv){
            foreach ($bv->goodsPic as $pk=>$pv){
                if($pk == 0){
                    $banner[$bk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
            }
        }

        $category = Category::select('id','title','order','icon')->where('parent_id','=','0')->orderBy('order','asc')->get();
        foreach ($category as $ck=>$cv){
            $cv->icon = ($cv->icon) ? env('APP_URL').'/storage/'.$cv->icon : '';
            $where['category_id'] = $cv->id;

            //每个分类模块下展示新品的6个
//            ->whereRaw('FIND_IN_SET(1,`goods_property`)')
            $goods = Goods::where($where)->select($filed)->limit(6)->get();
            if(count($goods) > 0){
                foreach ($goods as $gk=>$gv){
                    if($gv->goodsPic){
                        foreach ($gv->goodsPic as $pk=>$pv){
                            if($pk == 0 && $pv!=''){
                                $goods[$gk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                            }
                        }
                    }
                }

                $category[$ck]['goodsList'] = $goods;
            }
        }
        $data['categoryList'] = $category;
        $data['banner'] = $banner;
        if(is_array($user_id) && count($user_id) > 0){
            $orderWhere['user_id'] = $user_id[0];
            $orderWhere['checked'] = 1;
            $data['cartCount'] = OrderCart::where($orderWhere)->count();
        }

        return $this->success($data);
    }
}
