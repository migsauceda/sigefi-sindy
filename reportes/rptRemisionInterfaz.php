<!DOCTYPE html>
<html>
<head>
<meta charset="utf.8">
    <title></title>
</head>
<body>



<?php
 include "../clases/class_conexion_pg.php";
 include "../funciones/php_funciones.php";
$con= new Conexion();
 session_start();
 
?>
<html lang="es">
<head>
<title>Control de Entrega</title>
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    
<link type="text/css" rel="stylesheet" href="../css/Estilos.css">
    <script type="text/javascript" src="../java_script/funciones.js"></script>


    
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

<script type="text/javascript">

  function recibido(id){
  

   $.ajax({
        data:      { Expedienteid:id, opcion:"entrega",},
        type:       "POST",
        url:    "../funciones/ajax_CargarExpediente.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos ");
        },
        success: function(json_obj){ //alert(json_obj);
         alert(json_obj);
          console.log(json_obj);

          

          
        }
    });      
 }
  </script>



<script type="text/javascript">

   function Bandeja(){
  var bandeja =document.getElementById("cmbBandeja").value;

  window.location.href='rptRemisionInterfaz.php?x='+bandeja;
}

   //agrega el combo de subetapa
    $.ajax({
        data:       "opcion=bandeja",
        type:       "POST",
        datatype:   "json",
        url:    "../funciones/ajax_CargarExpediente.php",
        error: function (XMLHttpRequest, textStatus, errorThrown){
            alert("Error al cargar datos para las listas de bandejas");
        },
        success: function(json_obj){ //alert(json_obj);
           var Cursor= JSON.parse(json_obj); 

            //actividad
            comboban= document.createElement("select");
            comboban.name= "cmbBandeja";
            comboban.id= "cmbBandeja";
            comboban.value= "ibandejaid";  
       
        
            for(var i= 0; i < Cursor.length; i++){
                        opt= document.createElement("option");
                        opt.text=  Cursor[i].descripcion;
                        opt.id= "optBandeja"+i;
                        opt.value= Cursor[i].bandejaid;

                        try{
                                comboban.add(opt,null);
                        }
                        catch(e)
                        {
                                comboban.add(opt);
                        }                 
            }
            lstBandeja= document.getElementById("lstBandeja"); 
            lstBandeja.appendChild(comboban);

            var bandeja =document.getElementById("cmbBandeja");
            
            bandeja.addEventListener("change", Bandeja);
        }
    });      



  </script>   
</head>
<body>
    
    <form method="POST" class="form" action="">

      <table align="center" width="95%" border="0" id="tblbandeja" class="TablaCaja">
    <tbody> 
        <tr class="SubTituloCentro">
            <th colspan="2">Control Entrega</th>
             <br><br>
        </tr>
        <tr>
           <td>
                <strong>Bandeja</strong>&nbsp;<span id="lstBandeja"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                 <br><br>
                
                
           </td>


        </tr>  
    </tbody> 
</table>
    
<br><br>

      
          <?php

              
               echo '
                    <table class="table table-hover table-striped table-bordered" id="example" value="consulta" >        
                      <thead>
                        <tr>
                        <th>Denuncia</th>
                        <th>Denunciante</th>
                        <th>Denunciado</th>
                        <th>Delito</th>
                        <th>Recibido</th>
                        <th>accion</th>
                        
                         </tr>
                      </thead>
                      <tbody>';
                      session_start();
                      $variable=$_GET['x'];
                      $bandeja= $_SESSION['bandeja'];

                      if($variable==''){
                        
             }else{
             $sql= "SELECT DISTINCT td.tdenunciaid , td2.cnombres || ', ' || td2.capellidos as denunciante,
                     ti.cnombres || ', ' || ti.capellidos AS denunciado, td3.cdescripcion as delito 
                   FROM mini_sedi.tbl_denuncia td 
                   INNER JOIN mini_sedi.tbl_denunciante td2 ON td2.tdenunciaid= td.tdenunciaid
                   INNER JOIN mini_sedi.tbl_imputado ti on ti.tdenunciaid =td.tdenunciaid 
                   INNER JOIN mini_sedi.tbl_imputado_delito tid ON tid.tdenunciaid = ti.tdenunciaid 
                   INNER JOIN mini_sedi.tbl_delito td3 ON td3.ndelitoid = tid.ndelito 
                   INNER JOIN mini_sedi.tbl_bandejas tb ON tb.ibandejaid = td.ibandejaid 
                   INNER JOIN mini_sedi.tbl_imputado_fiscalia tif on tif.tdenunciaid = td.tdenunciaid 
                   WHERE tb.ibandejaid = '$variable' and tif.nfiscaliaid = '$bandeja' ORDER BY td.tdenunciaid ASC";
         }
              
                     
                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                <td>'.$rows["tdenunciaid"].'</td>
                                <td>'.$rows["denunciante"].'</td>
                                <td>'.$rows["denunciado"].'</td>
                                <td>'.$rows["delito"].'</td>
                                <td> <div class="checkbox"><label><input type="checkbox" onclick= "recibido('.$rows["tdenunciaid"].')"
                                name="accion" id="accion" value="accion" ><br></label> </div></td>
                                <td><a href="controlEntrega_pdf.php?var='.$rows["tdenunciaid"].'">Imprimir</a></td>

                                
                                
                                </tr>';
                       }  
                    echo "</tbody>
                    </table>";


      
          ?>
          
        </div>
        <div class="col-md-1"> </div>
      </div>
    
   
 
       
     </form>
     </body>
</html>
