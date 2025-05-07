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
        <script type="text/javascript">
            let container_dest=document.getElementById("dest_type");
            let container_device=document.getElementById("device_container");
            let container_client=document.getElementById("add_option");

            function manage_dest(value) {

                container_dest.textContent='';

                if(value==="client") {

                    container_client.innerText='';

                    let company_label=document.createElement('label');
                    let company_select=document.createElement('select');

                    company_label.htmlFor="company_name";
                    company_label.innerText="Nome Azienda";


                    company_select.id="company_name";
                    company_select.name="company_name";
                    company_select.setAttribute('required',true);

                    let first_option=document.createElement('option');
                    first_option.innerText="Seleziona Cliente";
                    first_option.setAttribute('disabled',true);
                    first_option.setAttribute('selected',true);
                    first_option.value="";

                    let last_option=document.createElement('option');
                    last_option.innerText="Altro";
                    last_option.value="add_company";

                    company_select.appendChild(first_option);
                    loadCompanies(company_select);
                    company_select.appendChild(last_option);

                    company_select.addEventListener("change", () => new_company(company_select.value));

                    container_dest.appendChild(company_label);
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(company_select);
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(document.createElement('br'));
                }
                else {

                    container_client.innerText='';

                    let name_label=document.createElement('label');
                    let name_select=document.createElement('select');

                    name_label.htmlFor="dest_name";
                    name_label.innerText="Nome Destinatario";

                    name_select.id="dest_name";
                    name_select.name="dest_name";
                    name_select.setAttribute('required',true);

                    let first_option=document.createElement('option');
                    first_option.innerText="Seleziona Nome Destinatario";
                    first_option.setAttribute('disabled',true);
                    first_option.setAttribute('selected',true);
                    first_option.value="";

                    let last_option=document.createElement('option');
                    last_option.innerText="Altro";
                    last_option.value="add_name";

                    name_select.appendChild(first_option);
                    loadNames(name_select);
                    name_select.appendChild(last_option);

                    name_select.addEventListener("change", () => new_name(name_select.value));

                    container_dest.appendChild(name_label);
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(name_select);
                    container_dest.appendChild(document.createElement('br'));
                    container_dest.appendChild(document.createElement('br'));
                }
            }

            function new_company(value) {

                let new_company_label=document.createElement("label");
                let new_company_input=document.createElement("input");

                if(value==="add_company") {

                    container_client.innerText='';

                    new_company_label.textContent="Inserisci Nome Azienda";
                    new_company_label.htmlFor="new_company_name";
                    new_company_input.id="new_company_name";
                    new_company_input.name="new_company_name";
                    new_company_input.setAttribute("required",true);

                    container_client.appendChild(new_company_label);
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(new_company_input);
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(document.createElement('br'));
                }
                else {
                    container_client.innerText='';
                }
            }

            function new_name(value)  {

                if(value==="add_name") {
                    container_client.innerText='';
                    let new_name_label=document.createElement("label");
                    let new_name_input=document.createElement("input");

                    new_name_label.textContent="Inserisci Nome Destinatario";
                    new_name_label.htmlFor="new_dest_name";
                    new_name_input.id="new_dest_name";
                    new_name_input.name="new_dest_name";
                    new_name_input.setAttribute("required",true);

                    container_client.appendChild(new_name_label);
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(new_name_input);
                    container_client.appendChild(document.createElement('br'));
                    container_client.appendChild(document.createElement('br'));
                }
                else {
                    container_client.innerText='';
                }
            }

            function new_device(value) {

                container_device.textContent='';

                if(value==="add_device") {
                    let new_device_label=document.createElement("label");
                    let new_device_input=document.createElement("input");
                    let abbreviation_label=document.createElement("label");
                    let abbreviation_input=document.createElement("input");

                    new_device_label.textContent="Inserisci Dispositivo";
                    new_device_label.htmlFor="new_device_name";
                    abbreviation_label.textContent="Sigla";
                    abbreviation_label.htmlFor="dev_abb";
                    new_device_input.id="new_device_name";
                    new_device_input.name="new_device_name";
                    new_device_input.setAttribute("required",true);
                    abbreviation_input.id="dev_abb";
                    abbreviation_input.name="dev_abb";
                    abbreviation_input.setAttribute("required",true);

                    container_device.appendChild(new_device_label);
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(new_device_input);
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(abbreviation_label);
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(abbreviation_input);
                    container_device.appendChild(document.createElement('br'));
                    container_device.appendChild(document.createElement('br'));
                }
            }

            function loadDevice() {

                let selectDevice=document.getElementById("device_type");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "./loadDevice",
                    type: "POST",
                    success: function(result) {
                        const device_options = JSON.parse(result);

                        for(var index in device_options) {
                            selectDevice.options.add(new Option(device_options[index].dispositivo,device_options[index].abbreviazione));
                        }
                    },
                    error: function(error) {
                        console.error(error)
                    }
                });
            }

            function loadCompanies(companySelect) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "./loadCompany",
                    type: "POST",
                    success: function(result) {

                        const company_options = JSON.parse(result);

                        for(var index in company_options) {
                            companySelect.options.add(new Option(company_options[index].nome_azienda,company_options[index].nome_azienda));
                        }
                    },
                    error: function(error) {
                        console.error(error)
                    }
                });
            }

            function loadNames(nameSelect) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "./loadName",
                    type: "POST",
                    success: function(result) {

                        const name_options = JSON.parse(result);

                        for(var index in name_options) {
                            nameSelect.options.add(new Option(name_options[index].owner_name));
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                const alert = document.querySelector('.alert-success');
                if (alert) {
                    setTimeout(() => {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }, 3000);
                }
            });
        </script>
    </body>
</html>
