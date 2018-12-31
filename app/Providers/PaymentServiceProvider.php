<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // 若更换支付商，只需要在App\Payment下创建对应的类实现PaymentInterface接口，在更改此处的concrete参数即可，控制器代码无需更改
        $this->app->bind('App\Payment\PaymentInterface', 'App\Payment\PingppPay');
    }
}
