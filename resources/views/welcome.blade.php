<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
        <title>Asset Manager</title>
    </head>
    <body>
        <div class="login-container">
            <h1>Cosa vuoi fare?</h1>
            <a href="./asset_form"><button>Inserisci nuovo asset</button></a><br><br>
            <a href="./asset_list"><button>Elenco asset</button></a><br><br>
            <a href="./mng_user"><button value="ciao">Gestione utente</button></a><br><br>
            <a href="./logout"><button>Logout</button></a>
        </div>
    </body>
</html>