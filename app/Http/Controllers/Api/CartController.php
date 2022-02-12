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
        $data['goodsCount'] = OrderCart::where('user_id',$user_id[0])->count();
        $data['res'] = $res;

        return $this->success($data);
    }

    public function goodsCount(Request $request){
        $user_id = getUserId($request->input('user_id'));
//        $goods_id = $request->input('goods_id');

        $orderWhere['user_id'] = $user_id[0];
        $data['goodsCount'] = OrderCart::where($orderWhere)->count();
        return $this->success($data);
    }

    public function getCartData($uid){
        if(empty($uid)){
            return false;
        }

        $cartList = OrderCart::where('user_id',$uid)->get();
        $amount = 0;
        foreach ($cartList as $v){
            $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit'])->find($v->goods_id);
            foreach ($good->goodsPic as $pk=>$pv){
                if($pk == 0){
                    $good['pic_url'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
            }
            $good->goods_id = $v->goods_id;
            $good->number = $v->goods_amount;
            $good->checked = $v->checked;
            $good->is_on_sale = ($good->goods_stock > 0) ? 1 : 0;
            $data['cartList'][] = $good;

            if($v->checked == 1){
                $amount += ($good->goods_price * $v->goods_amount);
            }
        }
        $data['cartTotal']['checkedGoodsCount'] = count($cartList);
        $data['cartTotal']['checkedGoodsAmount'] = $amount;
        $data['cartTotal']['user_id'] = $uid[0];
        return $data;
    }

    public function index(Request $request){
        $uid = getUserId($request->input('uid'));

        $data = $this->getCartData($uid[0]);
        return $this->success($data);
    }

    public function cartUpdate(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $goods_id = $request->input('goods_id');
        $number = $request->input('number');
        $id = $request->input('id');

        $rules = [
            'user_id' => 'required',
            'goods_id' => 'required|integer|min:1',
            'number' => 'required|integer',
        ];
        $messages = [
            'user_id.required'=>'用户id丢失',
            'goods_id.required'=>'商品ID丢失',
            'number.required'=>'参数丢失',
            'goods_id.min'=>'商品ID必须大于0',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $orderWhere['user_id'] = $user_id[0];
        $orderWhere['goods_id'] = $goods_id;
        $res = OrderCart::where($orderWhere)->update([
            'goods_amount' => $number,
        ]);

        $data = $this->getCartData($user_id[0]);
        return $this->success($data);
    }

    public function checked(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $goods_id = explode(',', $request->input('goods_id'));
        $isChecked = $request->input('isChecked');

        $rules = [
            'user_id' => 'required',
            'goods_id' => 'required',
            'isChecked' => 'required|integer',
        ];
        $messages = [
            'user_id.required'=>'用户id丢失',
            'goods_id.required'=>'商品ID丢失',
            'isChecked.required'=>'参数丢失',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $orderWhere['user_id'] = $user_id[0];
        if(count($goods_id) > 1){
            $orderWhere[] = [function($query) use ($goods_id){
                $query->whereIn('goods_id', $goods_id);
            }];
        }else{
            $orderWhere['goods_id'] = $goods_id;
        }

        $res = OrderCart::where($orderWhere)->update([
            'checked' => $isChecked,
        ]);

        $data = $this->getCartData($user_id[0]);
        return $this->success($data);
    }

    public function cartDelete(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $goods_id = $request->input('goods_id');

        $rules = [
            'user_id' => 'required',
            'goods_id' => 'required',
        ];
        $messages = [
            'user_id.required'=>'用户id丢失',
            'goods_id.required'=>'商品ID丢失',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $orderWhere['user_id'] = $user_id[0];
        $orderWhere['goods_id'] = $goods_id;
        $res = OrderCart::where($orderWhere)->delete();

        $data = $this->getCartData($user_id[0]);
        return $this->success($data);
    }
}
