@extends('layouts.basic', [
    'meta_description' => 'ping++ 支付',
])

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
@stop

@section('content')

@stop

@section('scripts')
    <script src="{{ asset('js/pingpp.js') }}"></script>

    <script type="text/javascript">

        var charge = {!! $charge !!}

        // 在支付页调用支付：
        pingpp.createPayment(charge, function(result, err) {
            // object 需是 Charge/Order/Recharge 的 JSON 字符串
            // 可按需使用 alert 方法弹出 log
            // console.log(result);
            // console.log(err.msg);
            // console.log(err.extra);
            if (result == "success") {
                // 只有微信JSAPI (wx_pub)、QQ 公众号 (qpay_pub)支付成功的结果会在这里返回，其他的支付结果都会跳转到 extra 中对应的 URL
            } else if (result == "fail") {
                // Ping++ 对象不正确或者微信JSAPI / QQ公众号支付失败时会在此处返回
            } else if (result == "cancel") {
                // 微信JSAPI支付取消支付
            }
        });
    </script>


@stop