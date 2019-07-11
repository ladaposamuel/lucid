@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Beginning of Post Content -->
<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{ asset('img/post-1.jpg') }}" class="img-fluid post-img" alt="What I think of Donald Glover’s New Video" />
  </div>
  <div class="post-content-body">
    <p class="post-date">3rd April, 2019</p>
    <h3 class="post-title">
      What I think of Donald Glover’s New Video
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet, consectetur....
    </p>
  </div>
</div>

<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{ asset('img/post-2.jpg') }}" class="img-fluid post-img" alt="Looking For Where To Spend Christmas in the comform of your home" />
  </div>
  <div class="post-content-body">
    <p class="post-date">2nd April, 2019</p>
    <h3 class="post-title">
      Looking For Where To Spend Christmas in the comform of your home
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet....
    </p>
  </div>
</div>

<div class="post-content">
  <div class="post-content-body">
    <p class="post-date">1st April, 2019</p>
    <h3 class="post-title">
      Looking For Where To Spend Christmas in the comform of your home
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet....
    </p>
  </div>
</div>

<div class="post-content">
  <div class="post-content-body">
    <p class="post-date">1st April, 2019</p>
    <h3 class="post-title">
      Looking For Where To Spend Christmas in the comform of your home
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet....
    </p>
  </div>
</div>

<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{ asset('img/post-1.jpg') }}" class="img-fluid post-img" alt="What I think of Donald Glover’s New Video" />
  </div>
  <div class="post-content-body">
    <p class="post-date">3rd April, 2019</p>
    <h3 class="post-title">
      What I think of Donald Glover’s New Video
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet, consectetur....
    </p>
  </div>
</div>

<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{ asset('img/post-2.jpg') }}" class="img-fluid post-img" alt="Looking For Where To Spend Christmas in the comform of your home" />
  </div>
  <div class="post-content-body">
    <p class="post-date">2nd April, 2019</p>
    <h3 class="post-title">
      Looking For Where To Spend Christmas in the comform of your home
    </h3>
    <p class="post-body">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
      eiusmod tempor incididunt ut labore et dolore , Lorem ipsum
      dolor sit amet....
    </p>
  </div>
</div>

<div class="text-center">
  <button class="btn btn-primary pagination">
    Previous articles <i class="pl-2 icon ion-ios-arrow-forward"></i>
  </button>
</div>

<!-- End of Post Content -->
<!-- @foreach ($posts as $feeds)
@if ($feeds['img'] ="")
<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{$feeds['img']}}" class="img-fluid post-img"
      alt="{{$feeds['title']}}" />
  </div>
  <div class="post-content-body">
    <p class="post-date">{{$feeds['date']}}</p>
    <h3 class="post-title">
      {{$feeds['title']}}
    <p class="post-body">
    {{$feeds['desc']}}
    </p>
  </div>
</div>
@endif
<div class="post-content">
  <div class="post-content-body">
    <p class="post-date">{{$feeds['date']}}</p>
    <h3 class="post-title">
      {{$feeds['title']}}
    </h3>
    <p class="post-body">
      {{$feeds['desc']}}
    </p>
  </div>
</div>
@endforeach -->


@endsection