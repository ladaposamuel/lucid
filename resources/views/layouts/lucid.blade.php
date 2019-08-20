<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @auth
  <meta name="username" content="{{ Auth::user()->username }}">
  @endauth
  <!-- <title>{{ config('app.name', 'Lucid') }}</title> -->
  <title>@yield('title')</title>
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap" rel="stylesheet" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main-style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tabletcss.css') }}" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
  <style>
    .preloader-wrapper {
      display: none;
    }

    .preloader-active .preloader-wrapper {
      display: block;
      width: 100vw;
      height: 100vh;
      background: #000;
      position: fixed;
      color: #871e99;
      opacity: 0.60;
      z-index: 1000;
      top: 0;
      left: 0;
    }

    .spinner {
      width: 10vw;
      height: 10vw;
      border-radius: 50%;
      border: 4px solid;
      border-top-color: var(--main-color);
      border-bottom-color: var(--main-color);
      border-left-color: transparent;
      border-right-color: transparent;
      animation: rotate .5s infinite linear;
      position: absolute;
      top: 30%;
      left: 42%;
      transform: translateX(50%);

    }

    @keyframes rotate {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body id="preloader">
  <div class="preloader-wrapper">
    <div class="spinner"></div>
  </div>
  <section id="main-content" class="container pt-0">
    <div class="row">

      @section('sidebar')
      <!-- Beginning of Sidebar -->
      <div class="col-10 col-sm-4 pb-0 mb-0 pt-2 d-none d-lg-block" id="sidebar">
        <a class="d-lg-none" id="sidebarDismiss"><i class="icon ion-md-close-circle" style="font-size: 1.8em"></i></a>
        <a href="/{{ $user->username}}" class="changeHref"><img id="user-avatar" src="{{$user->image}}" class="img-fluid" /></a>
        <a href="/{{ $user->username}}" class="no-decoration changeHref">
          <h3 id="user-name" class="pt-2">{{ $user->name}}</h3>
        </a>

        @if(Auth::user() && Auth::user()->username == $user->username && $user->short_bio =="")
        <p id="user-bio" class="pb-2" style="color:#a9a9a9;">
          You haven't set up a short bio about yourself, do that <a href="/{{ $user->username}}/settings" id="onSettingsPage">here</a>
        </p>
        @else
        <p id="user-bio" class="pb-2">
          {{ $user->short_bio }}
        </p>
        @endif


        <div class="divider"></div>

        <div class="sidebar-nav pt-2">
          <ul>
            @if(Auth::user() && Auth::user()->username == $user->username)
            <li class="w-100 text-center"><a class="@if($location ==  'timeline') active-nav @endif changeHref" href="/{{ $user->username}}">Timeline</a></li>
            <li class="w-100 text-center"><a class="@if($location ==  'post') active-nav @endif changeHref" href="/{{ $user->username}}/posts">Posts</a></li>
            @else
            <li class="w-100 text-center"><a class="@if($location ==  'post') active-nav @endif changeHref" href="/{{ $user->username}}">Posts</a></li>
            @endif
            <li class="w-100 text-center"><a class="@if($location ==  'thoughts') active-nav @endif changeHref" href="/{{ $user->username}}/thoughts">Thoughts</a></li>
            <!-- <li class="w-100 text-center"><a class="@if($location ==  'video') active-nav @endif changeHref" href="{{ route('under-construction') }}">Videos</a></li> -->
            <li class="w-100 text-center"><a class="@if($location ==  'contact') active-nav @endif changeHref" href="/{{ $user->username}}/contact">Contact</a></li>
          </ul>
        </div>
        @if(Auth::user() && Auth::user()->username == $user->username)
        @else
        <!-- Follow Modal Trigger -->
        <div class="follow-me text-center pt-3">
          @if($fcheck == "yes")
          <button class="btn btn-primary" data-toggle="modal" data-target="#unfollowModal">UnFollow</button>
          @else
          <button class="btn btn-primary" data-toggle="modal" data-target="#followModal">Follow Me</button>
          @endif
        </div>
        @endif

        <div class="user-stats text-center mt-3 pb-0">
          <div class="d-inline-block">
            @if (empty($count))
            <a href="/{{$user->username}}/following" class="pr-2 changeHref">0 <br /> <small class="text-muted">Following</small></a>
            @else
            <a href="/{{$user->username}}/following" class="pr-2 changeHref">{{$count}} <br /> <small class="text-muted">Following</small></a>
            @endif
          </div>
          <div class="d-inline-block">
            @if (empty($fcount))
            <a href="/{{$user->username}}/followers" class="changeHref">0 <br /> <small class="text-muted">Followers</small></a>
            @else
            <a href="/{{$user->username}}/followers" class="changeHref">{{$fcount}} <br /> <small class="text-muted">Followers</small></a>
            @endif
          </div>
          <div class="mt-3">
            <a href="https://lucid.blog"> <small class="text-muted"><img src="{{ asset('img/logo.jpg') }}" alt="Lucid" class="img-fluid" style="filter: grayscale(100%); height: 20px;" /> Powered by Lucid</small></a>
          </div>
        </div>
      </div>
      <!-- End of Sidebar -->

      <!-- Unfollow Modal -->
      <div class="modal fade text-center" id="unfollowModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">

              <div>
                <img src="{{$user->image}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
                <br>
                <br>
                <h4 class="text-main">Unfollow {{$user->name}}</h4>
                <p class="small"><em>Are you sure you want to Unfollow {{$user->name}} and miss out interesting post?<br /> Click the button below to unfollow</em></p>
                <form method="POST" action="{{URL::to('/')}}/{{$user->username}}/unfollow">
                  @csrf
                  <input type="hidden" name="rss" value="{{$user->name}}">
                  <button type="submit" class="btn btn-primary">UnFollow</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Unfollow Modal  -->

      <!-- Follow Modal -->
      <div class="modal fade text-center" id="followModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div>
                <img src="{{$user->image}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
                <br>
                <br>
                <h4 class="text-main">Follow {{$user->name}}</h4>
                <p class="small"><em>Do you have or would love to have Lucid installed on your domain?<br /> Click the button below to follow me</em></p>
                <form method="POST" action="{{URL::to('/')}}/{{$user->username}}/addrss">
                  @csrf
                  <input type="hidden" name="rss" value="{{$user->username}}">
                  <button type="submit" class="btn btn-primary">Follow me on Lucid</button>
                </form>
              </div>
              <div class="mt-5">
                <span class="font-weight-bold mx-2">Follow Me On</span>
                <a href="#" class="social-icon m-1"><i class="icon ion-logo-rss text-dark p-1"></i></a>
                <a href="#" class="social-icon m-1"><i class="icon ion-logo-twitter text-dark p-1"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End FOllow  Modal -->

      @show
      <div class="col-lg-8 pb-0">

        <!-- Beginning of Navbar -->
        <div class="container-fluid p-0 m-0 mb-5 d-flex justify-content-between">
          <a class="d-lg-none" id="sidebarToggle"><i class="icon ion-md-list" style="font-size: 1.8em"></i></a>
          <div class="dropdown" id="lucid-dropdown">
            <a class="nav-link dropdown-toggle pt-1" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{ asset('img/lucid-logo.png') }}" alt="The Lucid Logo" class="img-fluid" width="40px" />
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @guest
              <a class="dropdown-item" href="{{ url('/login') }}">{{ __('Login') }}</a>
              @else
              <a class="dropdown-item changeHref" href="/{{ Auth::user()->username}}">Home</a>
              <a href="/{{ $user->username}}/settings" class="dropdown-item changeHref">Settings</a>
              <a class="dropdown-item changeHref" href="/{{ $user->username}}/logout">
                {{ __('Logout') }}
              </a>

              @endguest
            </div>
          </div>
        </div>
        <!-- End of Navbar -->

        <!-- Beginning of Post Content -->
        @yield('content')
        <div class="overlay"></div>
      </div>

  </section>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script>
    const anchor = window.location.hash;
    $(`a[href="${anchor}"]`).tab('show')
  </script>
  <script>
    const pageUrl = window.location.href
    if (pageUrl.includes('followers')) {
      $('#follow-tabs a[href="#followers"]').tab('show')
    } else(
      $('#follow-tabs a[href="#following"]').tab('show')
    )
    // $(`a[href="${anchor}"]`).tab('show')
  </script>
  <script>
    function changeUrl(e) {
      history.pushState(null, null, `/${document.getElementById("username").value+'/'+e}`)
    }
  </script>
  <script>
    $(document).ready(function() {
      $('#sidebarDismiss,.overlay, [data-toggle="modal"]').on('click', function() {
        // hide sidebar
        $('#sidebar').removeClass('active-sidebar');
        // hide overlay
        $('.overlay').removeClass('active');
      });
/*       $('[data-toggle="modal"]').on('click', function() {
        // hide sidebar
        $('#sidebar').addClass('d-none');
        // hide overlay
        $('.overlay').removeClass('active');
      }); */
      $('#sidebarToggle').on('click', function() {
        // open sidebar
        $('#sidebar').addClass('active-sidebar');
        // fade in the overlay
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });
    });
  </script>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-28315089-7"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-28315089-7');
  </script>

</body>

</html>