<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
    <title>Gestione utenti</title>
</head>
<body>
    @if(Session::has("fail"))
        <div class="alert alert-danger" role="alert">{{Session::get("fail")}}</div>
    @else
        <div class="alert alert-danger" role="alert">{{Session::get("scss")}}</div>
    @endif

    <div class="login-container">
        <h1>Scegli un'opzione</h1>
        <a href="./ch_pwd_form"><button>Cambia Password</button></a><br><br>
        <a href="./ins_new_usr"><button>Inserisci Nuovo Utente</button></a><br><br>
        <a href="./asset_manager"><button>Indietro</button></a><br><br>
    </div>
</body>
</html>
