@extends('layouts.lucid')
@section('sidebar')
@parent
@endsection
@section('content')
<!-- Beginning of contact page -->

<!-- Beginning of Post Content -->

<div class="container">
<h4 class="font-weight-bold mb-4">Contact Me</h4>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat accumsan sodales. In ac euismod augue. Quisque vel porta metus, sit amet aliquam eros.
    </p>
    <form class="font-weight-bold mt-4 mb-0" action="">
        <div class="form-group row">
            <div class="col-sm-12 col-md-6">
                <label for="" class="mb-2 mr-sm-2">Name</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="" placeholder="Enter email" name="email">
            </div>
            <div class="col-sm-12 col-md-6">
                <label for="" class="mb-2 mr-sm-2">Email</label>
                <input type="text" class="form-control mb-2 mr-sm-2" id="" placeholder="Enter password" name="pswd">
            </div>
        </div>
        <div class="form-group mt-4">
        <label for="">Message</label>
        <textarea name="" id="" rows="5" class="form-control"></textarea>
        <button type="submit" class="btn bg-alt text-white col-sm-12 col-md-3 mt-5">Send Message</button>
        </div>
    </form>
</div>
<!-- End of contact page -->
@endsection