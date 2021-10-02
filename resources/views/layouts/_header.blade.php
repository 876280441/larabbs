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
          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle"
               id="navbarDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"
            >
              <img src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60"
                   class="img-responsive img-circle" width="30px" height="30px" alt="">
              {{\Illuminate\Support\Facades\Auth::user()->name}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a href="{{route('users.show',\Illuminate\Support\Facades\Auth::id())}}" class="dropdown-item">个人中心</a>
              <a href="{{route('users.edit',\Illuminate\Support\Facades\Auth::id())}}" class="dropdown-item">编辑资料</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item" id="logout">
                <form action="{{route('logout')}}" method="post">
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
