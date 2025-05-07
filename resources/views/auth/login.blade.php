<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
        <title>Login</title>
    </head>
    <body>
        @if(Session::has("fail"))
            <div class="alert alert-danger" role="alert">{{Session::get("fail")}}</div>
        @endif
        <div class="login-container">
            <h1>Asset Manager</h1>
            <div id="info_ver">
                <h6>Ver. 1.0.0 © 2025 Adyda s.r.l.</h6>
            </div>
            <form method="post" action="index.php/login">
                @csrf
                <label for="username">Username:</label><br> <!--red-->
                <input id="username" name="username" type="text" placeholder="Username" autocomplete="username" required/><br><br>
                <label for="password">Password:</label><br> <!--red-->
                <input id="password" name="password" type="password" placeholder="Password" autocomplete="current-password" required/><br><br>
                <button type="submit">Login</button>
            </form>
        </div>
        <script>
        </script>
    </body>
</html>
