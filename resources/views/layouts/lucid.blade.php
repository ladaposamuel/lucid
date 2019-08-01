<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <title>{{ config('app.name', 'Lucid') }}</title> -->
  <title>@yield('title') - Lucid</title>
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap" rel="stylesheet" />
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main-style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tabletcss.css') }}" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
</head>

<body>
  <section id="main-content" class="container pt-0">
    <div class="row">

      @section('sidebar')
      <!-- Beginning of Sidebar -->
      <div class="col-lg-4 pb-0 mb-0 pt-2">
        <a href="/{{ $user->username}}"><img id="user-avatar" src="{{$user->image}}" class="img-fluid" /></a>
        <a href="/{{ $user->username}}" class="no-decoration"><h3 id="user-name" class="pt-2">{{ $user->name}}</h3></a>
        <p id="user-bio" class="pb-2">
        @if(Auth::user() && Auth::user()->username == $user->username && $user->short_bio =="")
          You haven't set up a short bio about yourself, do that <a href="/{{ $user->username}}/settings">here</a>
        @else
          {{ $user->short_bio }}
        @endif
        </p>

        <div class="divider"></div>
        <div class="sidebar-nav pt-2">
          <ul>
          @if(Auth::user() && Auth::user()->username == $user->username)
            <li><a href="/{{ $user->username}}/posts">Posts</a></li>
          @else
            <li><a href="/{{ $user->username}}">Posts</a></li>
          @endif
            <li><a href="/{{ $user->username}}/thoughts">Thoughts</a></li>
            <li><a href="#">Videos</a></li>
            <li><a href="/{{ $user->username}}/contact">Contact</a></li>
          </ul>
        </div>
        @if(Auth::user() && Auth::user()->username == $user->username)
        @else
        <!-- Follow Modal Trigger -->
        <div class="follow-me text-center pt-3">
          @if($fcheck == "yes")
          <button class="btn btn-primary" data-toggle="modal" data-target="#unfollowModal">UnFollow</button>

    <div class="modal fade" id="unfollowModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">

        <div>
          <img src="{{ asset('img/following-the-idea.png') }}" class="img-fluid" />
          <h4 class="text-main">Unfollow  {{$user->name}}</h4>
          <p class="small"><em>Are you sure you want to Unfollow {{$user->name}} and miss out interesting post?<br /> Click the button below to unfollow</em></p>
          <form method="POST" action="{{URL::to('/')}}/{{Auth::user()->username}}/unfollow">
            @csrf
            <input type="hidden" name="rss" value="{{$user->name}}">
            <button type="submit" class="btn btn-primary">UnFollow</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
          @else

          <button class="btn btn-primary" data-toggle="modal" data-target="#followModal">Follow Me</button>
          <!-- Modal -->

          <div class="modal fade" id="followModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div>
                    <img src="{{ asset('img/following-the-idea.png') }}" class="img-fluid" />
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
          <!-- End Modal -->
@endif
        </div>

        @endif


        <div class="user-stats text-center mt-3 pb-0">
          <div class="d-inline-block">
            @if (empty($fcount))
            <a href="#" class="pr-2">0 <br /> <small class="text-muted">Following</small></a>
            @else
            <a href="#" class="pr-2">{{$fcount}} <br /> <small class="text-muted">Following</small></a>
            @endif
          </div>
          <div class="d-inline-block">
          @if (empty($count))
            <a href="#">0 <br /> <small class="text-muted">Followers</small></a>
            @else
            <a href="#">{{$count}} <br /> <small class="text-muted">Followers</small></a>
            @endif
          </div>
          <div class="mt-3">
            <small class="text-muted"><img src="{{ asset('img/logo.jpg') }}" alt="Lucid" class="img-fluid" style="filter: grayscale(100%);" /> Powered by Lucid</small>
          </div>
        </div>
      </div>
      <!-- End of Sidebar -->

      @show
      <div class="col-lg-8 pb-0">

        <!-- Beginning of Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light pt-2 mb-5">
          <div class="container">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ asset('img/lucid-logo.png') }}" alt="The Lucid Logo" class="img-fluid" width="65px" />
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  @guest
                  <a class="dropdown-item" href="{{ url('/login') }}">{{ __('Login') }}</a>
                  @else
                  <a class="dropdown-item" href="/home">Home</a>
                  <a href="/{{ $user->username}}/settings" class="dropdown-item">Settings</a>
                  <a class="dropdown-item" href="/{{ $user->username}}/logout">
                    {{ __('Logout') }}
                  </a>

                  @endguest
                </div>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End of Navbar -->

        <!-- Beginning of Post Content -->
        @yield('content')

      </div>

  </section>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
