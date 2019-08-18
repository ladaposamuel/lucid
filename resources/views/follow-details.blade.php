@extends('layouts.lucid')
@section('title')
{{ $user->name }} - Lucid
@endsection
@php
$location= 'follow';
@endphp
@section('sidebar')
@parent
@endsection
@section('content')
<style>
  .btn.btn-primary.canel-post {
    background-color: transparent !important;
    border: 1px solid red;
    color: red;
    padding: 6px 5px;
  }

  .btn.btn-primary.publish-post,
  .btn.btn-primary.save-draft,
  .btn.btn-primary.add-tags {
    background-color: #280a66 !important;
    border: 1px solid #280a66;
    padding: 6px 5px;
    color: #fff;
  }

  .main-content {
    padding-top: 30px;
    padding-bottom: 30px;
  }

  .btn-info {
    background-color: #280a66 !important;
    border: 0 !important;
  }



  .form-check-label {
    padding-right: 10px;
  }

  .mb-editor-area {
    background: #f5f5f5;
    border-radius: 5px;
  }

  #new-post-title {
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }

  .mb-editor {
    background: #ffffff;
    border-radius: 5px;
  }


  .micro-blog-enclosure {
    background-color: #E0E0E0;
    border-radius: 10px;
  }

  .editor-btns {
    background: #280a66;
    border-radius: 5px;
  }

  /*Tag styles*/
  .tags {
    padding-right: 10px;
  }

  .btn-outline-primary:not(:disabled):not(.disabled).active,
  .btn-outline-primary:not(:disabled):not(.disabled):active,
  .show>.btn-outline-primary.dropdown-toggle {
    color: #fff !important;
    background-color: #280a66 !important;
    border-color: #280a66 !important;
  }

  .btn-outline-primary {
    color: #280a66 !important;
    border-color: #280a66 !important;
  }

  .btn-outline-primary:hover {
    color: #fff !important;
    background-color: #280a66 !important;
    border-color: #280a66 !important;
  }

  /*tag styples end here..*/
  .mb-textarea {
    /* border: none; */
    font-size: 18px;
    line-height: 22px;
    resize: none;
  }

  .mb-textarea::placeholder {
    font-weight: bold;

  }

  .mb-textarea:focus {
    outline: none !important;
    border: 1px solid red;
    box-shadow: none;
  }

  .mb-icon-link {
    color: #000000;
  }

  .mb-icon-link:hover {
    color: #000000;
  }

  .icon-audio,
  .icon-photo,
  .icon-video {
    cursor: pointer;
  }

  .icon-audio {
    color: #C61639;
  }

  .icon-photo {
    color: #280a66;
  }

  .icon-video {
    color: #6C63FF;
  }

  .btn-mb-post,
  .btn-mb-submit {
    background: #3B0E75;
    color: #ffffff;
    border-radius: 5px;
    border: none;

  }

  .btn-mb-post:hover,
  .btn-mb-submit:hover,
  .btn-mb-cancel {
    background: #ffffff;
    color: #3B0E75;
    border-radius: 5px;
    border: 1px solid #3B0E75;

  }

  .mb-content {
    color: var(--mb-text-color);
    font-size: 18px;
    line-height: 140%;
  }

  .mb-image {
    object-fit: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
  }

  .mb-title {
    color: #000000;
    line-height: 1.3em;
    font-size: 24px;
  }

  .mb-title:hover {
    color: #000000;
    text-decoration: underline;
  }

  .mb-post-time {
    color: #000000;
    font-size: 14px;
    font-weight: 500;
  }

  .mb-reply {
    color: var(--primary-color);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
  }

  .mb-reply:hover {
    color: var(--primary-color);
    text-decoration: underline;
  }

  .mb-pagination a {
    color: var(--primary-color);
    font-size: 18px;
    font-weight: 500;
  }

  .mb-pagination a:hover {
    color: var(--primary-color);
    text-decoration: underline;
  }

  /* Media Query */
  @media screen and (max-width: 768px) {
    .mb-editor {
      flex-direction: column-reverse;
      padding: 1rem 0.5rem !important;
      align-items: flex-start !important;
    }

    .textarea-control {
      align-items: flex-start !important;
      margin-top: 1rem !important;
    }

    .mb-textarea,
    .mb-audio,
    .mb-photo,
    .mb-video {
      margin: 0 0 0 4px !important;
    }

    /* .mb-textarea {
      font-size: 14px;
      padding: 0 !important;
    } */

    .reply-form {
      width: 100% !important;
    }
  }
</style>
<div class="row">
  <div class="col-12 col-sm-1"></div>
  <div class="col-12 col-sm-10">

  </div>
  <div class="col-11 col-sm-1"></div>

  <!-- Feed section ends here -->
</div>

<!-- Begin content -->
<div class="page-tab">
  <ul class="nav nav-tabs navbar-light" id="follow-tabs" role="tablist">
    <li class="nav-item">
      <a href="#following" class="nav-link tab-link active" data-toggle="tab" role="tab" aria-controls="following" aria-selected="false" onclick="changeUrl('following')">
        <h6>Following</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#followers" class="nav-link tab-link" data-toggle="tab" role="tab" aria-controls="followers" aria-selected="false" onclick="changeUrl('followers')">
        <h6>Followers</h6>
      </a>
    </li>
  </ul>

</div>
<div class="tab-content">
  <!-- Following Page -->
  <div class="tab-pane show active" role="tabpanel" id="following">
    @if (Auth::user() && Auth::user()->username == $user->username)
    <h5 class="my-3 font-weight-bold">You're following</h5>
    @else

    <h5 class="my-3 font-weight-bold">{{ $user->name}} is following</h5>
    @endif

    @if(empty($following))

      <p class="mb-2">{{ $user->name}} is following no User</p>

    @else
    @foreach ($following as $follow)
    <div class="post-content border p-3 my-2">
      <img src="{{$follow['img']}}" class="img-fluid img-thumb" alt="user" />
      <div class="post-content-body">
        <p class="m-0 font-weight-bold"><a href="{{URL::to('/')}}/{{$follow['username']}}/">{{$follow['name']}}</a></p>
        <p class="mb-2">{{$follow['desc']}}</p>

@php
      if(in_array($follow['name'],$followerArray)){ @endphp
        <a data-toggle="modal" data-target="#unfollowModal{{$follow['id']}}" href="#" class="no-decoration text-secondary font-weight-bold">Unfollow</a>
        <div class="follow-me text-center pt-3">

        <div class="modal fade" id="unfollowModal{{$follow['id']}}" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">

            <div>
              <img src="{{$follow['img']}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
              <br>
              <br>
              <h4 class="text-main">Unfollow  {{$follow['name']}}</h4>
              <p class="small"><em>Are you sure you want to Unfollow {{$follow['name']}} and miss out interesting post?<br /> Click the button below to unfollow</em></p>
              <form method="POST" action="{{URL::to('/')}}/{{ $user->username}}/unfollow">
                @csrf
                <input type="hidden" name="rss" value="{{$follow['username']}}">
                <button type="submit" class="btn btn-primary">UnFollow</button>
              </form>
            </div>

          </div>
        </div>
      </div>
      </div>
      </div>
      @php  }else if(Auth::user() && Auth::user()->username == $follow['username']) { @endphp
<p>You</p>
    @php  }else { @endphp
      <a href="#" data-toggle="modal" data-target="#followModal{{$follow['id']}}" class="no-decoration text-secondary font-weight-bold">Follow</a>
      <div class="follow-me text-center pt-3">

      <div class="modal fade" id="followModal{{$follow['id']}}" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div>
                <img src="{{$follow['img']}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
                <br>
                <br>
                <h4 class="text-main">Follow {{$follow['name']}}</h4>
                <p class="small"><em>Do you have or would love to have Lucid installed on your domain?<br /> Click the button below to follow me</em></p>
                <form method="POST" action="{{URL::to('/')}}/{{ $user->username}}/addrss">
                  @csrf
                  <input type="hidden" name="rss" value="{{$follow['username']}}">
                  <button type="submit" class="btn btn-primary">Follow me on Lucid</button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  @php  } @endphp
      </div>
    </div>
    @endforeach
    @endif
  </div>
  <!-- End following Page -->

  <!-- Followers Page -->
  <div class="tab-pane" role="tabpanel" id="followers">
      @if (Auth::user() && Auth::user()->username == $user->username)
    <h5 class="my-3 font-weight-bold">Your followers</h5>
    @else
    <h5 class="my-3 font-weight-bold">Follower of {{ $user->name}}</h5>
    @endif

    @foreach ($follower as $follower)
    <div class="post-content border p-3 my-2">
      <img src="{{$follower['img']}}" class="img-fluid img-thumb" alt="user" />
      <div class="post-content-body">
        <a href="{{URL::to('/')}}/{{$follower['username']}}/">
          <p class="m-0 font-weight-bold">{{$follower['name']}}</p>
        </a>
        <p class="mb-2">{{$follower['desc']}}</p>


        @php
              if(in_array($follower['name'],$followerArray)){ @endphp
                <a data-toggle="modal" data-target="#unfollowModalf{{$follower['id']}}" href="#" class="no-decoration text-secondary font-weight-bold">Unfollow</a>
                <div class="follow-me text-center pt-3">

                <div class="modal fade" id="unfollowModalf{{$follower['id']}}" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">

                    <div>
                      <img src="{{$follower['img']}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
                      <br>
                      <br>
                      <h4 class="text-main">Unfollow  {{$follower['name']}}</h4>
                      <p class="small"><em>Are you sure you want to Unfollow {{$follower['name']}} and miss out interesting post?<br /> Click the button below to unfollow</em></p>
                      <form method="POST" action="{{URL::to('/')}}/{{ $user->username}}/unfollow">
                        @csrf
                        <input type="hidden" name="rss" value="{{$follower['username']}}">
                        <button type="submit" class="btn btn-primary">UnFollow</button>
                      </form>
                    </div>

                  </div>
                </div>
              </div>
              </div>
              </div>
                @php  }else if(Auth::user() && Auth::user()->username == $follower['username']) { @endphp
<p>You</p>
              @php  }else { @endphp
                <a href="#" data-toggle="modal" data-target="#followModalf{{$follower['id']}}" class="no-decoration text-secondary font-weight-bold">Follow</a>
                <div class="follow-me text-center pt-3">

                <div class="modal fade" id="followModalf{{$follower['id']}}" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                        <div>
                          <img src="{{$follower['img']}}" width="100" height="100" style="border-radius:100%;" class="img-fluid" />
                          <br>
                          <br>
                          <h4 class="text-main">Follow {{$follower['name']}}</h4>
                          <p class="small"><em>Do you have or would love to have Lucid installed on your domain?<br /> Click the button below to follow me</em></p>
                          <form method="POST" action="{{URL::to('/')}}/{{ $user->username}}/addrss">
                            @csrf
                            <input type="hidden" name="rss" value="{{$follower['username']}}">
                            <button type="submit" class="btn btn-primary">Follow me on Lucid</button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
        @php  } @endphp
      </div>
    </div>
    @endforeach

  </div>
  <!-- End followers page -->
</div>
<!-- Hold username value -->
<input type="hidden" value="{{ $user->username }}" id="username">




@endsection
