<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends ApiController
{
    public function getRegion(Request $request){
        $parentId = $request->input('parentId');
        if(!empty($parentId)){
            $where['parent_id'] = $parentId;
        }
        $list = DB::table('region')->where($where)->get();
        return $this->success($list);
    }
}
