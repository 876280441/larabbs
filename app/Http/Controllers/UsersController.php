<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * 显示个人信息页面
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示编辑个人信息页面
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * 更新个人信息 -- 处理逻辑
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show',$user->id)->with('success','个人信息修改成功');
    }

}
