@extends('layouts.lucid')
@section('title')
  {{ $user->name }}
@endsection
@section('sidebar')
@parent
@endsection
@section('content')
<style>
  .form-control {
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }
</style>
<!-- beginning of settings page -->
<div class="page-tab">
  <!-- tab navigation here -->
  <h4><strong>Settings</strong></h4>
  <ul class="nav nav-tabs navbar-light" id="settings-tabs" role="tablist">
    <li class="nav-item">
      <a href="#profile" class="nav-link tab-link active" id="profile-tab" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="true">
        <h6>Profile</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#account" class="nav-link tab-link" id="account-tab" data-toggle="tab" role="tab" aria-controls="account" aria-selected="false">
        <h6>Account</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#links" class="nav-link tab-link" id="links-tab" data-toggle="tab" role="tab" aria-controls="links" aria-selected="false">
        <h6>Links</h6>
      </a>
    </li>
    <li class="nav-item">
      <a href="#security" class="nav-link tab-link" id="security-tab" data-toggle="tab" role="tab" aria-controls="links" aria-selected="false">
        <h6>Security</h6>
      </a>
    </li>
  </ul>
  <!-- tab content here -->
  <div class="tab-content" id="settings-tabs-content">
    <!-- profile settings tab -->
    <div class="tab-pane fade in show active" id="profile" role="tabpanel">
      <form action="" class="mt-5" autocomplete="off" id="settingsForm">
        <div class="row">
          <div class="form-group col-sm-12 col-md-6">
            <label for="name"><strong>Full Name</strong></label>
            <span class="text-danger" id="fullname" style="display:none;"></span>
            <input class="form-control" type="text" name="name" id="name" value="{{Auth::user()->name}}" placeholder="e.g Jon Champion" />
          </div>
          <div class="form-group col-sm-12 col-md-6">
            <label for="email"><strong>Email Address</strong></label>
            <span class="text-danger" id="emailError" style="display:none;"></span>
            <input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" placeholder="example@gmail.com" />
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-12 col-md-6">
            <label for="nick-name"><strong>Username</strong></label>
            <input class="form-control" type="text" name="nickname" id="nick-name" value="{{Auth::user()->username}}" disabled/>
          </div>
          <div class="form-group col-sm-12 col-md-6">
            <p class="font-weight-bold">Profile Image</p>
            <div class="d-flex">
              <div class="d-inline-block">
                <img src="{{Auth::user()->image}}" class="img-thumb" alt="user" id="imgtag"/>
              </div>
              <div class="d-inline-block ml-3 py-2">
                <input type="file" name="profileimage" id="profileimage" class="form-control-file" accept=".png,.jpg" style="display:none">

                <label class="text-muted form-control p-2 w-100" for="profileimage" style="cursor:pointer">Choose file</label>
                <span class="text-danger" id="imgError" style="display:none;"></span>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-12 col-md-6">
            <label for="bio"><strong>Short Bio</strong></label>
            <textarea name="bio" id="bio" class="form-control" rows="5" placeholder="type here..">{{Auth::user()->short_bio}}</textarea>
          </div>
        </div>
        <!-- submit button -->
        <button type="submit" class="btn btn-lg col-sm-12 col-md-3 mt-5" name="update">Update Profile</button>
      </form>
    </div>

    <!-- account tab -->
    <div class="tab-pane fade" id="account" role="tabpanel">
      <h3 class="mt-5">Account page coming soon...</h3>
    </div>
    <!-- links tab -->
    <div class="tab-pane fade" id="links" role="tabpanel">
      <h3 class="mt-5">Links page coming soon...</h3>
    </div>
    <!-- security tab -->
    <div class="tab-pane fade" id="security" role="tabpanel">
      <h3 class="mt-5">Security page coming soon...</h3>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- convert to markdown script ends -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
  let j = jQuery.noConflict();
  j(document).ready(function (){

    ////render selected image to the profile image tag
    j("#profileimage").on('change',function(){
      const file = $(this)[0].files;

      if (file.length == 1 ){

         const reader = new FileReader();
         const imgTag = document.getElementById('imgtag');
         reader.onload = function(event){
           imgTag.src=event.target.result;
         }

         reader.readAsDataURL(file[0])
      }

    })


    document.querySelector('button[name="update"]').addEventListener('click',function (event){
      event.preventDefault();
      const formData = new FormData(document.querySelector('#settingsForm'));


      j.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            }
        });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "save_settings",
            data:formData,
            contentType: false,
            processData: false,
            success : function (response) {
              // console.log(JSON.stringify(res));

                if (response.success) {
                    swal({
                      text: response.success,
                      icon: "success",
                    })

                    if(response.img_path){
                       document.querySelector('#user-avatar').src = response.img_path;
                    }
                    document.querySelector('#user-name').innerHTML = formData.get('name');
                    if(formData.get('bio') !==""){
                       document.querySelector('#user-bio').innerHTML = formData.get('bio');
                       document.querySelector('#user-bio').style.color = "#000";

                    }else {
                      document.querySelector('#user-bio').innerHTML = 'You haven\'t set up a short bio about yourself, do that here';
                      document.querySelector('#user-bio').style.color = "#a9a9a9";
                    }
                  
                }

                const name = document.querySelector('#fullname');
                const email = document.querySelector('#emailError');
                const img = document.querySelector('#imgError');
                if (response.name){
                    name.style.display="block"
                    name.innerHTML = response.name
                }else {
                    name.style.display="none"
                    name.innerHTML = ''
                }

                if (response.email){
                    email.style.display="block"
                    email.innerHTML = response.email
                }else {
                    email.style.display="none"
                    email.innerHTML = ''
                }

                if (response.profileimage){
                    img.style.display="block"
                    img.innerHTML = response.profileimage
                }else {
                    img.style.display="none"
                    img.innerHTML = ''
                }
              
            }
        });

      

    })

  })
</script>
@endsection