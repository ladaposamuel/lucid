@extends('layouts.lucid')
@section('title')
  Contact - {{ $user->name }} - Lucid
@endsection
@php
$location= 'contact';
@endphp
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

.standard-color{
  background: #871e99;
  color:#fff;
  border:1px solid #871e99;
}

.standard-color:hover{
  background: #871e99 !important;
  color:#fff;
  border:1px solid #871e99 !important;
}

.text-danger{
  font-weight:400px !important;
  font-size:12px !important;

}
</style>

<div class="container">
    @if(Auth::user() && Auth::user()->username == $user->username)

    <form class="font-weight-bold mb-0 editContactForm" autocomplete="OFF" id="formFields" action="">
        <div class="form-group row">
            <div class="col-sm-12 col-md-10">
                <label for="email" class="mb-2 mr-sm-2">Contact Email</label>
                <input type="email" class="form-control mb-2 mr-sm-2" id="email" placeholder="Enter Email" name="email"
                value="@if($contact) {{ $contact->email   }} @else {{ Auth::user()->email }} @endif ">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <span class="text-danger" id="emailError" style="display:none;"></span>
            </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col-sm-12 col-md-10">
          <label for="message">Display Text</label>
        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Enter Display Text">@if($contact){{ $contact->display_message }}@endif</textarea>
        <span class="text-danger" id="msgError" style="display:none;"></span>
        <button type="submit" name="editContactDetails" id="saveBtn" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5">Save</button>
          </div>
        </div>
    </form>

    @else
    <h4 class="font-weight-bold mb-4">Contact Me</h4>
    <p>
        @if($contact) {{ $contact->display_message  }} @endif
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
        <button type="submit" name="sendMail" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5" id="sendEmailBtn">Send Message</button>
        </div>
    </form>
    @endif


</div>
<!-- End of contact page -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@guest
<script src="{{ asset('js/contact.js') }}"></script>
@endguest
<script src="{{ asset('js/edit-contact-details.js') }}"></script>
@endsection
