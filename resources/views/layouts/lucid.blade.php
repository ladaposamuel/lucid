<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <title>{{ config('app.name', 'Lucid') }}</title> -->
  <title>Lucid</title>
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&display=swap" rel="stylesheet" />
	<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/main-style.css') }}" rel="stylesheet">
<link href="{{ asset('css/tabletcss.css') }}" rel="stylesheet">
</head>
<body>

  <!-- Beginning of Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light">
		<div class="container">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img src="{{ asset('img/logo.jpg') }}" alt="Lucid" class="img-fluid" />
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @guest
						<a class="dropdown-item" href="{{ route('/login/google') }}">{{ __('Login') }}</a>
            @else
            <a class="dropdown-item" href=""
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
                    <a class="dropdown-item" href="/home">Home</a>
                    <a href="/settings" class="dropdown-item">Settings</a>
                    <a class="dropdown-item" href="#">Report A Bug</a>
						
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<!-- End of Navbar -->
  <section id="main-content" class="container">
    <div class="row">

  @section('sidebar')
  	<!-- Beginning of Sidebar -->
  <div class="col-lg-4 pb-2">
    <img id="user-avatar" src="{{Auth::user()->image}}" class="img-fluid" />
    <h3 id="user-name">{{Auth::user()->name}}</h3>
    <p id="user-bio">
      Front-end developer, Back-end Developer, UI/UX developer, Friend and
      Traveller.
    </p>
    <p class="user-stats text-center">
      <a href="#" class="pr-2">45 <span>following</span></a>
      <a href="#">165 <span>followers</span></a>
    </p>

    <div class="divider"></div>
    <div class="sidebar-nav">
      <ul>
        <li><a href="/posts">Posts</a></li>
        <li><a href="#">Videos</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="/microblog">Thoughts</a></li>
      </ul>
    </div>
    <!-- Follow Modal Trigger -->
    <div class="follow-me text-center">
      <button class="btn btn-primary" data-toggle="modal" data-target="#followModal">Follow Me</button>
      <!-- Modal -->

      <div class="modal fade" id="followModal" tabindex="-1" role="dialog"
        aria-labelledby="followModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div>
                <img src="{{ asset('img/following-the-idea.png') }}" class="img-fluid" />
                <h4 class="text-main">FOLLOW ME</h4>
                <p class="small"><em>Do you have or would love to have Lucid installed on your domain?<br /> Click the button below to follow me</em></p>
                <button class="btn btn-primary">Follow me on Lucid</button>
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
    </div>
  </div>
  <!-- End of Sidebar -->

         @show
         <!-- Beginning of Post Content -->
   			<div class="col-lg-8 pb-5">
            @yield('content')
        </div>
      </section>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
      </body>

      </html>
