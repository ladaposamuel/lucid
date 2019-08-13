@extends('layouts.lucid')
@section('title')
  {{ $user->name }}
@endsection
@section('sidebar')
@parent
@endsection
@section('content')
<!-- Beginning of contact page -->

<!-- Beginning of Post Content -->
<style>
  .form-control{
    outline: 0px !important;
    -webkit-appearance: none;
    box-shadow: none !important;
  }
</style>

<div class="container">
@guest
<h4 class="font-weight-bold mb-4">Contact Me</h4>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat accumsan sodales. In ac euismod augue. Quisque vel porta metus, sit amet aliquam eros.
    </p>
    <form class="font-weight-bold mt-4 mb-0 contact-form" autocomplete="OFF" id="formFields" action="">
        <div class="form-group row">
            <div class="col-sm-12 col-md-6">
                <label for="name" class="mb-2 mr-sm-2">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="name"  placeholder="Enter Name" name="name">
                <span class="text-danger" id="nameError" style="display:none;"></span>
            </div>
            <div class="col-sm-12 col-md-6">
                <label for="email" class="mb-2 mr-sm-2">Email</label>
                <input type="email" class="form-control mb-2 mr-sm-2" id="email" placeholder="Enter Email" name="email">
                <span class="text-danger" id="emailError" style="display:none;"></span>
            </div>
        </div>
        <div class="form-group mt-4">
        <label for="message">Message</label>
        
        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Enter Message"></textarea>
        <span class="text-danger" id="msgError" style="display:none;"></span>
        <button type="submit" name="sendMail" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5">Send Message</button>
        </div>
    </form>
    @endguest
    @auth

    <form class="font-weight-bold mt-4 mb-0 contact-form" autocomplete="OFF" id="formFields" action="">
        <div class="form-group row">
            <div class="col-sm-12 col-md-6">
                <label for="email" class="mb-2 mr-sm-2">Contact Email</label>
                <input type="email" class="form-control mb-2 mr-sm-2" id="email" placeholder="Enter Email" name="email">
                <span class="text-danger" id="emailError" style="display:none;"></span>
            </div>
        </div>
        <div class="form-group mt-4">
        <label for="message">Edit Display Message</label>
        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Cannot Be Blank">You can use this form to contact me.</textarea>
        <span class="text-danger" id="msgError" style="display:none;"></span>
        <button type="submit" name="editContactDetails" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5">Save</button>
        </div>
    </form>

    @endauth

</div>
<!-- End of contact page -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let j = jQuery.noConflict();
    var contactForm = document.querySelector('.contact-form');
    contactForm.onsubmit = document.querySelector('button[name="sendMail"]').addEventListener('click', function(event){
    event.preventDefault();
    const ContactFormData = new FormData(document.querySelector('#formFields'));
    

      j.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            }
        });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "send-mail",
            data:ContactFormData,
            contentType: false,
            processData: false,
            success : function (res) {
              console.log(JSON.stringify(res));

              if(res.success)
              {
                document.querySelector('#formFields').reset();
                swal({
                  text: res.success,
                  icon: "success",
                });
              }


              if(res.name)
              {
                const nameErrorContainer=document.querySelector('#nameError');
                nameErrorContainer.style.display='block';
                nameErrorContainer.innerHTML = res.name;
              }
              else
              {
                const nameErrorContainer=document.querySelector('#nameError');
                nameErrorContainer.style.display='none';
                nameErrorContainer.innerHTML = '';
              }


              if(res.email)
              {
                const emailErrorContainer=document.querySelector('#emailError');
                emailErrorContainer.style.display='block';
                emailErrorContainer.innerHTML = res.email;
              }
              else
              {
                const emailErrorContainer=document.querySelector('#emailError');
                emailErrorContainer.style.display='none';
                emailErrorContainer.innerHTML = '';
              }


              if(res.message)
              {
                const msgErrorContainer=document.querySelector('#msgError');
                msgErrorContainer.style.display='block';
                msgErrorContainer.innerHTML = res.message;
              }
              else
              {
                const msgErrorContainer=document.querySelector('#msgError');
                msgErrorContainer.style.display='none';
                msgErrorContainer.innerHTML = "";
              }
            }
        });
    

  });
</script>
@endsection