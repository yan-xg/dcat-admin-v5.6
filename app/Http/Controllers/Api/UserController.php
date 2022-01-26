<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends ApiController
{
    public function userSetting(Request $request){
        $rules = [
            'name' => 'required',
            'mobile' => 'required|unique:investor',
            'mobile' => 'regex:/^1[345789][0-9]{9}$/',
            'uid' => 'required',
        ];
        $messages = [
            'name.required'=>'名称必填',
            'uid.required'=>'参数丢失',
            'mobile.required'=>'手机号必填',
            'mobile.regex'=>'手机号格式不对',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $uid = getUserId($request->input('uid'));
        $name = $request->get('name');
        $mobile = $request->get('mobile');

        // 更新
        $res = User::where('id', $uid[0])->update(
            [
                'real_name' => $name,
                'ipone' => $mobile
            ]
        );
        return $this->success($res);
    }

    public function userDetail(Request $request){
        $uid = $request->input('uid');
        if(!empty($uid)){
            $uid = getUserId($uid);
            $user = User::where('id',$uid[0])->select(['real_name','ipone'])->first();
            if($user){
                return $this->success($user);
            }
        }
        return $this->fail();
    }
}
