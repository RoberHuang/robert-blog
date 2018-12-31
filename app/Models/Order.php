<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['billing_id', 'subject', 'type', 'order_no', 'user_id', 'goods_id'];
}
