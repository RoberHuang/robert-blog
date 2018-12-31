<?php
/**
 * Created by PhpStorm.
 * User: Robert
 * Date: 2018/12/30
 * Time: 22:22
 */

namespace App\Payment;


interface PaymentInterface
{
    public function charge(array $data);
}