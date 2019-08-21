<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://unpkg.com/ionicons@4.5.9-1/dist/css/ionicons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet" />
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main-style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tabletcss.css') }}" rel="stylesheet">
  <title>Explore</title>
</head>

<body>
  <!-- Beginning of Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light pt-2">
    <div class="container">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle pt-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('img/lucid-logo.png') }}" alt="The Lucid Logo" class="img-fluid" width="40px" />
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End of Navbar -->
  <div>
    <h4 class="ml-4 mb-3 pl-1">Explore Lucid</h4>
    <!-- Begin content -->
    <div class="page-tab ml-4 mb-3">
      <ul class="nav nav-tabs navbar-light" id="follow-tabs" role="tablist">
        <li class="nav-item">
          <a href="#category" class="nav-link tab-link active ml-1 pl-0" data-toggle="tab" role="tab" aria-controls="category" aria-selected="false">
            <h6>Category</h6>
          </a>
        </li>
        <li class="nav-item">
          <a href="#page" class="nav-link tab-link ml-1 pl-0" data-toggle="tab" role="tab" aria-controls="posts" aria-selected="false">
            <h6>Posts</h6>
          </a>
        </li>
      </ul>

    </div>
    <div class="tab-content">
      <!-- Category Page -->
      <div class="tab-pane show active" role="tabpanel" id="category">
        <div class="row p-3 m-0">
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/politics.png') }}" class="w-100" alt="politics" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Politics</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/sports.png') }}" class="w-100" alt="sports" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Sports</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/health.png') }}" class="w-100" alt="health" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Health</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/technology.png') }}" class="w-100" alt="technology" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Technology</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/music.png') }}" class="w-100" alt="music" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Music</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/lifestyle.png') }}" class="w-100" alt="music" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Lifestyle</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/movies.png') }}" class="w-100" alt="movies" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Movies</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
          <div class="col-xs-6 col-md-4 mb-3">
            <img src="{{ asset('img/fitness.png') }}" class="w-100" alt="fitness" />
            <div class="border d-flex justify-content-between">
              <p class="font-weight-bold px-2 pt-2">Fitness</p>
              <i class="icon ion-md-arrow-dropright px-3" style="font-size: 1.8em"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- End Category Page -->

      <!-- Posts Page -->
      <div class="tab-pane" role="tabpanel" id="page">
    <div class="row mx-3">
      <div class="col-xs-12 col-md-8">
      <div class="post-content">
          <img src="{{ asset('img/mb-1.png') }}" class="img-fluid" alt="user" />
          <div class="post-content-body">
            <h5 class="font-weight-bold">Maybe You Don't Need Kubernetes</h5>
            <p class="">
              Kubernetes is the 800-pound gorilla of container orchestration. It powers some of the biggest deployments worldwide, but it comes with a price tag
            </p>
            <p class="">Tyler Elliot -<small class="text-muted">March 28, 2019 </small></p>
          </div>
        </div>

        <div class="post-content">
          <img src="{{ asset('img/mb-2.png') }}" class="img-fluid" alt="user" />
          <div class="post-content-body">
            <h5 class="font-weight-bold">What Is Rust Doing Behind the Curtains? </h5>
            <p class="">
              Rust allows for a lot of syntactic sugar, that makes it a pleasure to write. It is sometimes hard, however, to look behind the curtain and see what the compiler is really doing with our code.
            </p>
            <p class="">Jayne Lee -<small class="text-muted">March 26, 2019 </small></p>
          </div>
        </div>

        <div class="post-content">
          <img src="{{ asset('img/mb-3.png') }}" class="img-fluid" alt="user" />
          <div class="post-content-body">
            <h5 class="font-weight-bold">The Unreasonable Effectiveness of Excel Macros</h5>
            <p class="">
              I never was a big fan of internships, partially because all the exciting companies were far away from my little village in Bavaria and partially because I was too shy to apply. Only once I applied for an internship in Ireland as part of a school program. Our teacher assigned the jobs and so my friend got one at Apple and I ended up at a medium-sized IT distributor — let's call them PcGo.
            </p>
            <p class="">Eric Elliot -<small class="text-muted">March 24, 2019 </small></p>
          </div>
        </div>

        <div class="post-content">
          <img src="{{ asset('img/mb-1.png') }}" class="img-fluid" alt="user" />
          <div class="post-content-body">
            <h5 class="font-weight-bold">Switching from a German to a US Keyboard Layout - Is It Worth It? </h5>
            <p class="">
              For the first three decades of my life, I've used a German keyboard layout. A few months ago, I switched to a US layout. This post summarizes my thoughts around the topic. I was looking for a similar article before jumping the gun, but I couldn't find one — so I'll try to fill this gap. Why switch?
            </p>
            <p class="">Tyler Elliot -<small class="text-muted">March 22, 2019 </small></p>
          </div>
        </div>

        <div class="post-content">
          <img src="{{ asset('img/mb-2.png') }}" class="img-fluid" alt="user" />
          <div class="post-content-body">
            <h5 class="font-weight-bold">fastcat - A Faster `cat` Implementation Using Splice</h5>
            <p class="">
              Lots of people asked me to write another piece about the internals of well-known Unix commands. Well, actually, nobody asked me, but it makes for a good intro. I'm sure you’ve read the previous parts about `yes` and `ls` — they are epic.
            </p>
            <p class="">Jaynee Lee -<small class="text-muted">March 20, 2019 </small></p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4 bg-light" style="height: 30vh;">
        <p class="font-weight-bold">Popular Topics</p>
      </div>
    </div>
      </div>
      <!-- End Posts page -->
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>