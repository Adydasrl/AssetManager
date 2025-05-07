<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
    <title>New User Form</title>
</head>
<body>
    @if (Session::has('scss'))
        <div class="alert alert-success" role="alert">{{Session::get("scss")}}</div>
    @else
        <div class="alert alert-danger" role="alert">{{Session::get("fail")}}</div>
    @endif
    <div class="login-container">
        <form action="new_usr" method="post">
            @csrf
            <label for="username">Username</label><br>
            <input id="username" name="username" type="text" autocomplete="username"><br>
            <label for="email">Email</label><br>
            <input id="email" name="email" type="email" autocomplete="email"><br>
            <label for="password">Password</label><br>
            <input id="password" name="password" type="password" autocomplete="current-password"><br>
            <button>Inserisci nuovo utente</button>
        </form><br>
        <a href="./mng_user"><button>Indietro</button></a>
    </div>
</body>
</html>