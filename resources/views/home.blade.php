@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->
@auth
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
@endauth

<!-- Beginning of Post Content -->

<!-- End of Post Content -->
@foreach ($posts as $feeds)
@if (empty($feeds['image']))

<div class="post-content">
  <a class="no-decoration" href="{{$feeds['link']}}">
    <div class="post-content-body">
      <p class="post-date">{{$feeds['date']}}</p>
      <h3 class="post-title">
        {{$feeds['title']}}
      </h3>
      <p class="post-body">
        {{$feeds['desc']}}
      </p>
    </div>
  </a>
</div>
@else
<div class="post-content">
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{URL::to('/')}}/storage/{{$feeds['image']}}" class="img-fluid post-img" alt="Looking For Where To Spend Christmas in the comform of your home" />
  </div>
  <a class="no-decoration" href="/{{$user->username}}{{$feeds['link']}}">
    <div class="post-content-body">
      <p class="post-date">{{$feeds['date']}}</p>
      <h3 class="post-title">
        {{$feeds['title']}}
      </h3>
      <p class="post-body">
        {{$feeds['desc']}}
      </p>
    </div>
  </a>
</div>
@endif
@endforeach


<div class="text-center">
  <button class="btn btn-primary pagination">
    Previous articles <i class="pl-2 icon ion-ios-arrow-forward"></i>
  </button>
</div>


@endsection
