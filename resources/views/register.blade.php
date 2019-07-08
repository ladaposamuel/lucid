<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link href="https://unpkg.com/ionicons@4.5.9-1/dist/css/ionicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet" />
    <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/main-style.css') }}" />
    <title>Register</title>
</head>

<body>
    <div class="container text-center mt-5 justify-content-center">
        <div class="my-5">
            <a href="/" class="navbar-brand"><img alt="Lucid" src="{{ asset('img/logo.png') }}" class="img-fluid" /></a>
        </div>
        <div class="my-3">
            <h4>A Better Way to Share Your Ideas</h4>
            <p class="text-muted my-4">Already signed up? <a href="/login" class="text-secondary font-weight-bold">Log in</a></p>
        </div>
        <div class="d-inline-block w-custom">
            <button class="btn border-main text-main my-3 w-100"><i class="icon ion-logo-google p-1"></i> <a href="{{ url('/login/google') }}">Continue with Google</a></button>
            <p>You can also <a href="" class="text-main">continue with mail</a></p>
        </div>
        <div class="row w-100"></div>
        <div class="d-inline-block w-custom mt-4">
            <small class="text-muted">By clicking “Continue with Google/Email” above, you acknowledge that you have read and understood, and agree to Lucid’s <a href="" class="text-main">Terms and Conditons</a> and <a href="" class="text-main">Privacy Policy</a>.</small>
        </div>
    </div>
</body>

</html>