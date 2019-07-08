<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141181859-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-141181859-1');
  </script>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="description"
    content="Welcome to the most private content sharing platform We built Lucid on the premise that ownership and privacy is about respect and that it is your right.">
  <meta name="robots" content="index, nofollow">
  <link rel="canonical" href="https://getlucid.app/" />
  <!-- Twitter Card data -->
  <meta name="twitter:card"
    value="Welcome to the most private content sharing platform We built Lucid on the premise that ownership and privacy is about respect and that it is your right.">

  <!-- Open Graph data -->
  <meta property="og:title" content="Lucid" />
  <meta property="og:description"
    content="Welcome to the most private content sharing platform We built Lucid on the premise that ownership and privacy is about respect and that it is your right." />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://unpkg.com/ionicons@4.5.9-1/dist/css/ionicons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet" />
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
  <link rel="stylesheet" href="{{ asset('css/main-style.css') }}" />
  <title>Lucid - the ultimate lightweight content platform</title>
</head>

<body>
<header class="header">
    <nav class="navbar sticky-top navbar-expand-lg">
        <div class="container">
        <a href="/" class="navbar-brand"><img alt="Lucid" src="{{ asset('img/logo.png') }}" class="img-fluid" /></a>
        <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
            class="navbar-toggler navbar-toggler-right collapsed">
            <i class="icon ion-md-list ml-2"></i>
        </button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                {{--<a href="http://demo.getlucid.app" target="_blank" class="nav-link mr-4">Demo</a>--}}
            </li>
            <li class="nav-item">
                {{--<a href="#" class="nav-link mr-4">Features</a>--}}
            </li>
            <li class="nav-item">
                <a href="get-started.php" class="nav-link mr-4">Get Started</a>
            </li>
            <li class="nav-item">
                <a href="/register" class="nav-link mr-4">Register</a>
            </li>
            <li class="nav-item">
                <a href="/login" class="navbar-btn btn btn-primary">Login</a>
            </li>
            <!-- <li class="nav-item">
                <a href="https://download.getlucid.app/lucid.zip" target="_blank" class="navbar-btn btn btn-primary">Download</a>
            </li> -->
            </ul>
        </div>
        </div>
    </nav>
</header>
@yield('content')
<button id="myBtn" class="btn waves-effect waves-light" type="button" style="display: inline-block;">
<i class="icon ion-ios-arrow-up text-white"></i>
</button>
<footer class="footer-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <img src="{{ asset('img/logo.png') }}" alt="Lucid" class="img-fluid pb-3" />
      </div>
      <div class="col-lg-12 text-center">
        <p>&copy; 2019 Lucid. All rights reserved.</p>
      </div>
      <div class="col-lg-12 text-center">
        <ul class="footer-links">
          <li><a href="#">About us</a></li>
          <li><a href="#">Support</a></li>
          <li><a href="/terms-and-conditions.php">Terms and Condition</a></li>
          <li><a href="/privacy-policy.php">Privacy policy</a></li>
          <li><a href="/get-started.php">Get Started</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>