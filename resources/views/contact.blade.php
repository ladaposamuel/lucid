@extends('layouts.lucid')
@section('sidebar')
@parent
@endsection
@section('content')
 <!-- Beginning of contact page -->
 
<body>
    <style>
        .form-inline label {
            justify-content: left;
        }
        .profile-submit-btn {
        background-color: #871E99;
        padding: 1rem 2rem;
        margin-top: 1rem;
        color: #fff;
        }
    </style>
    
            <!-- Beginning of Post Content -->
            <div class="col-lg-8 pb-5">
                <div class="post-content">
                    

                    <div class="container">
                        <h2>Contact Me</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed volutpat accumsan sodales. In
                            ac euismod augue. Quisque vel porta metus, sit amet aliquam eros.
                        </p>
                        <form class="form-inlin" action="/action_page.php">
                            <div class="form-inline">
                                <div class="">
                                    <label for="" class="mb-2 mr-sm-2">Name</label>
                                    <input type="text" class="form-control mb-2 mr-sm-2" id="" placeholder="Enter email"
                                        name="email">
                                </div>
                                <div class="">
                                    <label for="" class="mb-2 mr-sm-2">Email</label>
                                    <input type="text" class="form-control mb-2 mr-sm-2" id=""
                                        placeholder="Enter password" name="pswd">
                                </div>
                            </div>
                            <label for="">Message</label>
                            <textarea name="" id="" cols="30" rows="10" class=" form-text form-control"></textarea>
                            <button type="submit" class=" profile-submit-btn mb-2">Send Message</button>
                        </form>
                    </div>
                </div>

 <!-- End of contact page -->
@endsection