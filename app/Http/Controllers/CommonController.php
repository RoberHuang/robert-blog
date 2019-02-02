<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = config('web.layout', 'basic');
    }
}
