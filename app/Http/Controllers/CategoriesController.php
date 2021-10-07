<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /*
     * 根据分类查看话题
     */
    public function show(Category $category,Request $request,Topic $topic){
        //读取分类id关联的话题
        $topics = $topic->withOrder($request->order)->where('category_id',$category->id)->with('user','category')->paginate(10);
        return view('topics.index',compact('topics','category'));
    }
}
