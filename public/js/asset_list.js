            let table=document.getElementById("table_body"); let container=document.getElementById("div_select"); const csrfToken=document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function createSelect(value) { if(value=="extern") { table.textContent=''; container.textContent=''; let selectElement=document.createElement('select'); let disOption=document.createElement('option'); let 
                testOption=document.createElement('option'); disOption.innerText="Seleziona Azienda"; disOption.setAttribute('disabled',true); disOption.setAttribute('selected',true); disOption.value=''; selectElement.appendChild(disOption); 
                loadCompanies(selectElement); selectElement.addEventListener("change", () => createTable(selectElement.value)); container.appendChild(selectElement);
              }
              else if(value=="na") { table.textContent=''; container.textContent=''; createTable("na");
              }
              else { table.textContent=''; container.textContent=''; createTable("inner");
              }
            }

            function createTable(value) { 
                table.textContent=''; 
                $.ajaxSetup({ 
                      headers: { 
                           'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                      }
                });

                $.ajax({ url:"./createTable/"+value, type:"POST", success: function(result) {

                        const list=JSON.parse(result);

                        if(value=="na") { for(var index in list) { table.innerHTML+=` <tr> <td>${list[index].codifica}</td> <td>${list[index].serial}</td> <td>${list[index].tipo}</td> <td>${list[index].nome_azienda}</td> <td> 
                               <form method='post' onclick=assign(${list[index].id})>
                                   <input type="hidden" name="_token" value="${csrfToken}">
                                   <button type='submit' class='btn btn-success'>Assegna</button> </form> </td> </tr>`;
                          }
                        }
                        else if(value=="inner") {for(var index in list) { table.innerHTML+=` <tr> <td>${list[index].codifica}</td> <td>${list[index].serial}</td> <td>${list[index].tipo}</td> <td>${list[index].nome_azienda}</td> <td>
                               <form method='post' onclick=assign(${list[index].id})>
                                   <input type="hidden" name="_token" value="${csrfToken}">
                                   <button type='submit' class='btn btn-success'>Cambia destinatario</button> </form> </td> </tr>`;
                          }
                        }
                        else {
                              for(var index in list) {
                                table.innerHTML+=` <tr> <td>${list[index].codifica}</td> <td>${list[index].serial}</td> <td>${list[index].tipo}</td> <td>${list[index].nome_azienda}</td> <td>
                                <form method='post' action=./del_asset/${list[index].id}>
                                 <input type="hidden" name="_token" value="${csrfToken}">
                                 <button type='submit' class='btn btn-danger'>Elimina</button> </form> </td> </tr>`;
                        }
                      }
                    },
                    error: function(error) { console.error(error);
                    }
                });
            }
            function loadCompanies(companySelect) {

                $.ajaxSetup({ headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({ url: "./loadCompany", type: "POST", success: function(result) {

                        const company_options = JSON.parse(result);

                        for(var index in company_options) { companySelect.options.add(new Option(company_options[index].nome_azienda,company_options[index].id));
                        }
                    },
                    error: function(error) { console.error(error)
                    }
                });
            }
            function assign(id) { const win = window.open("./ass_form/"+id,"_blank","width=500px,height=500px"); createTable("na");

              const control = setInterval(() => { if(win.closed) { clearInterval(control); createTable("na");
                 }
              },500);
            }


