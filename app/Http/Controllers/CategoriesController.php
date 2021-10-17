<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /*
     * 根据分类查看话题
     */
    public function show(Category $category, Request $request, Topic $topic, User $user)
    {
        //读取分类id关联的话题
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->with('user', 'category')->paginate(10);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
