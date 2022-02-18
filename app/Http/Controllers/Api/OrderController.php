<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use Illuminate\Http\Request;
use Validator;
use App\Models\Goods;
use App\Models\OrderCart;

class OrderController extends ApiController
{
    public function orderGoods(Request $request){
        $orderId = $request->input('orderId');
        $addType = $request->input('addType');
        $goodId = $request->input('goodId');
        $amount = $request->input('amount');
        $user_id = getUserId($request->input('user_id'));

        if($orderId == 0){ // 未生成订单
            switch ($addType){
                case 0: // 购物车
                    $where['user_id'] = $user_id[0];
                    $where['checked'] = 1;
                    $Cart = OrderCart::where($where)->get();
                    foreach ($Cart as $v){
                        $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($v->goods_id);
                        foreach ($good->goodsPic as $pk=>$pv){
                            if($pk == 0) $good['pic_url'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                        }
                        $good['number'] = $v->goods_amount;
                        $data['GoodsList'][] = $good;
                    }
                    break;
                case 1: // 商品详情
                    if($goodId<=0 || empty($goodId)) return $this->fail('参数丢失');
                    if($amount<=0 || empty($amount)) return $this->fail('参数丢失');

                    $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($goodId);
                    foreach ($good->goodsPic as $pk=>$pv){
                        if($pk == 0) $good['pic_url'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                    }
                    $good['number'] = $amount;
                    $data['GoodsList'][] = $good;
                    break;
                default:
                    return false;
            }

        }elseif($orderId > 0){ //已生成订单
            return false;
        }
        return $this->success($data);
    }

    public function orderSubmit(){

    }
}
