@extends('layouts.lucid')
@section('sidebar')
    @parent

@endsection
@section('content')
@foreach ($posts as $feeds)
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
@endforeach


@endsection
