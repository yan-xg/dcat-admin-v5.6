<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use App\Http\lib\wxBizDataCrypt\wxBizDataCrypt;

class WeixinLoginController extends ApiController
{
    public function weixinLogin(){
        $info = input::get('info');

        $appid = env('WECHAT_MINI_PROGRAM_APPID');
        $appSecret = env('WECHAT_MINI_PROGRAM_SECRET');

        $code = $info['code'];
        $iv = str_replace(" ", "+", $info['iv']);
        $signature = $info['signature'];
        $rawData = $info['rawData'];
        $encryptedData = $info['encryptedData'];

        $url = "https://api.weixin.qq.com/sns/jscode2session?" . "appid=" . $appid . "&secret=" . $appSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $access_token = json_decode($this->httpRequest($url), true);
        if (isset($access_token['session_key']) == '') {
            return $this->fail($access_token);
        }
        $sessionKey = $access_token['session_key'];

        //取出json里对应的值
        $signature2 = sha1($rawData . $sessionKey);

        // 验证签名
        if ($signature2 !== $signature) {
            return $this->fail($access_token,'验签失败');
        }

        // 获取解密后的数据
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        if ($errCode != 0) {
            return $this->fail($errCode,'授权失败');
        }

        $datas = json_decode($data, true);
        $datas['token'] = $this->checkAuth($appid, $appSecret);
        $datas['openid'] = $access_token['openid'];

        if ($errCode == 0) {
            $uinfo = User::where('openid', $datas['openid'])->first();
            if (!$uinfo) {
                $arr = [
                    'nickname' => $datas['nickName'],
                    'openid' => $datas['openid'],
                    'token' => $datas['token'],
                    'avatar_url' => $datas['avatarUrl'],
                    'gender' => $datas['gender'],
                    'country' => $datas['country'],
                    'province' => $datas['province'],
                    'city' => $datas['city'],
                    'language' => $datas['language'],
                    'created_at' => date('Y-m-d H:i:s',time()),
                ];
                $datas['uid'] = base64_encode(User::insertGetId($arr).'_'.$datas['openid']);

            } else {
                User::where('openid', $datas['openid'])->update(
                    [
                        'nickname' => $datas['nickName'],
                        'token' => $datas['token'],
                        'avatar_url' => $datas['avatarUrl'],
                        'gender' => $datas['gender'],
                        'country' => $datas['country'],
                        'province' => $datas['province'],
                        'city' => $datas['city'],
                        'language' => $datas['language'],
                    ]
                );
                $datas['uid'] = base64_encode($uinfo['id'].'_'.$uinfo['openid']);
            }
            return $this->success($datas);
        } else {
            return $this->fail($errCode,'授权失败');

        }
    }

    //微信接口调用凭证
    public function checkAuth($appid, $appsecret)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
        $result = $this->httpRequest($url);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || isset($json['errcode'])) {
                return false;
            }
            return $json['access_token'];
        }
        return false;

    }

    /**
     * @param $url
     * @param string $data
     * @param string $method
     * @return bool|string
     */
    public function httpRequest($url, $data = '', $method = 'GET')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
