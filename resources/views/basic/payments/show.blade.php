@extends('layouts.basic', [
    'meta_description' => '购买页面',
])

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">购买商品</h3>
                </div>
                <div class="card-body">

                    @include('common.partials.errors')

                    <form role="form" method="POST" action="/payments">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">

                        <div class="form-group row">
                            <label for="channel" class="col-md-3 control-label">支付方式</label>
                            <div class="col-md-2">
                                <input type="radio" class="form-control" name="channel" id="channel" value="alipay_pc_direct">
                            </div>
                            <div class="col-md-2">
                                支付宝
                            </div>
                            <div class="col-md-2">
                                <input type="radio" class="form-control" name="channel" id="channel" value="wx_wap">
                            </div>
                            <div class="col-md-2">
                                微信
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-md-3 control-label">商品</label>
                            <div class="col-md-3">
                                <p class="form-control-plaintext">{{ $data['subject'] }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-3 control-label">价格</label>
                            <div class="col-md-3">
                                <p class="form-control-plaintext">{{ $data['price'] }} 元</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-7 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-plus-circle"></i>
                                    购买
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@stop
