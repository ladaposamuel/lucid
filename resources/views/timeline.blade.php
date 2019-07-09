@extends('layouts.lucid')
@section('sidebar')
@parent
@endsection
@section('content')
<style>
  .btn.btn-primary.canel-post{background-color: transparent !important; border: 1px solid red; color: red; padding: 6px 5px;}
  .btn.btn-primary.publish-post, .btn.btn-primary.save-draft, .btn.btn-primary.add-tags{background-color: #280a66 !important; border: 1px solid #280a66; padding: 6px 5px; color: #fff;}

  .main-content{padding-top: 30px; padding-bottom: 30px;}

  .btn-info{background-color: #280a66 !important; border: 0 !important;}

  .hide{display: none !important;}
  .show{display: block !important;}

  .form-check-label{padding-right: 10px;}
  .mb-editor-area {
    background: #f5f5f5;
    border-radius: 5px;
  }

  #new-post-title{border-radius: 10px 10px 0 0 !important;}
  .mb-editor {
    background: #ffffff;
    border-radius: 5px;
  }

  .ql-toolbar.ql-snow + .ql-container.ql-snow {
    border: none !important;
  }

  .ql-editor {
      border:none !important;
  }
  .ql-toolbar.ql-snow {
    border: none !important;
  }

  .white-background{background-color: #fff; border-radius: 5px;}
  .form-control {
    border: none !important;
  }

  .micro-blog-enclosure{
    background-color: #E0E0E0;
    border-radius: 10px;
  }

  .editor-btns {
  background: #280a66;
  border-radius: 5px;
  }

  /*Tag styles*/
  .tags {padding-right: 10px;}
  .btn-outline-primary:not(:disabled):not(.disabled).active, .btn-outline-primary:not(:disabled):not(.disabled):active, .show>.btn-outline-primary.dropdown-toggle {
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
    border: none;
    font-size: 18px;
    line-height: 22px;
    resize: none;
  }

  .mb-textarea::placeholder {
    font-weight: bold;

  }

  .mb-textarea:focus {
    outline: none !important;
    border: 0;
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

    .mb-textarea {
      font-size: 14px;
      padding: 0 !important;
    }

    .reply-form {
      width: 100% !important;
    }
  }
</style>
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
                  <div id="editor">
                    <input type="text" name="body" >
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script language="JavaScript" type="text/javascript">
   function unsubscribe(id,data)
   {
     if (confirm("Are you sure you want to unsubscribe '" + id + "'"))
     {
       window.location.href = '/unsubscribe?n=' + data;
     }
   }
   </script>

<!-- Side bar script -->
<script type="text/javascript">
  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
    });
  });

  $(document).ready(function () {
    $('#sidebar-Collapse').on('click', function () {
      $('#sidebar').toggleClass('active');
      $('#sidebar-collapse').toggleClass('hidden fas fa-arrow-circle-left fa-2x');
      $('#sidebar-collapse-2').toggleClass('visible fas fa-arrow-circle-right fa-2x');
    });
  });
  // Code for editor switching....
  //added the below code just to know what page the user is in
  //code kinda stupid tho

 //Initialize Quill editor
     // e.preventDefault();
     var toolbarOptions = [
    ['bold', 'italic'],
    ['blockquote'],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
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
  $(".ql-toolbar").css("display", "none");
  var content_id = 'editor';

  max = 50;
  //binding keyup/down events on the contenteditable div
  $('#'+content_id).keyup(function(e){ check_charcount(content_id, max, e); });
  $('#'+content_id).keydown(function(e){ check_charcount(content_id, max, e); });

  function check_charcount(content_id, max, e)
  {

    if($('#'+content_id).text().length > max)
    {

      //$('#new-post-title').addClass('form-control show');
      document.getElementById('new-post-title').setAttribute('class','form-control show')
      document.getElementById("num_char").innerHTML = "Full Blog Mode";
      $(".ql-toolbar").css("display", "block");
    }else{
      $(".ql-toolbar").css("display", "none");
      //$('#new-post-title').removeClass('form-control show');
      document.getElementById('new-post-title').classList.remove("form-control show");
      document.getElementById("num_char").innerHTML = "Micro-blog Mode";

    }
  }

  // code for editormode switching ends here..
  // and starts here again by problemSolved
  window.onload = function()
  {
    let currentPage = window.localStorage.getItem('page');
    let issetTitle=window.localStorage.getItem('title');
    if(currentPage == 'Published Posts')
    {
      if(issetTitle)
      {
        //$('#new-post-title').addClass('form-control show');
        document.getElementById('new-post-title').setAttribute('class','form-control show')
      }

    }
  }

  // to toggle between active and inactive sidebar nav links -----------------------
  /*NB this is not want we wnat but after delebration, we will get a solution for it..
  We have to find a way to keep the active class on the active navItem even on refresh
  The best way i think is to detect the current URL*/

  // Get the container element
  var navLinks = document.getElementById("myNavLinks");

  // Get all buttons with class="btn" inside the container
  var navLinks = navLinks.getElementsByClassName("navLink");

  // Loop through the buttons and add the active class to the current/clicked button
  for (var i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener("click", function() {
      var currentNavItem = document.getElementsByClassName("active");
      currentNavItem[0].className = currentNavItem[0].className.replace(" active", "");
      this.className += " active";
    });
  }
  // Nav item state change ends here --------------------------------------------------
</script>

<!--Email login modal (uncomment this code for modal to work, but then, the side war won't work-->
<script>
  const $$ = document.querySelector.bind(document)
  let congrat = $$('.login-mail-sent')
  let form_l = $$('.login-form')
  let message = $$('.magic-msg')

  // new scripts start here
  let loader_container = $$('#loader-container');
  let loader_content = $$('#loader-content')
  let mail_sent = $$('.mail-sent');
  let mail_error = $$('.mail-error');

  // new scripts end here
  congrat.style.display = 'none';
  let sendEmail = () => {

    loader_container.style.display = 'initial'; // new script

    let param = $$('.email-input').value;
    let host = $$('.host').value;
    let url = `https://auth.techteel.com/api/login/email?address=${param}&domain=${host}`;
    fetch(url)
      .then((res) => { return res.json() })
      .then((data) => {
        console.log(data)
        if (data.error === false) {
          // changing from confirmation modal to full page

          //form_l.style.display = 'none';
          //congrat.style.display = 'block';
          //message.innerHTML = "Magic link sent successfully, check your email.";
          loader_content.style.display = 'none';
          mail_sent.style.display = 'block';

        }
        else {
          // form_l.style.display = 'none';
          // congrat.style.display = 'block';
          // message.innerHTML = data.message;
          loader_content.style.display = 'none';
          mail_error.style.display = 'block';
        }

      })
      .catch((e) => {
        console.log(e)
      })
  };
  let closeModal = () => {
    loader_container.style.display = 'none'
  }
  $$('.email-login-button').addEventListener('click', sendEmail);
  // for close button on loader
  document.addEventListener('click', function(event){
    if(event.target.classList.contains('loader-close-button')){
      closeModal();
    }
  }, false)
</script>

<!-- Convert to markdown script -->
<script src="https://unpkg.com/turndown/dist/turndown.js"></script>
<script src="https://unpkg.com/turndown-plugin-gfm/dist/turndown-plugin-gfm.js"></script>
<!-- convert to markdown script ends -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

  // added by sleekX
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

    if(title != ""){
      formData.set('title', title);
    }

    if(currentPage == 'Edit Post')
    {
      const postid = document.querySelector("#postid").value;
      formData.set('postId', postid);
    }

    // convert to markdown
    const turndownService = new TurndownService({ codeBlockStyle: 'fenced' });
    const gfm = turndownPluginGfm.gfm;
    turndownService.use(gfm);
    let markdown = turndownService.turndown(blogBody);
    if(markdown !== ""){
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
              markdown = markdown.replace(fullURI, `/storage/images/${newImgName}`);
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

    if(currentPage == 'Edit Post')
    {
      fetch(newPostIsBeingCreated ? '/edit-post' : '/saveDraft', {
      method: 'POST',
      body: formData
      }).then(res => res.json()).then((res) => {
        //console.log(JSON.stringify(res));

        if(res.error == false && res.action == 'update')
        {

          swal("Good job!", "You posts was successfully updated.", "success");
        }

      }).catch((err) => {
        alert(`Failed with the following message: ${err.message}`);
      });
    }
    else
    {
      fetch(newPostIsBeingCreated ? './publish' : './saveDraft', {
      method: 'POST',
      body: formData
      }).then(res => res.json()).then((res) => {
        //console.log(JSON.stringify(res));

        if(res.error == false && res.action == 'publish')
        {
          window.localStorage.setItem('publish','success');
          window.location = './timeline';

        }
        else if(res.error == false && res.action == 'savedToDrafts')
        {
          window.localStorage.setItem('savedToDrafts','success');
          window.location = './timeline';
        }

      }).catch((err) => {
        alert(`Failed with the following message: ${err.message}`);
      });
    }

  }
  else{
    swal({
          text: "Sorry,the post field is required!",
          icon: "error",
        });
  }
  }
  // sleekx code ends here
  $(document).ready(function () {
    const published =window.localStorage.getItem('publish');
    const savedToDrafts =window.localStorage.getItem('savedToDrafts');
    if(published == 'success')
    {
      window.localStorage.removeItem('publish');
      swal({
          text: "Your post was successfully created!",
          icon: "success",
        });
    }
    else if (savedToDrafts == 'success' )
    {
      window.localStorage.removeItem('savedToDrafts');
      swal({
          text: "Your post was successfully created and saved to drafts!",
          icon: "success",
        });
    }
  });


</script>
<script>
  //submit about section form starts here
  var editAboutForm = document.querySelector('.edit-about');
  editAboutForm.onsubmit = document.querySelector('button[name="editAbout"]').addEventListener('click', function(event){
    event.preventDefault();
    const AboutFormData = new FormData(document.querySelector('#aboutFormField'));
    const about = document.querySelector("#aboutMe").value;
    if(about == '' )
    {
      $('#aboutModal').modal('hide');
      swal({
          text: "Oops!You can't save an empty content.",
          icon: "info",
        });
    }
    else
    {
      fetch('/edit-about', {
      method: 'POST',
      body: AboutFormData
      }).then(res => res.json()).then((res) => {
        //console.log(JSON.stringify(res));

        if(res.success == true)
        {
          window.localStorage.setItem('aboutsaved','success');
          window.location = '/about';

        }
        else if(res.error == true)
        {
          window.localStorage.setItem('error','true');
          window.location = '/about';
        }

      }).catch((err) => {
        alert(`Failed with the following message: ${err.message}`);
      });
    }
  });

  $(document).ready(function () {
    const PageSaved =window.localStorage.getItem('aboutsaved');
    const ifErrorOcurred =window.localStorage.getItem('error');
    if(PageSaved == 'success')
    {
      window.localStorage.removeItem('aboutsaved');
      swal({
          text: "Your changes has been saved successfully!",
          icon: "success",
        });
    }
    else if (ifErrorOcurred == 'true' )
    {
      window.localStorage.removeItem('error');
      swal({
          text: "Sorry! An error occurred while trying to save your changes",
          icon: "error",
        });
    }
  });
  //submit about section form ends here

  var contactForm = document.querySelector('.contact-form');
  contactForm.onsubmit = document.querySelector('button[name="sendMail"]').addEventListener('click', function(event){
    event.preventDefault();
    const ContactFormData = new FormData(document.querySelector('#contactFormFields'));
    // const name = document.querySelector("#guestName").value;
    // const email = document.querySelector("#guestEmail").value;
    // const subject = document.querySelector("#guestEmail").value;
    fetch('/send',{
      method: 'POST',
      body: ContactFormData
    }).then(res=>res.json()).then((res)=>{
      //console.log(JSON.stringify(res));
      if(res.FormFieldError){
        swal({
          text: res.FormFieldError,
          icon: "error",
        });
      }else if(res.serverError)
      {
        swal({
          text: res.serverError,
          icon: "warning",
        });
      }else if(res.success)
      {
        document.querySelector('#contactFormFields').reset();
        swal({
          text: res.success,
          icon: "success",
        });
      }

      if(res.nameError)
      {
        const nameErrorContainer=document.querySelector('#nameError');
        nameErrorContainer.style.display='block';
        nameErrorContainer.innerHTML = res.nameError;
      }
      else
      {
        const nameErrorContainer=document.querySelector('#nameError');
        nameErrorContainer.style.display='none';
        nameErrorContainer.innerHTML = '';
      }

      if(res.emailError)
      {
        const emailErrorContainer=document.querySelector('#emailError');
        emailErrorContainer.style.display='block';
        emailErrorContainer.innerHTML = res.emailError;
      }
      else
      {
        const emailErrorContainer=document.querySelector('#emailError');
        emailErrorContainer.style.display='none';
        emailErrorContainer.innerHTML = '';
      }

      if(res.subjectError)
      {
        const subjectErrorContainer=document.querySelector('#SubjectError');
        subjectErrorContainer.style.display='block';
        subjectErrorContainer.innerHTML = res.subjectError;
      }
      else
      {
        const subjectErrorContainer=document.querySelector('#SubjectError');
        subjectErrorContainer.style.display='none';
        subjectErrorContainer.innerHTML = "";
      }

      if(res.msgError)
      {
        const msgErrorContainer=document.querySelector('#msgError');
        msgErrorContainer.style.display='block';
        msgErrorContainer.innerHTML = res.msgError;
      }
      else
      {
        const msgErrorContainer=document.querySelector('#msgError');
        msgErrorContainer.style.display='none';
        msgErrorContainer.innerHTML = "";
      }


    }).catch((err)=>{
      alert(`Failed with the following message: ${err.message}`);
    });

  });
</script>
<script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script>
<footer>
  <div class="container-fluid">
    <div class="row footer">
      <div class="col-12 text-right ">
        <p class="footer-item">Powered by<span class="lucid">Lucid</span></p>
      </div>
    </div>
  </div>
</footer>
<!-- alert -->
<script src="./resources/themes/ghost/assets/js/toast.js"></script>

</html>
@endsection
