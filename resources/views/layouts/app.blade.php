<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!--CSRF Token-->
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>@yield('title','by')-{{setting('site_name','小信论坛')}}</title>
  <meta name="description" content="@yield('description',setting('description','LaraBBS 爱好者社区。'))">
  <meta name="keywords" content="@yield('keywords',setting('seo_keyword','LaraBBS,社区,论坛,开发者论坛'))">
  <link href="{{mix('css/app.css')}}" rel="stylesheet">
  @yield('styles')
</head>
<body>
<div id="app" class="{{route_class()}}-page">
  @include('layouts._header')
  <div class="container">
    @include('shared._messages')
    @yield('content')
    @if(app()->isLocal())
      @include('sudosu::user-selector')
    @endif
  </div>
  @include('layouts._footer')
</div>
<script src="{{mix('js/app.js')}}"></script>
@yield('scripts')
</body>
</html>
