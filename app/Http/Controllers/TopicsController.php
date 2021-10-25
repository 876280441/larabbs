<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic, User $user, Link $link)
    {
        //搜索关键字
        $keyword = $request->query('keyword');
        //获取分类id
        $category_id = $request->query('category_id');
        //查询博客数据
        //如果这个关键字为空，就不进行闭包操作，直接查询数据
        //when()就是如果变量值存在，就执行里面的闭包操作，如果不存在就会跳过闭包操作
//        $topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(10);
        $topics = Topic::when($keyword, function ($query) use ($keyword) {
            //将一个闭包套在组里面，不会影响全局的SQL
            $query->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
        })->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', '=', $category_id);
        })->withOrder($request->order)
            ->with('user', 'category')
            ->paginate(10);
        /*获取活跃用户数据*/
        $active_users = $user->getActiveUsers();
        /*获取首页推荐链接*/
        $links = $link->getAllCached();
        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        $topic->visits()->increment();
        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        //获取用户需要添加的数据
        $topic->fill($request->all());
        //将当前登录id赋给要插入的数据里面
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with('success', '帖子创建成功！');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->to($topic->link())->with('success', '更新成功');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '删除成功！');
    }

    /*
     * 上传图片
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化默认返回数据
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => ''
        ];
        //判断有无上传文件
        if ($file = $request->upload_file) {
            //保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(), 1024);
            //图片保存成功
            if ($result) {
                $data['success'] = true;
                $data['msg'] = '上传成功';
                $data['file_path'] = $result['path'];
            }
        }
        return $data;
    }
}
