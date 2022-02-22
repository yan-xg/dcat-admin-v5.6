<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\UserAddress;
use App\Models\Goods;
use App\Models\OrderCart;
use App\Models\Order;
use App\Models\OrderDetail;
use EasyWeChat\Factory;

class OrderController extends ApiController
{
    public function orderGoods(Request $request){
        $orderId = $request->input('orderId');
        $addType = $request->input('addType');
        $goodId = $request->input('goodId');
        $amount = $request->input('amount');
        $user_id = getUserId($request->input('user_id'));

        if($orderId == 0){ // 未生成订单
            switch ($addType){
                case 0: // 购物车
                    $where['user_id'] = $user_id[0];
                    $where['checked'] = 1;
                    $Cart = OrderCart::where($where)->get();
                    foreach ($Cart as $v){
                        $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($v->goods_id);
                        foreach ($good->goodsPic as $pk=>$pv){
                            if($pk == 0) $good['pic_url'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                        }
                        $good['number'] = $v->goods_amount;
                        $data['GoodsList'][] = $good;
                    }
                    break;
                case 1: // 商品详情
                    if($goodId<=0 || empty($goodId)) return $this->fail('参数丢失');
                    if($amount<=0 || empty($amount)) return $this->fail('参数丢失');

                    $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($goodId);
                    foreach ($good->goodsPic as $pk=>$pv){
                        if($pk == 0) $good['pic_url'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                    }
                    $good['number'] = $amount;
                    $data['GoodsList'][] = $good;
                    break;
                default:
                    return false;
            }

        }elseif($orderId > 0){ //已生成订单
            return false;
        }
        return $this->success($data);
    }

    public function orderSubmit(Request $request){
        $user_id = getUserId($request->input('user_id'));
        $addressId = $request->input('addressId');
        $postscript = $request->input('postscript');// 备注
        $freightPrice = $request->input('freightPrice');// 运费
        $actualPrice = $request->input('actualPrice');// 订单金额
        $payMethod = $request->input('payMethod');// 支付方式
        $addType = $request->input('addType');// 下单方式（0购物车提交，1商品提交）
        $goodId = $request->input('goodId');// 商品id
        $amount = $request->input('amount');// 数量

        $addressInfo  = UserAddress::find($addressId);
        if(empty($addressInfo) || !$addressInfo){
            return $this->fail('请选择收货地址');
        }
        $province = DB::table('region')->find($addressInfo->province_id);
        $city = DB::table('region')->find($addressInfo->city_id);
        $citydistrict = DB::table('region')->find($addressInfo->district_id);
        $osn = $this->getOrderSn();

        $orderData['order_sn'] = $osn;
        $orderData['user_id'] = $user_id[0];
        $orderData['remark'] = $postscript;
        $orderData['order_status'] = 101;
        $orderData['consignee_name'] = $addressInfo['name'];
        $orderData['consignee_mobile'] = $addressInfo['mobile'];
        $orderData['province'] = $province->name;
        $orderData['city'] = $city->name;
        $orderData['district'] = $citydistrict->name;
        $orderData['address'] = $addressInfo->address;
        $orderData['payment_method'] = $payMethod;
        $orderData['order_money'] = $actualPrice;
        $orderData['district_money'] = 0;
        $orderData['freight_money'] = $freightPrice;
        $orderData['created_at'] = date('Y-m-d H:i:s',time());

        //订单商品详情
        switch ($addType){
            case 0: //购物车结算
                $where['user_id'] = $user_id[0];
                $where['checked'] = 1;
                $Cart = OrderCart::where($where)->get();
                foreach ($Cart as $v){
                    $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($v->goods_id);
                    $detail['order_sn'] = $osn;
                    $detail['goods_id'] = $v->goods_id;
                    $detail['goods_name'] = $good->goods_name;
                    $detail['goods_count'] = $v->goods_amount;
                    $detail['goods_price'] = $good->goods_price;
                    foreach ($good->goodsPic as $pk=>$pv){
                        if($pk == 0) $detail['goods_pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                    }
                    $detailData[] = $detail;
                }
                break;
            case 1: //商品页购买结算
                $good = Goods::select(['id','goods_name','goods_price','goods_stock','goods_unit','status'])->find($goodId);
                $detail['order_sn'] = $osn;
                $detail['goods_id'] = $goodId;
                $detail['goods_name'] = $good->goods_name;
                $detail['goods_count'] = $amount;
                $detail['goods_price'] = $good->goods_price;
                foreach ($good->goodsPic as $pk=>$pv){
                    if($pk == 0) $detail['goods_pic'] = config('dictionary.goods.goods_url').'/'.$pv->pic_url;
                }
                $detailData = $detail;
                break;
            default:
                return false;
        }

        DB::beginTransaction();
        try {
            DB::table('order')->insert($orderData);
            DB::table('order_detail')->insert($detailData);

            DB::commit();
        }
        catch(\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return $this->fail('Failed, please contact supervisor');
        }

    }

    public function getOrderSn(){
        $osn = date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        return $osn;
    }
}
