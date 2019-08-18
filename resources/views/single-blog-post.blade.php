@extends('layouts.lucid')
@section('title')
@if(Auth::user() && Auth::user()->username == $user->username)
{{ $post['title'] }} - {{ $user->username }} - Lucid
@else
{{ $post['title'] }} - {{ $user->name }} (@ {{ $user->username }})
@endif
@php
$location= 'singlePost';
@endphp
@endsection
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

        <div class="blog-content">
            {!! $post['body'] !!}
        </div>
    </div>
</div>


</div>

<!-- End of Post Content -->
@endsection
