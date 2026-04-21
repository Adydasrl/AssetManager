<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="preload" href="{{ asset('css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('css/app.css') }}"></noscript>
        <title>Inserisci asset</title>
    </head>
    <body onload="loadDevice()">
        @if(Session::has('scss'))
            <div class="alert alert-success" role="alert">{{Session::get("scss")}}</div>
        @endif
        <div class="login-container">
            <form method="POST" action="./validate">
                @csrf
                <div id="form_container">
                    <label for="device_type">Tipo dispositivo</label><br><br>
                    <select id="device_type" name="device_type" required onchange="new_device(value)">
                        <option value="" selected disabled>Seleziona il tipo di dispositivo</option>
                        <option value="add_device">Altro</option>
                    </select><br><br>
                    <div id="device_container">
                    </div>
                    <label for="serial_num">Serial #</label><br><br>
                    <input id="serial_num"  name="serial_num" type="text" required><br><br>
                    <label for="receiver_type">Destinatario</label><br><br>
                    <select id="receiver_type" name="receiver_type" required onchange="manage_dest(value)">
                        <option value="" selected disabled>Cliente o Interno</option>
                        <option value="client">Cliente</option>
                        <option value="inner">Interno</option>
                    </select><br><br>
                    <div id="dest_type"></div>
                    <div id="add_option"></div>
                </div>
                <button type="submit">Inserisci Asset</button>
            </form><br>
            <a href="./asset_manager"><button>Indietro</button></a><br>
        </div>
        <script src="../js/asset_form.js"  type="text/javascript">
        </script>
    </body>
</html>
