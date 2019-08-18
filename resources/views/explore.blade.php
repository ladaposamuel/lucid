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
  <link rel="stylesheet" href="{{ asset('css/main-style.css') }}" />
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
        <div class="row p-3 m-0">
          Posts test
        </div>
      </div>
      <!-- End Posts page -->
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>