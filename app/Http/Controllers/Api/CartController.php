<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\OrderCart;

class CartController extends ApiController
{
    public function cartAdd(Request $request){
        $user_id = $request->input('user_id');
        $goods_id = $request->input('goods_id');
        $goods_amount = $request->input('goods_amount');

        $rules = [
            'user_id' => 'required',
            'goods_id' => 'required|integer|min:1',
            'goods_amount' => 'required|integer|min:1',
        ];
        $messages = [
            'user_id.required'=>'用户id丢失',
            'goods_id.required'=>'商品ID丢失',
            'goods_amount.required'=>'参数丢失',
            'goods_id.min'=>'商品ID必须大于0',
            'goods_amount.min'=>'数量必须大于0',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $user_id = getUserId($user_id);
        $where['id'] = $goods_id;
        $goods = Goods::where($where)->select(['goods_name','goods_price'])->first();
        $date = date('Y-m-d H:i:s',time());

        $orderWhere['user_id'] = $user_id[0];
        $orderWhere['goods_id'] = $goods_id;
        $orderinfo = OrderCart::where($orderWhere)->first();
        if($orderinfo){
            $amount = $orderinfo->goods_amount + $goods_amount;
            // 更新
            $res = OrderCart::where($orderWhere)->update([
                'goods_amount' => $amount,
            ]);

        }else{
            $amount = $goods_amount;
            // 新增
            $res = OrderCart::insert([
                'user_id' => $user_id[0],
                'goods_id' => $goods_id,
                'goods_amount' => $goods_amount,
                'goods_price' => $goods->goods_price,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        $data['goodsCount'] = $amount;
        $data['res'] = $res;

        return $this->success($data);
    }

    public function goodsCount(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $goods_id = $request->input('goods_id');

        $orderWhere['user_id'] = $user_id[0];
        $orderWhere['goods_id'] = $goods_id;
        $orderinfo = OrderCart::where($orderWhere)->first();
        $data['goodsCount'] = ($orderinfo) ? $orderinfo['goods_amount'] : 0;
        return $this->success($data);
    }
}
