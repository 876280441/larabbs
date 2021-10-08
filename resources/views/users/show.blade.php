@extends('layouts.app')
@section('title',$user->name . '的个人中心')
@section('content')
  <div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
      <div class="card">
        <img class="card-img-top"
             src="{{$user->avatar}}"
             alt="{{$user->name}}">
        <div class="card-body">
          <h5>
            <strong>个人简介</strong>
          </h5>
          <p>{{$user->introduction}}</p>
          <hr>
          <h5>
            <strong>注册于</strong>
          </h5>
          <p>{{$user->created_at->diffForHumans()}}</p>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-body">
          <h1 class="mb-0" style="font-size: 22px">
            {{$user->name}} &nbsp;<small>{{$user->email}}</small>
          </h1>
        </div>
      </div>
      <hr>
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#" class="nav-link active bg-transparent">Ta 的话题</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Ta 的回复</a>
            </li>
          </ul>
          @include('users._topics',['topics'=>$topics])
        </div>
      </div>
    </div>
  </div>
@stop
