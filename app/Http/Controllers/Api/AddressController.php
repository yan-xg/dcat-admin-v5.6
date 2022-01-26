<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AddressController extends ApiController
{
    public function getAddresses(Request $request){
        $uid = $request->input('uid');
        $uid = getUserId($uid);
        $address = UserAddress::where('uid',$uid[0])->orderBy('is_default','desc')->get();
        foreach ($address as $k=>$v){
             $region = DB::table('region')
                ->select('name')
                ->whereIn('id',[$v['province_id'],$v['city_id'],$v['district_id']])
                ->get();
             if($region){
                 foreach ($region as $rv){
                     $v['full_region'] .= $rv->name;
                 }
             }
        }
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
        $uid = getUserId($request->input('uid'));
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $province_id = $request->get('province_id');
        $city_id = $request->get('city_id');
        $district_id = $request->get('district_id');
        $address = $request->get('address');
        $is_default = $request->get('is_default');

        if($is_default == 1){
            UserAddress::where('uid', $uid[0])->update(['is_default' => 0]);
        }

        $date = date('Y-m-d H:i:s',time());
        if($id > 0){
            // 更新
            $res = UserAddress::where('id', $id)->update(
                [
                    'uid' => $uid[0],
                    'name' => $name,
                    'mobile' => $mobile,
                    'province_id' => $province_id,
                    'city_id' => $city_id,
                    'district_id' => $district_id,
                    'address' => $address,
                    'is_default' => $is_default,
                    'updated_at' => $date,
                ]
            );
        }else{
            // 新增
            $res = UserAddress::insert([
                'uid' => $uid[0],
                'name' => $name,
                'mobile' => $mobile,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'district_id' => $district_id,
                'address' => $address,
                'is_default' => $is_default,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        if($res){
            return $this->success($res);
        }else{
            return $this->fail($res);
        }
    }

    public function addressDetail(Request $request){
        $rules = [
            'id' => 'required|integer'
        ];
        $messages = [
            'id.integer' => '参数必须为数字'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $id = $request->input('id');
        if($id <= 0){
            return $this->fail('参数错误');
        }

        $data = UserAddress::where('id',$id)->first();
        $province = DB::table('region')->select('name')->where('id',$data['province_id'])->first();
        $city = DB::table('region')->select('name')->where('id',$data['city_id'])->first();
        $district = DB::table('region')->select('name')->where('id',$data['district_id'])->first();

        $data['province_name'] = $province->name;
        $data['city_name'] = $city->name;
        $data['district_name'] = $district->name;
        $data['full_region'] = $province->name . $city->name . $district->name;
        return $this->success($data);
    }

    public function deleteAddress(Request $request){
        $rules = [
            'id' => 'required|integer'
        ];
        $messages = [
            'id.integer' => '参数必须为数字'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $id = $request->input('id');
        if($id <= 0){
            return $this->fail('参数错误');
        }

        $res = UserAddress::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s',time())]);
        return $this->success($res);
    }
}
