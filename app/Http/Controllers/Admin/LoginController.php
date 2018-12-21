<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout'); //冒号后面的admin作为参数传给中间件的$guard形参
    }

    /**
   * 重写登录视图页面
   */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * 自定义认证驱动
     * @return mixed
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * 重写验证时使用的用户名字段
     */
    public function username()
    {
        return 'name';//默认为使用邮箱验证，这里可以改成用户名
    }

    /**
     * 重写退出登录
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->forget($this->guard()->getName());
        $request->session()->regenerate();

        return redirect('/admin');
    }
}
