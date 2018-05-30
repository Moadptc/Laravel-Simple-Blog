<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,
          user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>

<div class="text-center">
    <h3>Hello {{ $user->name }}</h3>
    <p>To Verify your email please click the link bellow</p>
    <hr>

    <a class="btn btn-lg btn-primary"
       href="{{ url('user/verify', $user->verifyUser->token) }}">
        Verify Your Email
    </a>

</div>


</body>
</html>