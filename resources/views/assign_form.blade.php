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
         <form id="form" method='POST' action="../ass_asset/{{$id}}">
            @csrf
            <label>A quale tipo di cliente vuoi assegnarlo?</label>
            <select id="sel_dest" name="sel_dest" onchange="selOpt(this.value);" required>
               <option disabled selected value="">Seleziona il tipo di cliente</option>
               <option value="inner">Interno</option>
               <option value="client">Cliente</option>
            </select>
            <div id="form_div">
            </div>
            <button type="submit">Assegna</button>
         </form>
      </div>
      <script src="../../js/assign_form.js"  type="text/javascript">
      </script>
    </body>
</html>
