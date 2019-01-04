<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'body'];
}
