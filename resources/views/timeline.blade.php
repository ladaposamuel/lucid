@extends('layouts.lucid')
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
<ul class="nav nav-tabs" id="timeline-tabs" role="tablist">
  <li class="nav-item">
    <a href="#timeline" class="nav-link tab-link active" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="true">
      <h6>Profile</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="#following" class="nav-link tab-link" data-toggle="tab" role="tab" aria-controls="following" aria-selected="false">
      <h6>Following</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="#followers" class="nav-link tab-link" data-toggle="tab" role="tab" aria-controls="followers" aria-selected="false">
      <h6>Follwers</h6>
    </a>
  </li>
</ul>

<div class="tab-content">
  <!-- Timeline Page -->
  <div class="container tab-pane fade in show active" role="tabpanel" id="timeline">
    <div class="row mt-5">
      <div class="col-md-12">
        @foreach ($posts as $feeds)
        <div class="post-content">
          @if (empty($feeds->site_image))
          <img src="{{ asset('img/logo.jpg') }}" style="border-radius:100%;height:60px; height:60px" class="img-fluid" alt="user" />
          @else
          <img src="{{ $feeds->site_image}}" style="border-radius:100%;height:60px; height:60px" class="img-fluid" alt="user" />
          @endif
          <div class="post-content-body">
            <a href="{{$feeds->link}}">
              <h5 class="font-weight-bold">{{$feeds->title}}</h5>
            </a>
            <p class="">
              {{$feeds->des}}
            </p>
            <p class="">{{$feeds->site}} -<small class="text-muted">{{$feeds->date}} </small></p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- End Timeline Page -->

  <!-- Following Page -->
  <div class="tab-pane fade" role="tabpanel" id="following">
    <h3 class="mt-5">Following page coming soon...</h3>
  </div>
  <!-- End following Page -->

  <!-- Followers Page -->
  <div class="tab-pane fade" role="tabpanel" id="followers">
    <h3 class="mt-5">Followers page coming soon...</h3>
  </div>
  <!-- End followers page -->
</div>

</html>
@endsection