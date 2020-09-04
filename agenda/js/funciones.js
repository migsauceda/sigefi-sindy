 function carga_ajax(id,div,url,fiscal)
        {
           $.post
            (
                url,
                {id:id,
                fiscal:fiscal},
                function(resp)
               {
                    $("#"+div+"").html(resp);
               }
            );
        }


function validar_hora(horainicio,horafin,fechaseleccionada,div,url)
       {
          $.post
           (
               url,
               {
                 horainicio:horainicio,
                 horafin:horafin,
                 fechaseleccionada:fechaseleccionada
               },
               function(resp)
              {
                   $("#"+div+"").html(resp);
              }
           );
       }
