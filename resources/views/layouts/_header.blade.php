<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <a href="{{url('/')}}" class="navbar-brand">
      LaraBBS
    </a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      {{--      左导航--}}
      <ul class="navbar-nav mr-auto">
        <li class="nav-item  {{ active_class(if_route('topics.index')) }}">
          <a href="{{route('topics.index')}}" class="nav-link">话题</a>
        </li>
        <li class="nav-item  {{ category_nav_active(1) }}">
          <a href="{{route('categories.show',1)}}" class="nav-link">分享</a>
        </li>
        <li class="nav-item {{ category_nav_active(2) }}">
          <a href="{{route('categories.show',2)}}" class="nav-link">教程</a>
        </li>
        <li class="nav-item {{ category_nav_active(3) }}">
          <a href="{{route('categories.show',3)}}" class="nav-link">问答</a>
        </li>
        <li class="nav-item {{ category_nav_active(4) }}">
          <a href="{{route('categories.show',4)}}" class="nav-link">公告</a>
        </li>
      </ul>
      {{--      右导航--}}
      <ul class="navbar-nav navbar-right">
        {{--        判断是否已登录--}}
        @guest
          <li class="nav-item">
            <a href="{{route('login')}}" class="nav-link">登录</a>
          </li>
          <li class="nav-item">
            <a href="{{route('register')}}" class="nav-link">注册</a>
          </li>
        @else
          <li class="nav-item">
            <a href="{{route('topics.create')}}" class="nav-link mt-1 mr-3 font-weight-bold">
              <i class="fa fa-plus"></i>
            </a>
          </li>
          <li class="nav-item notification-badge">
            <a
              class="nav-link mr-3 badge badge-pill badge-{{ \Illuminate\Support\Facades\Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white"
              href="{{route('notifications.index')}}">
              {{ \Illuminate\Support\Facades\Auth::user()->notification_count }}
            </a>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"
            >
              <img src="{{\Illuminate\Support\Facades\Auth::user()->avatar}}"
                   class="img-responsive img-circle" width="30px" height="30px" alt="">
              {{\Illuminate\Support\Facades\Auth::user()->name}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @can('manage_contents')
                <a href="{{url(config('administrator.uri'))}}" class="dropdown-item">
                  <i class="fas fa-tachometer-alt mr-2"></i>
                  管理中心</a>
              @endcan
              <a href="{{route('users.show',\Illuminate\Support\Facades\Auth::id())}}" class="dropdown-item">个人中心</a>
              <a href="{{route('users.edit',\Illuminate\Support\Facades\Auth::id())}}" class="dropdown-item">编辑资料</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item" id="logout">
                <form action="{{route('logout')}}" method="post" onsubmit="return confirm('确定退出?');">
                  {{csrf_field()}}
                  <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                </form>
              </a>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
