@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Editor -->
<p>Write a Post</p>
<form class="mb-3">
  <div class="form-row mb-3">
    <div class="col-7">
      <input type="text" class="form-control" placeholder="Title">
    </div>
    <div class="col-4 offset-md-1 border-dark ">
      <input type="file" class="" id="customFile" style="display:none">
      <label class="text-muted form-control p-2 w-100" for="customFile"><i class="icon ion-md-add p-1"></i> Add post Image</label>
    </div>
  </div>
  <div class="form-group">
    <textarea type="text" class="form-control h-25" placeholder="Tell your story"></textarea>
  </div>
  <div class="text-right">
    <button type="submit" class="btn bg-alt text-white">Publish</button>
  </div>
</form>
<!-- End Editor -->

<h5 class="font-weight-bold mb-5">Latest stories</h5>
 <!-- Begin content -->
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

<!-- End content -->
@endsection