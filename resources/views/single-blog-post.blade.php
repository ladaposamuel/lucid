@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Beginning of Post Content -->
<div class="post-content">
    <div class="post-content-body">
        <p class="post-date">
        <a href="{{URL::to('/')}}/{{$user->username}}/home"> Home </a> /
        <a href="../home"> Blog </a> / <span class="text-muted">{{ $post['title'] }}</span></p>
        <cite class="post-body">
            Published on {{ $post['date'] }}
        </cite>
        <h3 class="post-title mb-h">
         {{ $post['title'] }}
        </h3>
        @isset($post['crawlerImage'])
        <img src="{{URL::to('/')}}/storage/{{$post['crawlerImage']}}" alt="" style="width:100%"class="my-4">
        @endisset
        <div class="blog-content">
            {!! $post['body'] !!}
        </div>
    </div>
</div>


</div>

<!-- End of Post Content -->
@endsection
