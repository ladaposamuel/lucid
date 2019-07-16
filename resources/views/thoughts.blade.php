@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->

<p>Write a Post</p>

<form method="POST" action="{{url('/save-post')}}" enctype="multipart/form-data" class="mb-3">
  @csrf
  <div class="form-row mb-3">
    <div class="col-7">
      <input type="text" name="title" class="form-control" placeholder="Title">
    </div>
    <div class="col-4 offset-md-1 border-dark ">
      <input type="file" name="file" class="" id="customFile" style="display:none">
      <label class="text-muted form-control p-2 w-100" for="customFile"><i class="icon ion-md-add p-1"></i> Add post Image</label>
    </div>
  </div>
  <div class="form-group">
    <textarea type="text" name="body" class="form-control h-25" placeholder="Tell your story"></textarea>
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Publish</button>
  </div>
</form>
<!-- End Editor -->
<br />
<h5 class="font-weight-bold mb-5">Latest stories</h5>
<!-- Begin content -->


@foreach ($posts as $feeds)
<div class="post-content">
  @if (empty($feeds->site_image))
  <img src="{{ asset('img/logo.jpg') }}" class="img-fluid img-thumb" alt="user" />
  @else
  <img src="{{ $feeds->site_image}}" class="img-fluid img-thumb" alt="user" />
  @endif
  <div class="post-content-body">
    <a href="{{$feeds->link}}"></a>
    <p class="mb-1">{{$feeds->site}} -<small class="text-muted">{{$feeds->date}} </small></p>
    <p class="">
      {{$feeds->des}}
    </p>
  </div>
</div>

@endforeach

<!-- End content -->
@endsection