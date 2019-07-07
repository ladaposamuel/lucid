@extends('layouts.lucid')
@section('sidebar')
@parent
@endsection
@section('content')
<!-- editor -->
<div class="row">
  <div class="col-12 col-sm-1"></div>
  <div class="col-12 col-sm-10">
    <!-- The editor code goes here -->
    <div id="form-container">
      <form method="POST" class="timeline-editor" id="editor-form">
        <div class="micro-blog-enclosure row pt-3 pb-3">
          <div class="col-12">
            <div class="row">
              <div class="col-12 text-right">
                <span id="num_char" class="badge badge-warning">Micro-Blog Mode</span>
              </div>
            </div>
            <div class="white-background mt-3 mb-3">
            <div class="row pt-3 pb-2">
              <div class="col-12">
                <div class="row form-group">
                  <div class="col-12" id="titleBox">
                    <label for="new-post-title" class="sr-only">Title</label>
                    <input type="text" id="new-post-title" class="form-control hide" placeholder="Title"/>
                  </div>
                  <div class="col-12">
                    <div id="editor"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12">
              <div class="row">
                <div class="col-12 m-2 collapse" id="collapseExample">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Politics">
                    <label class="form-check-label" for="inlineCheckbox1">Politics</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Sports">
                    <label class="form-check-label" for="inlineCheckbox1">Sports</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Health">
                    <label class="form-check-label" for="inlineCheckbox1">Health</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Technology">
                    <label class="form-check-label" for="inlineCheckbox1">Technology</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Music">
                    <label class="form-check-label" for="inlineCheckbox1">Music</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#News-Lifestyle">
                    <label class="form-check-label" for="inlineCheckbox1">News-Lifestyle</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Movies">
                    <label class="form-check-label" for="inlineCheckbox1">Movies</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tags" type="checkbox" id="inlineCheckbox1" value="#Fitness">
                    <label class="form-check-label" for="inlineCheckbox1">Fitness</label>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
          </div>
          <div class="col-12">
            <div class="row form-row flex-row-reverse">
              <div class="col-3 col-sm-2 col-md-1">
                <input type="reset" class="form-control btn-sm btn btn-primary canel-post" value="Cancel">
              </div>
              <div class="col-3 col-sm-3 col-md-2">
                <input type="button" class="form-control btn-sm btn btn-primary save-draft" value="Save Draft"/>
              </div>
              <div class="col-3 col-sm-3 col-md-2">
                <input type="submit" class="form-control btn-sm btn btn-primary publish-post" value="Publish">
              </div>
              <div class="col-3 col-sm-3 col-md-2">
                <input class="form-control btn-sm btn btn-primary add-tags" type="button" data-toggle="collapse" data-target="  #collapseExample"   aria-expanded="false" aria-controls="collapseExample" value="Add Tags">
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="row pt-2">

        </div> -->
      </form>
    </div>
  </div>
  <div class="col-11 col-sm-1"></div>

         <!-- Feed listing -->
      @foreach ($posts as $feeds)
      @if ($feeds['img'] ="")
      <div class="post-content">
        <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
          <img src="{{$feeds['img']}}" class="img-fluid post-img"
            alt="{{$feeds['title']}}" />
        </div>
        <div class="post-content-body">
          <p class="post-date">{{$feeds['date']}}</p>
          <h3 class="post-title">
            {{$feeds['title']}}
          <p class="post-body">
          {{$feeds['desc']}}
          </p>
        </div>
      </div>
      @endif
      <div class="post-content">
        <div class="post-content-body">
          <p class="post-date">{{$feeds['date']}}</p>
          <h3 class="post-title">
            {{$feeds['title']}}
          </h3>
          <p class="post-body">
            {{$feeds['desc']}}
          </p>
        </div>
      </div>
      @endforeach
      <!-- Feed section ends here -->
</div>
@endsection
