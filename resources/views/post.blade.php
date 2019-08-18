@extends('layouts.lucid')
@section('title')
  {{ $user->name }}
@endsection
@php
$location= 'post';
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
<!-- The editor code goes here -->
@if(Auth::user()->username == $user->username)
<div id="form-container">
  <form method="POST" class="timeline-editor" id="editor-form" autocomplete="OFF">
    <div class=" row pb-3">
      <div class="col-12">

        <div class="white-background mb-3">
          <div class="row pb-2">
            <div class="col-12">
              <div class="row form-group">
                <div class="col-12 mb-3" id="titleBox">
                  <label for="new-post-title" class="sr-only">Title</label>
                  <input type="text" id="new-post-title" class="form-control" placeholder="Title" />
                </div>
                <div class="col-12">
                  <div id="editor">
                    <input type="text" name="body">
                  </div>
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
      <div class="col-12 mt-3">
        <div class="row form-row flex-row-reverse">
          <!-- <div class="col-3 col-sm-3 col-md-2">
            <input type="button" class="form-control btn-sm btn btn-primary save-draft" value="Save Draft" />
          </div> -->
          <div class="col-3 col-sm-3 col-md-2">
            <input type="submit" class="form-control btn-sm btn btn-primary publish-post" value="Publish">
            <input type="hidden" class="form-control btn-sm btn btn-primary publish-post" value="Save Draft">
          </div>
          <div class="col-3 col-sm-3 col-md-2">
            <input class="form-control btn-sm btn btn-primary add-tags" type="button" data-toggle="collapse" data-target="  #collapseExample" aria-expanded="false" aria-controls="collapseExample" value="Add Tags">
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row pt-2">

      </div> -->
  </form>
</div>
<!-- Beginning of Post Content -->
@endif

@forelse($posts as $post)


<div class="post-content">
  @if($post['image'] !== '')
  <div class="post-image d-none d-lg-flex d-xl-flex d-md-flex">
    <img src="{{asset('storage')}}/{{$post['image']}}" class="img-fluid post-img" alt="What I think of Donald Glover’s New Video" />
  </div>
  @endif
  <div class="post-content-body">
    <p class="post-date">{{ $post['date'] }}</p>
    <h3 class="post-title">
      <a class="no-decoration text-dark" href="post/{{$post['slug']}}">{!! $post['title'] !!}</a>
    </h3>
    <p class="post-body">

      @php
        echo  strip_tags($post['body'])
      @endphp
    </p>
  </div>
</div>




<div class="text-center">
  <!--   <button class="btn btn-primary pagination">
    Previous articles <i class="pl-2 icon ion-ios-arrow-forward"></i>
  </button> -->
</div>


@empty

<div class="post-content">
  <div class="post-content-body">
    no posts yet
  </div>
</div>

@endforelse


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>
<!-- Convert to markdown script -->
<script src="https://unpkg.com/turndown/dist/turndown.js"></script>
<script src="https://unpkg.com/turndown-plugin-gfm/dist/turndown-plugin-gfm.js"></script>
<!-- convert to markdown script ends -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
let j = jQuery.noConflict();
  var toolbarOptions = [
    ['bold', 'italic'],
    ['blockquote'],
    [{
      'list': 'ordered'
    }, {
      'list': 'bullet'
    }],
    [{
      'header': [1, 2, 3, 4, 5, 6, false]
    }],
    ['link', 'image'],
    ['clean']
  ];

  var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
      toolbar: toolbarOptions
    },
    placeholder: 'Compose an epic...'
  });
  j(".ql-toolbar").css("display", "block");

  var form = document.querySelector('.timeline-editor');

  // handle creating new post
  form.onsubmit = newPostSubmitHandler;

  // handle saving draft
  document.querySelector('input[value="Save Draft"]').addEventListener('click', newPostSubmitHandler);

  function newPostSubmitHandler(event) {
    event.preventDefault();
    let currentPage = window.localStorage.getItem('page');
    const formData = new FormData(document.querySelector('#editor-form'));
    const blogBody = document.querySelector('.ql-editor').innerHTML;




    const title = document.querySelector("#new-post-title").value;


    // convert to markdown
    const turndownService = new TurndownService({
      codeBlockStyle: 'fenced'
    });
    const gfm = turndownPluginGfm.gfm;
    turndownService.use(gfm);
    let markdown = turndownService.turndown(blogBody);
    if (markdown !== "" && title !== "") {
      formData.set('title', title);
      // check if the form is being submitted
      // which would mean a new post is being created rather than saving a draft
      const newPostIsBeingCreated = event.target instanceof HTMLFormElement;

      // get all imageURIs in the document
      let imageURIs = markdown.match(/\!\[\]\(data:image\/\w+;base64,[^)]*\)/g);
      // are there images in the blog post?
      if (imageURIs) {
        // remove duplicates
        imageURIs = imageURIs.reduce((acc, curVal) => {
          if (!acc.includes(curVal)) acc.push(curVal);
          return acc;
        }, []);



        imageURIs.forEach(imageURI => {
          const [, fullURI, ext, uriData] = imageURI.match(/\!\[\]\((data:image\/(\w+);base64,([^)]*))\)/);
          const id = Math.random().toString(36).substr(2, 10);
          const newImgName = `img-${id}.${ext}`;


          // replace the image URI everywhere it occurs in the markdown
          let stillMatching = true;
          while (stillMatching) {
            if (markdown.includes(fullURI)) {
              markdown = markdown.replace(fullURI, `/storage/{{$user->username}}/images/${newImgName}`);
            } else {
              stillMatching = false;
            }
          }

          // add this info to the form data being sent to the backend
          formData.set(newImgName, uriData);
        });

      }


      formData.set('postVal', markdown);


      // get tags
      const selected = document.querySelectorAll('.tags:checked');
      const selectedTags = Array.from(selected).map(el => el.value);
      console.log(selectedTags);
      formData.set('tags', selectedTags);

      // send the form data

      j.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
          }
      });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "publish",
            data:formData,
            contentType: false,
            processData: false,
            success : function (res) {
              console.log(JSON.stringify(res));

                if (res.error == false && res.action == 'publish') {
                  window.localStorage.setItem('publish', 'success');
                  window.location = '/{{$user->username}}/posts';

                } else if (res.error == false && res.action == 'savedToDrafts') {
                  window.localStorage.setItem('savedToDrafts', 'success');
                  window.location = '/{{$user->username}}/posts';
                }
            }
        });

    } else {
      swal({
        text: "Sorry,both fields are required!",
        icon: "error",
      });
    }
  }

  j(document).ready(function() {
    const published = window.localStorage.getItem('publish');
    const savedToDrafts = window.localStorage.getItem('savedToDrafts');
    if (published == 'success') {
      window.localStorage.removeItem('publish');
      swal({
        text: "Your post was successfully created!",
        icon: "success",
      });
    } else if (savedToDrafts == 'success') {
      window.localStorage.removeItem('savedToDrafts');
      swal({
        text: "Your post was successfully created and saved to drafts!",
        icon: "success",
      });
    }
  });
</script>

@endsection
