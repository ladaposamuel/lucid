@extends('layouts.landing')
@section('content')
<style>
.standard-color{
background: #9179ef;
color:#fff;
border:1px solid #9179ef;
}

.standard-color:hover{
  background: #9179ef !important;
  color:#fff;
  border:1px solid #9179ef !important;
}

</style>
<section class="hero-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1>
					Revolutionizing Content Sharing With Absolute Ownership and Data
					Privacy
				</h1>
				@guest
				<a class="btn btn-primary" href="/register">Create Your Page For Free
					<i class="pl-2 icon ion-ios-arrow-round-forward"></i></a>
				@else
				<a class="btn btn-primary" href="{{ Auth::user()->username}}">Visit your blog
					<i class="pl-2 icon ion-ios-arrow-round-forward"></i></a>
				@endguest
			</div>
		</div>
	</div>
</section>

<section class="preview-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<img src="{{ asset('img/lucid-preview.jpg') }}" class="img-fluid lucid-laptop" alt="Lucid" />
			</div>
		</div>
	</div>
</section>

<section class="feature-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12 text-center text-white pb-4">
				<p class="mb-0">Features of Lucid</p>
				<h2>A Better Way to Share Your Ideas</h2>
			</div>
		</div>
		<div class="row text-white">
			<div class="col-md-6 my-3">
				<div class="feat-col">
					<img src="{{ asset('img/14019879701543984325.png') }}" alt="Tell Your Story on Lucid" class="img-fluid pb-4" />
					<h5>Tell Your Story on Lucid</h5>
					<p>
						Own a platform on Lucid. Your thoughts and ideas are very
						precious. Decide how you want your voice to be heard.
					</p>
				</div>
			</div>
			<div class="col-md-6 my-3">
				<div class="feat-col">
					<img src="{{ asset('img/17101174831552994197.png ') }}" alt="You Are in Safe Hands" class="img-fluid pb-4" />
					<h5>You Are in Safe Hands</h5>
					<p>
						Whatever content you want on your website are made to last
						forever. All your info lives inside an incorruptible file on
						your domain.
					</p>
				</div>
			</div>
			<div class="col-md-6 my-3">
				<div class="feat-col">
					<img src="{{ asset('img/16143869721535958154.png') }}" alt="Your Right to Privacy" class="img-fluid pb-4" />
					<h5>Your Right to Privacy</h5>
					<p>
						Our goal is to help you believe that “privacy” is one of life’s
						basic need which you are entitled to. Decide what contents you
						want them to know on your platform.
					</p>
				</div>
			</div>
			<div class="col-md-6 my-3">
				<div class="feat-col">
					<img src="{{ asset('img/4804552381535029667.png') }}" alt="In One Simple Set up" class="img-fluid pb-4" />
					<h5>In One Simple Set up</h5>
					<p>
						Create your domain in one setup with no intrusions, pop ups
						banners, sponsored posts, sponsored ads, link baits…. But just
						original ideas from you.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="testimonies-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center pb-4">
				<p class="mb-0">Testimonies</p>
				<h2>Check what People say about us</h2>
			</div>
			<div class="col-lg-12">
				<div class="bd-example">
					<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active text-center">
								<img src="{{ asset('img/geek.jpg ') }}" alt="" srcset="" />
								<h5 class="testimonal-text">
									“Lucid has done a very good job in building my website
									with those awesome themes. The customer support guys were
									really helpful. My website has ranked high ever since on
									Google.”
								</h5>
								<p class="username">Watson Torquil</p>
							</div>
							<div class="carousel-item text-center">
								<img src="{{ asset('img/images.jpg') }}" alt="" srcset="" />
								<h5 class="testimonal-text">
									“I'm happy with how fast it was for me to set up my page on lucid,it took me just a sign up using my google account to do that and now i can share my stories with the world and still retained my rights to privacy.”
								</h5>
								<p class="username">Frederick Conrad</p>
							</div>
							<div class="carousel-item text-center">
								<img src="{{ asset('img/geek1.jpg') }}" alt="" srcset="" />
								<h5 class="testimonal-text">
									“Sharing my stories with the world has never been this easy,lucid made it possible for me to share my thoughts and  ideas,allowing me to make my own decisions and not putting my contents behind paywall ”
								</h5>
								<p class="username">Natasha Quinn</p>
							</div>
						</div>
						<ol class="carousel-indicators">
							<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
							<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
							<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
						</ol>
						<a class="carousel-control-prev d-none d-lg-flex d-xl-flex" href="#carouselExampleCaptions" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next d-none d-lg-flex d-xl-flex" href="#carouselExampleCaptions" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="newsletter-section">
	<div class="container">
		<div class="row text-white justify-content-center">
			<div class="col-lg-12 text-center">
				<p class="mb-0">Newsletter Subscription</p>
				<h2>Making Your Experience A Unique One</h2>
			</div>
			<div class="col-lg-7 pt-3 text-center">
				<p>
					Subscribe to our newsletters today to receive important updates on
					our latest services, and useful tips on how your website can grow
					into a big one.
				</p>
			</div>
			<div class="col-lg-6">
				<form action="" class="subscribe" method="post" id="formField">
					<div class="input-group mb-3">
						<input type="email" class="form-control newsletter-input" name="email" placeholder="Email Address"
							required />
						<div class="input-group-append">
							<button class="btn btn-primary newsletter-btn" type="submit" name="subscribe">
								SUBSCRIBE
							</button>
						</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</section>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
 let j = jQuery.noConflict();
    var subscribe = document.querySelector('.subscribe');
    subscribe.onsubmit = document.querySelector('button[name="subscribe"]').addEventListener('click', function(event){
    event.preventDefault();
    const subscribeFormData = new FormData(document.querySelector('#formField'));
    

      j.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': j('meta[name="csrf-token"]').attr('content')
            }
        });

      j.ajax({
            type: "POST",
            dataType:'json',
            url : "save-subscription",
            data:subscribeFormData,
            contentType: false,
            processData: false,
            success : function (res) {

              if(res.success)
              {
                document.querySelector('#formField').reset();
                swal({
                  text: res.success,
                  icon: "success",
                  button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "standard-color",
                  closeModal: true,
                  },
                });
			  }
			  
			  if(res.email)
              {
                swal({
                  text: res.email[0],
                  icon: "error",
                  button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "standard-color",
                  closeModal: true,
                  },
                });
              }

            }
        });
  });
</script>
@endsection