<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    //设置返回路径
    protected $redirectTo = "/";

    public function __construct()
    {
        $this->middleware('guest');
    }

    /*
     * 重新sendResetResponse方法
     */
    protected function sendResetResponse(Request $request, $response)
    {
        session()->flash('success','密码更新成功，你已成功登录!');
        return redirect($this->redirectTo);
    }
}
