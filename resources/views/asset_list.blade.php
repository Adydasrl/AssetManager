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
        <title>Lista asset</title>
    </head>
    <body>
        <div class="login-container">
            <select name="typeSelect" id="typeSelect" onchange="createSelect(value)"> <!--createTable(value)-->
                <option value="" selected disabled>Seleziona il tipo di asset che vuoi vedere</option>
                <option value="inner">Interni</option>
                <option value="extern">Esterni</option>
                <option value="na">Non Assegnati</option>
            </select>
            <div id="div_select"></div>
            <table id="assetList">
                <thead>
                    <tr>
                        <th>Codifica</th>
                        <th>Seriale</th>
                        <th>Dispositivo</th>
                        <th>Destinatario</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody id="table_body"></tbody>
            </table><br>
            <a href="./asset_manager"><button>Indietro</button></a><br>
        </div>
        <script src="../js/asset_list.js" type="text/javascript">
        </script>
    </body>
</html>
