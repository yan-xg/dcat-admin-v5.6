<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\Goods;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;

class GoodsController extends ApiController
{
    public function count(){
        $data['goodsCount'] = Goods::where('status',1)->count();
        return $this->success($data);
    }

    public function searchList(Request $request){
        $rules = [
            'keyword' => 'required',
        ];
        $messages = [
            'keyword.required' => '搜索词不能为空',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $keyword = input::get('keyword');
        $sort = input::get('sort');
        $order = input::get('order');
        $sales = input::get('sales');

        $where['status'] = 1;
        $where[] = ['goods_name', 'like', '%'.$keyword.'%'];

        $sort  = $sort=='default' ? 'id' : $sort;
        $order = $sort=='goods_stock' ? $sales : $order;

        $goods = Goods::where($where)->orderBy($sort, $order)->get();
        foreach ($goods as $gk=>$gv){
            foreach ($gv->goodsPic as $pk=>$pv){
                if($pk == 0){
                    $goods[$gk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
            }
        }
        return $this->success($goods);
    }

    public function detail(Request $request){
        $rules = [
            'gid' => 'required|integer',
        ];
        $messages = [
            'gid.required' => '商品ID不能为空',
            'gid.integer' => '商品ID必须为数字',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $gid = input::get('gid');
        $where['status'] = 1;
        $where['id'] = $gid;
        $goods = Goods::where($where)->first();
        if(!$goods){
            return $this->fail('非法id');
        }
        foreach ($goods->goodsPic as $pv){
            $pv->pic_url = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
        }
        $goods->goodsSpec;

        return $this->success($goods);
    }
}
