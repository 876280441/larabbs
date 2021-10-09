<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
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

    public function index(Request $request, Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->with('user', 'category')->paginate(10);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
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
        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
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
        if ($file = $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(),1024);
            //图片保存成功
            if ($result){
                $data['success']=true;
                $data['msg']='上传成功';
                $data['file_path']=$result['path'];
            }
        }
        return $data;
    }
}
