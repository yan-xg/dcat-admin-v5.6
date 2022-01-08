<?php


namespace App\Http\Controllers\Api;


trait ApiResponse
{

    /**
     * 成功的时候返回结果
     * @param $data 返回数据集合
     */
    public function success($data)
    {
        return $this->api_response('200','操作成功',$data);
    }

    /**
     * 失败的时候返回结果
     */
    public function fail($data)
    {
        return $this->api_response('500','操作失败',$data);
    }

    /**
     * 直接返回说明
     */
    public function message($message)
    {
        return "$message";
    }


    /**
     * 参数返回
     * @param $code 状态码
     * @param $message 返回说明
     * @param $data 返回数据集合
     */
    public function api_response($code, $message, $data)
    {
        $content = [
            'code' => $code,
            'message'  => $message,
            'data' => $data
        ];
        return json_encode($content);
    }

}
