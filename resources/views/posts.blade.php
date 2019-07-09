@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')

<!-- Editor -->
<form class="mb-3">
  <div class="form-group border border-dark">
    <textarea type="text" class="form-control post-editor" placeholder="What's on your mind..."></textarea>
    <div class="mx-2">
    <i class="icon ion-md-image p-1"></i>
    <i class="icon ion-md-videocam p-1"></i>
    </div>
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Publish</button>
  </div>
</form>
<!-- End Editor -->

<!-- Begin content -->
<div class="post-content border-top border-info pt-3 mt-3">
  <img src="{{Auth::user()->image}}" class="img-thumb" alt="user" />
  <div class="post-content-body ml-3">
    <h6 class="font-weight-bold">{{Auth::user()->name}} <small class="text-muted">- March 28, 2019 </small></h5>
      <p class="">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
      </p>
      <div>
        <p>
          <i class="icon ion-md-happy p-1"> 3</i>
          <i class="icon ion-md-sad p-1"> 3</i>
          <i class="icon ion-md-chatboxes p-1"> 3</i>
        </p>
      </div>
  </div>
</div>

<div class="post-content border-top border-info pt-3 mt-3">
  <img src="{{Auth::user()->image}}" class="img-thumb" alt="user" />
  <div class="post-content-body ml-3">
    <h6 class="font-weight-bold">{{Auth::user()->name}} <small class="text-muted">- March 28, 2019 </small></h5>
      <p class="">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
      </p>
      <img src="{{ asset('img/my-post.png') }}" alt="" class="">
      <div class="mt-3">
        <p>
          <i class="icon ion-md-happy p-1"> 3</i>
          <i class="icon ion-md-sad p-1"> 3</i>
          <i class="icon ion-md-chatboxes p-1"> 3</i>
        </p>
      </div>
  </div>
</div>

<div class="post-content border-top border-info pt-3 mt-3">
  <img src="{{Auth::user()->image}}" class="img-thumb" alt="user" />
  <div class="post-content-body ml-3">
    <h6 class="font-weight-bold">{{Auth::user()->name}} <small class="text-muted">- March 28, 2019 </small></h5>
      <p class="">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
      </p>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/VSbUJt7dhNU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <div class="mt-3">
        <p>
          <i class="icon ion-md-happy p-1"> 3</i>
          <i class="icon ion-md-sad p-1"> 3</i>
          <i class="icon ion-md-chatboxes p-1"> 3</i>
        </p>
      </div>
  </div>
</div>
<!-- End content -->
@endsection