<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
     * 用户更新信息时的策略
     * 第一个User为当前登录用户
     * 第二个User为正在操作的user
     */
    public function update(User $currentUser, User $user)
    {
        //判断当前用户与被更新用户是否一致
        return $currentUser->id === $user->id ? Response::allow() : Response::deny('你无权访问!请正确使用该站');
    }

    /*
     * 显示视图时的策略
     */
    public function view(User $currentUser, User $user)
    {
        //判断当前用户与被更新用户是否一致
        return $currentUser->id === $user->id ? Response::allow() : Response::deny('你无权访问!请正确使用该站');
    }
}
