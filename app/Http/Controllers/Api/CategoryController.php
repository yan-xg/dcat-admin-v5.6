<?php

namespace App\Http\Controllers\Api;

use App\Models\Goods;
use Validator;
use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends ApiController
{
    public function list(){
        $list['categoryList'] = Category::where('parent_id',0)->get();
        return $this->success($list);
    }

    public function currentlist(Request $request){
        $rules = [
            'page' => 'required|integer',
            'size' => 'required|integer',
            'category_id' => 'required|integer',
        ];
        $messages = [
            'page.integer' => '页码必须为数字',
            'size.integer' => '数量必须为数字',
            'category_id.integer' => '类别必须为数字',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $where['status'] = 1;
        $category_id = input::get('category_id',0);
        if($category_id != 0){
            $where['category_id'] = $category_id;
        }

        $size = input::get('size',8);
//        $page = input::get('page',1);
//        $offset = ($page-1)*$size;

        $filed = ['id','category_id','goods_name','goods_shorttitle','goods_price','goods_stock','goods_property'];

        $goods = Goods::where($where)->select($filed)->orderBy('id','desc')->paginate($size);
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
