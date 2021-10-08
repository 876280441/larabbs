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
                      <option value="" hidden disabled selected>请选择分类</option>
                      @foreach($categories as $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
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

@endsection
