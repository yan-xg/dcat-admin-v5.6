<?php

namespace App\Http\Controllers\Api;

use App\Models\Goods;
use Validator;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SearchController extends ApiController
{
    public function index(Request $request){
        return 'ok';
    }

    public function helper(Request $request){
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
        $where['status'] = 1;
        $where[] = ['goods_name', 'like', '%'.$keyword.'%'];

        $goods = Goods::where($where)->get();
        foreach ($goods as $gk=>$gv){
            foreach ($gv->goodsPic as $pk=>$pv){
                if($pk == 0){
                    $goods[$gk]['pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
            }
        }
        return $this->success($goods);
    }
}
