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
        <script type="text/javascript">
            let table=document.getElementById("table_body");
            let container=document.getElementById("div_select");

            function createSelect(value) {
              if(value=="extern") {
                table.textContent='';
                container.textContent='';
                let selectElement=document.createElement('select');
                let disOption=document.createElement('option');
                let testOption=document.createElement('option');
                disOption.innerText="Seleziona Azienda";
                disOption.setAttribute('disabled',true);
                disOption.setAttribute('selected',true);
                disOption.value='';
                selectElement.appendChild(disOption);
                loadCompanies(selectElement);
                selectElement.addEventListener("change", () => createTable(selectElement.value));
                container.appendChild(selectElement);
              }
              else if(value=="na") {
               table.textContent='';
               container.textContent='';
               createTable("na");
              }
              else {
               table.textContent='';
               container.textContent='';
               createTable("inner");
              }
            }

            function createTable(value) {
                table.textContent='';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:"./createTable/"+value,
                    type:"POST",
                    success: function(result) {

                        const list=JSON.parse(result);

                        if(value=="na") {
                         for(var index in list) {
                            table.innerHTML+=`
                            <tr>
			       <td>${list[index].codifica}</td>
                               <td>${list[index].serial}</td>
                               <td>${list[index].tipo}</td>
                               <td>${list[index].nome_azienda}</td>
                               <td>
                                <form method='post' onclick=assign(${list[index].id})>
                                   @csrf

                                   <button type='submit' class='btn btn-success'>Assegna</button>
                                </form>
                               </td>
                            </tr>`;
                          }
                        }
                        else {
                         for(var index in list) {
                            table.innerHTML+=`
                            <tr>
                               <td>${list[index].codifica}</td>
                               <td>${list[index].serial}</td>
                               <td>${list[index].tipo}</td>
                               <td>${list[index].nome_azienda}</td>
                               <td>
                                <form method='post' action=./del_asset/${list[index].id}>
                                  @csrf
                                  <button type='submit' class='btn btn-danger'>Elimina</button>
                                </form>
                               </td>
                            </tr>`;
                        }
                      }
                    },
                    error: function(error) {
                        console.error(error);
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
                            companySelect.options.add(new Option(company_options[index].nome_azienda,company_options[index].id));
                        }
                    },
                    error: function(error) {
                        console.error(error)
                    }
                });
            }
            function assign(id) {
              const win = window.open("./ass_form/"+id,"_blank","width=500px,height=500px");
              createTable("na");

              const control = setInterval(() => {
                 if(win.closed) {
                    clearInterval(control);
                    createTable("na");
                 }
              },500);
            }
        </script>
    </body>
</html>
