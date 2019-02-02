<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Payment\PaymentInterface;
use App\Repositories\Contracts\GoodRepository;
use Illuminate\Http\Request;
use Pingpp\Util\Util;

/**
 * Class PaymentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PaymentsController extends CommonController
{
    protected $payment;

    /**
     * @var GoodRepository
     */
    protected $good_repository;

    /**
     * PaymentsController constructor.
     *
     * @param PaymentInterface $payment
     * @param GoodRepository $good_repository
     */
    public function __construct(PaymentInterface $payment, GoodRepository $good_repository)
    {
        parent::__construct();

        $this->payment = $payment;
        $this->good_repository = $good_repository;
    }

    /**
     * 支付页面
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $goods = $this->good_repository->find($id);

        return view($this->layout.'.payments.show', $goods);
    }

    /**
     * 支付
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay(Request $request)
    {
        //$payment = app('App\Payment\PaymentInterface');
        $goods = $this->good_repository->find($request->get('id'));
        $charge = $this->payment->charge([
            'fee' => (int)$goods['data']['price'] * 100,   // 分
            'channel'   => $request->get('channel'),
            'subject'   => $goods['data']['subject'],
            'body'      => '1_'.$goods['data']['id'],
        ]);

        return view($this->layout.'.payments.pay', compact('charge'));
    }

    public function paySuccess(Request $request)
    {
        if ($this->isFromAlipay($request->get('notify_id'))) {
            Session::flash('paid_success', '支付成功');

            return redirect('/goods');
            //return redirect('/index')->with('paid_success', '支付成功');
        }

        return 'fail';
    }

    /**
     * 监听并接收 Webhooks 通知
     */
    public function notify()
    {
        // Webhooks 通知是以 POST 形式发送的 JSON，放在请求的 body 里，内容是 Event 对象
        $rawData = file_get_contents('php://input');
        $result = $this->verifyPing($rawData);

        if ($result == 1) {
            $event = json_decode($rawData, true);

            if (!isset($event['type'])) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                exit("fail");
            }

            switch ($event['type']) {
                // 支付成功的事件类型为 charge.succeeded
                case "charge.succeeded":
                    // 在此处加入对支付异步通知的处理代码
                    $this->createOrder($event['data']['object']);
                    http_response_code(200);
                    //header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                    break;
                case "refund.succeeded":
                    // 在此处加入对退款异步通知的处理代码
                    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                    break;
                default:
                    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                    break;
            }
        }
        $this->verifyPingFail($result);
    }

    protected function isFromAlipay($notify_id)
    {
        $url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner='.env('ALIPAY_PID').'&notify_id='. $notify_id;

        $response = $this->httpGet($url);

        return (bool) preg_match("/true$/i", $response);
    }

    protected function verifyPing($rawData)
    {
        $headers = Util::getRequestHeaders();//这是Ping++的package提供的
        $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        $publicKeyContents = file_get_contents(storage_path(). '/app/ca/ping_rsa_public_key.pem');//注意这里面的文件路径相对应
        // $signature:从 header 取出签名字段并对其进行 base64 解码
        // $rawData:获取 Webhooks 请求的原始数据
        // 将获取到的 Webhooks 通知、 Ping++ 管理平台提供的 RSA 公钥、和 base64 解码后的签名三者一同放入 RSA 的签名函数中进行非对称的签名运算，来判断签名是否验证通过。
        return openssl_verify($rawData, base64_decode($signature), $publicKeyContents, 'sha256');
    }

    protected function verifyPingFail($result)
    {
        if ( $result === 0 ) {
            http_response_code(400);
            echo 'verification failed';
            exit;
        }
        http_response_code(400);
        echo 'verification error';
        exit;
    }

    protected function createOrder($charge)
    {
        $repository = app('App\Repositories\Contracts\OrderRepository');

        $bodies = explode('_', $charge['body']);
        $repository->create([
            'billing_id' => $charge['id'],
            'subject' => $charge['subject'],
            'type' => $charge['object'],
            'order_no' => $charge['transaction_no'],
            'user_id' => $bodies[0],
            'goods_id' => $bodies[1],
        ]);
    }
}
