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
      <script>

       let dest=document.getElementById("sel_dest");
       let div=document.getElementById("form_div");

       function selOpt(value) {
        if(value=="inner") {
             div.innerHTML='';
             let lab=document.createElement("label");
             let sel=document.createElement("select");
             let def_opt=document.createElement("option");

             lab.innerText="Nome Destinatario";
             def_opt.innerText="Seleziona Destinatario";

             sel.name="dest_name";

             def_opt.value="";

             sel.setAttribute("required",true);
             def_opt.setAttribute("disabled",true);
             def_opt.setAttribute("selected",true);

             sel.appendChild(def_opt);

             div.appendChild(document.createElement("br"));
             div.appendChild(lab);
             div.appendChild(document.createElement("br"));
             div.appendChild(sel);

             loadNames(sel);
        }
        else {
          div.innerHTML='';
          let lab=document.createElement("label");
          let sel=document.createElement("select");
          let def_opt=document.createElement("option");

          lab.innerText="Nome Azienda";
          def_opt.innerText="Seleziona Azienda";

          sel.name="comp_id";

          def_opt.value="";

          sel.setAttribute("required",true);
          def_opt.setAttribute("disabled",true);
          def_opt.setAttribute("selected",true);

          sel.appendChild(def_opt);


          div.appendChild(document.createElement("br"));
          div.appendChild(lab);
          div.appendChild(document.createElement("br"));
          div.appendChild(sel);

          loadCompanies(sel);
        }
       }

       function loadCompanies(companySelect) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "../loadCompany",
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

            function loadNames(nameSelect) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "../loadName",
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
            };

            document.getElementById("form").addEventListener('submit', function(e) {
              e.preventDefault();

              const formData = new FormData(this);

              fetch(this.action, {
                method: 'POST',
                headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                body: formData
              }).then(response => response.json())
                .then(data => {
                   if(data.success) {
                       self.close();
                   }
                 })
                .catch(error => {
                   console.error('Errore nella richiesta', error);
                });
            });
      </script>
    </body>
</html>
