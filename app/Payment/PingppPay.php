<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/30
 * Time: 21:48
 */

namespace App\Payment;

use Illuminate\Support\Facades\Session;
use Pingpp\Charge;
use Pingpp\Error\Base;
use Pingpp\Pingpp;

class PingppPay implements PaymentInterface
{
    public function __construct()
    {
        Pingpp::setApiKey(env('PING_API_KEY'));
        Pingpp::setPrivateKeyPath( storage_path().'/app/ca/ping_rsa_private_key.pem');
    }

    public function charge(array $data)
    {
        // TODO: Implement charge() method.
        try {
            $product_id = $this->generateOrderNo();
            return Charge::create([
                'order_no'  => $product_id,
                'app'       => array('id' => env('PING_APP_ID')),
                'channel'   => $data['channel'],
                'amount'    => $data['fee'], // 分
                'client_ip' => \Request::ip(),
                'currency'  => 'cny',
                'subject'   => $data['subject'],
                'body'      => $data['body'],
                'extra'     => $this->generateExtra($data['channel'], $product_id)
            ]);
        } catch(Base $e) {
            Session::flash('pay_error', $e->getMessage());
            return redirect()->refresh();
        }
    }

    protected function generateOrderNo()
    {
        return time().rand(1000, 9999);
    }

    protected function generateExtra($channel, $product_id = 0)
    {
        $extra = [];
        switch ($channel) {
            case 'alipay_pc_direct':
                $extra['success_url'] = trim(env('APP_URL'), '/') .'/payment/success';
                break;
            case 'wx_pub_qr':
                $extra['product_id'] = $product_id;
                break;
            case 'wx_wap':
                $extra['result_url'] = trim(env('APP_URL'), '/') .'/payment/success';
        }

        return $extra;
    }
}