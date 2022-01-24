<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Validator;

class AddressController extends ApiController
{
    public function getAddresses(Request $request){
        $uid = $request->input('uid');
        $uid = getUserId($uid);
        $address = UserAddress::where('uid',$uid[0])->get();
        return $this->success($address);
    }

    public function saveAddress(Request $request){
        $rules = [
            'name' => 'required',
            'mobile' => 'required|unique:investor',
            'mobile' => 'regex:/^1[345789][0-9]{9}$/',
            'address' => 'required',
        ];
        $messages = [
            'name.required'=>'名称必填',
            'mobile.required'=>'手机号必填',
            'address.required'=>'地址必填',
            'mobile.regex'=>'手机号格式不对',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $id = $request->get('id');
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $province_id = $request->get('province_id');
        $city_id = $request->get('city_id');
        $district_id = $request->get('district_id');
        $address = $request->get('address');
        $is_default = $request->get('is_default');
        return $address;
    }
}
