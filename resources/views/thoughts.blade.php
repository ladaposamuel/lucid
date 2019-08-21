@extends('layouts.lucid')
@section('title')
  @if(Auth::user() && Auth::user()->username == $user->username)
   Thoughts - {{ $user->username }} - Lucid
  @else
  {{ $user->name }} (@ {{ $user->username }}) - Lucid
  @endif
@endsection
@php
$location= 'thoughts';
@endphp
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->
<style>
  .form-control{
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

  .text-danger{
  font-weight:400px !important;
  font-size:12px !important;

}
</style>
@if(Auth::user() && Auth::user()->username == $user->username)
<p>Write a thought</p>

<form method="POST" action="{{url('/save-post')}}" autocomplete="off" enctype="multipart/form-data" class="mb-3">
  @csrf
  <div class="form-group">
    <textarea type="text" name="body" class="form-control h-25" placeholder="Tell your story"></textarea>
    @if($errors->has('body'))
    <span class="text-danger">Fill out this field to publish your thoughts</span>
    @endif
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Publish</button>
  </div>
</form>
@endif
<!-- End Editor -->
<br />
<h5 class="font-weight-bold mb-4">Latest stories</h5>
<!-- Begin content -->


@foreach ($posts as $feeds)
<div class="post-content">

  <div class="post-content-body">
    <p class="mb-1">{{$user->name}}-<small class="text-muted">{{$feeds['date']}}</small></p>
    <p class="">
      {!!$feeds['body']!!}
    </p>
  </div>
</div>

@endforeach

<!-- End content -->
@endsection
