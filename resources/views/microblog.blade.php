@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->

<p>Write a Post</p>

<form method="POST" action="/save-post" enctype="multipart/form-data" class="mb-3">
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

<h5 class="font-weight-bold mb-5">Latest stories</h5>
 <!-- Begin content -->


@foreach ($posts as $feeds)
<div class="post-content">
<img src="{{ $feeds['img']}}"  style="border-radius:100%;height:60px; height:60px" class="img-fluidalt="user" />
  <div class="post-content-body">
      <h5 class="font-weight-bold">{{$feeds['title']}}</h5>
      <p class="">
      {{$feeds['desc']}}
      </p>
      <p class="">{{$feeds['site']}} -<small class="text-muted">{{$feeds['date']}} </small></p>
    </div>
</div>

@endforeach

<!-- End content -->
@endsection
