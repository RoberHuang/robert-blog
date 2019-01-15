<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'title', 'name', 'type', 'value', 'order', 'content', 'remark'
    ];
}
