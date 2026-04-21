
       let dest=document.getElementById("sel_dest"); let div=document.getElementById("form_div");

       function selOpt(value) { if(value=="inner") { div.innerHTML=''; let lab=document.createElement("label"); let sel=document.createElement("select"); let def_opt=document.createElement("option");

             lab.innerText="Nome Destinatario"; def_opt.innerText="Seleziona Destinatario";

             sel.name="dest_name";

             def_opt.value="";

             sel.setAttribute("required",true); def_opt.setAttribute("disabled",true); def_opt.setAttribute("selected",true);

             sel.appendChild(def_opt);

             div.appendChild(document.createElement("br")); div.appendChild(lab); div.appendChild(document.createElement("br")); div.appendChild(sel);

             loadNames(sel);
        }
        else { div.innerHTML=''; let lab=document.createElement("label"); let sel=document.createElement("select"); let def_opt=document.createElement("option");

          lab.innerText="Nome Azienda"; def_opt.innerText="Seleziona Azienda";

          sel.name="comp_id";

          def_opt.value="";

          sel.setAttribute("required",true); def_opt.setAttribute("disabled",true); def_opt.setAttribute("selected",true);

          sel.appendChild(def_opt);


          div.appendChild(document.createElement("br")); div.appendChild(lab); div.appendChild(document.createElement("br")); div.appendChild(sel);

          loadCompanies(sel);
        }
       }

       function loadCompanies(companySelect) { $.ajaxSetup({ headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({ url: "../loadCompany", type: "POST", success: function(result) {


                        const company_options = JSON.parse(result);


                        for(var index in company_options) { companySelect.options.add(new Option(company_options[index].nome_azienda,company_options[index].id));
                        }
                    },
                    error: function(error) { console.error(error)
                    }
                });
            }

            function loadNames(nameSelect) { $.ajaxSetup({ headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({ url: "../loadName", type: "POST", success: function(result) {


                        const name_options = JSON.parse(result);


                        for(var index in name_options) { nameSelect.options.add(new Option(name_options[index].owner_name));
                        }
                    },
                    error: function(error) { console.error(error);
                    }
                });
            };

            document.getElementById("form").addEventListener('submit', function(e) { e.preventDefault();

              const formData = new FormData(this);

              fetch(this.action, { method: 'POST', headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                body: formData
              }).then(response => response.json())
                .then(data => { if(data.success) { self.close();
                   }
                 })
                .catch(error => { console.error('Errore nella richiesta', error);
                });
            });



