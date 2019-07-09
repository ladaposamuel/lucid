@extends('layouts.lucid')
@section('sidebar')
@parent

@endsection
@section('content')
<!-- Beginning of Post Content -->
<div class="post-content">
    <div class="post-content-body">
        <p class="post-date">Home / Blog / <span class="po post-body">Looking For Where To Spend
                Christmas</span></p>
        <cite class="post-body">
            Published on 21st of March, 2019
        </cite>
        <h3 class="post-title mb-h">
        @php
           echo strip_tags($post['title'])
        @endphp
        </h3>
        @isset($post['preview_img'])
        <img src="{{ asset('img/') }}{{$post['preview_img']}}" alt="" class="my-4">
        @endisset
        <div class="blog-content">
            {{ $post['body'] }}
        </div>
    </div>
</div>


</div>

<!-- End of Post Content -->
@endsection