<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'cate_name', 'cate_title', 'cate_keywords', 'cate_description', 'cate_frequency', 'cate_order', 'cate_pid',
    ];
}
