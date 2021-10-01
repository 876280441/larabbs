<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * 验证邮箱中间件
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //有三种判断，如果符合，就到逻辑处理中
        // 1. 如果用户已经登录
        // 2. 并且还未认证 Email
        // 3. 并且访问的不是 email 验证相关 URL 或者退出的 URL。
        if ($request->user() && !$request->user()->hasVerifiedEmail() && !$request->is('email/*', 'logout')) {
            //根据客户端返回对应的内容
            return $request->expectsJson()?abort(403,"您的电子邮件地址未经验证") : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
