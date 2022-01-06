<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;

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
            return 'error';
            return redirect('post/create')->withErrors($validator)->withInput();
        }

//        $postDate = input::only(['page','size','category_id']);
//        return $category_id;
    }
}
