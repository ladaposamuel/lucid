<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/main-style.css') }}" />
  <link rel="short icon" type="image/png" sizes="16x16" href="{{ asset('img/luci-logo.png') }}">
  <title>Are you lost?</title>
  <style>
    body{
      text-align: center;
    }
    .container {
      margin-top: 6vh
    }
    img{
      width: 300px;
      margin-top: 0.7rem;
    }
    a{
      color: #ffffff;
      background: var(--secondary-color);
      padding: 1rem 0.7rem;
      display: inline-block;
      text-decoration: none;
    }
    @media screen and (max-width: 425px){
      img{
        width: 250px;
      }
    }
  </style>
</head>
<body>
    <main class="container">
      <h2>Something's not right</h2>
      <img src="{{ asset('img/404-space-ship.svg') }}" alt="space ship image">
      <p>It seems the aliens have taken this page..</p>
      <a href="javascript: history.go(-1)">Click this button to return home</a>
    </main>
</body>
</html>