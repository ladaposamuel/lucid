@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Beginning of Post Content -->
<div class="post-content">
    <div class="post-content-body">
        <p class="post-date">
        <a href="{{URL::to('/')}}/{{$user->username}}/home" class="text-secondary"> Home </a> /
        <a href="../home" class="text-secondary"> Blog </a> / <span class="text-muted">{{ $post['title'] }}</span></p>
        <cite class="post-body">
            Published on {{ $post['date'] }}
        </cite>
        <h3 class="post-title mb-1">
         {{ $post['title'] }}
        </h3>
        @isset($post['crawlerImage'])
        <img src="{{URL::to('/')}}/storage/{{$post['crawlerImage']}}" alt="" style="width:100%" class="my-1">
        @endisset
        <div class="blog-content">
            {!! $post['body'] !!}
        </div>
    </div>
</div>


</div>

<!-- End of Post Content -->
@endsection
