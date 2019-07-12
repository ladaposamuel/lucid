@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Beginning of Post Content -->
@forelse($posts as $post)


 @if($post['image'] !== '')

<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{URL::to('/')}}/storage/{{$post['image']}}" class="img-fluid post-img" alt="What I think of Donald Glover’s New Video" />
  </div>
  <div class="post-content-body">
    <p class="post-date">{{ $post['date'] }}</p>
    <h3 class="post-title">
    <a class="no-decoration text-dark" href="post/{{$post['slug']}}">{!!$post['title'] !!}</a>
    </h3>
    <p class="post-body">
      {!!$post['body'] !!}
    </p>
  </div>
</div>


@else

<div class="post-content">
  <div class="post-content-body">
    <p class="post-date">{{ $post['date'] }}</p>
    <h3 class="post-title">
    <a class="no-decoration text-dark" href="post/{{$post['slug']}}">{!! $post['title'] !!}</a>
    </h3>
    <p class="post-body">
      {!! $post['body'] !!}
    </p>
  </div>
</div>


<div class="text-center">
  <button class="btn btn-primary pagination">
    Previous articles <i class="pl-2 icon ion-ios-arrow-forward"></i>
  </button>
</div>


@endif


@empty


<div class="post-content">
  <div class="post-content-body">
    no posts yet
  </div>
</div>

@endforelse






<!-- End of Post Content -->
{{--@foreach ($posts as $feeds)
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
@endforeach--}}


@endsection