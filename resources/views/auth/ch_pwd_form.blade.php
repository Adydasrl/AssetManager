<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
    <title>Cambia Password</title>
</head>
<body>
    <div class="login-container">
        <form action="ch_pwd/{{Auth::id()}}" method="post"> <!--{{Auth::guard('web')->user()->id}}-->
            <label for="old_pw">Vecchia Password</label><br>
            <input id="old_pw" name="old_pw" type="password" autocomplete="current-password"><br>
            <label for="new_pw">Nuova Password</label>
            <input id="new_pw" name="new_pw" type="password" autocomplete="new-password"><br>
            <label for="cnf_pw">Conferma Password</label><br>
            <input id="cnf_pw" name="cnf_pw" type="password" autocomplete="new-password"><br>
            <button>Cambia password</button>
        </form><br>
        <a href="./mng_user"><button>Indietro</button></a>
    </div>
</body>
</html>