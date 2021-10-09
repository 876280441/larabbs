@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2>
            <i class="far fa-edit">
            </i>
            @if($topic->id)
              编辑话题
            @else
              新建话题
            @endif
          </h2>
          <hr>
          @if($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
              @else
                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                  @endif
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  @include('shared._eooro')

                  <div class="form-group">
                    <input class="form-control" type="text" name="title" value="{{old('title',$topic->title)}}"
                           placeholder="请填写标题" required/>
                  </div>

                  <div class="form-group">
                    <select name="category_id" class="form-control" required>
                      <option value="" hidden disabled {{$topic->id ? '':'selected'}} >请选择分类</option>
                      @foreach($categories as $value)
                        <option value="{{$value->id}}" {{$topic->category_id==$value->id?'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <textarea name="body" id="editor" class="form-control" rows="6" placeholder="请填写最少三个字符内容"
                              required>{{ old('body', $topic->body ) }}</textarea>
                  </div>

                  <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">保存</button>
                  </div>
                </form>
            </form>
        </div>
      </div>
    </div>
  </div>
@section('styles')
  <link rel="stylesheet" href="{{asset('css/simditor.css')}}">
@stop
@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
  <script>
    $(document).ready(function () {
      var editor = new Simditor({
        textarea: $('#editor'),
        upload: {
          url: '{{route('topics.upload_img')}}',//发送到的链接
          params: {//表单提交参数
            _token: '{{csrf_token()}}'//发送token
          },
          fileKey: 'upload_file',//发送的图片的键名
          connectionCount: 3,//最大发送数
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'//关闭提示
        },
        pasteImage: true,//设定是否支持图片黏贴上传
      });
    });
  </script>
@stop
@endsection
