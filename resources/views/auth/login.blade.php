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
    <title>Login</title>
</head>

<body>
    <div class="container text-center mt-5 justify-content-center">
        <div class="my-5">
            <a href="/" class="navbar-brand"><img alt="Lucid" src="{{ asset('img/logo.png') }}" class="img-fluid" /></a>
        </div>
        <div class="my-3">
            <h4>Welcome back!</h4>
            <p class="text-muted my-4">New to Lucid? <a href="/register" class="text-secondary font-weight-bold">Sign Up</a></p>
        </div>
        <div class="d-inline-block w-custom">
            <button class="btn border-main text-main my-3 w-100"><i class="icon ion-logo-google p-1"></i> <a href="{{ url('/login/google') }}">Continue with Google</a></button>
            <form>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your email address">
                </div>
                <button type="submit" class="btn bg-alt text-white w-100">Continue with Email</button>
            </form>
            <div class="text-right mt-2">
                <a href="" class="text-left text-secondary">Forgot Password?</a>
            </div>
        </div>

    </div>
</body>

</html>