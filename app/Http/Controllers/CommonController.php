<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = config('web.layout', 'basic');
    }

    protected function httpGet($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);  // 过滤http头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // 显示输出结果
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // SSL证书认证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 严格验证
        curl_setopt($ch, CURLOPT_CAINFO, storage_path() . '/app/ca/cacert.pem'); // 证书地址
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
