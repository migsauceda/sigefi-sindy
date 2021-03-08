<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
    include "../clases/Usuario.php";
        
    session_start();

    //funciones genericas
    include "../funciones/php_funciones.php";

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }

    //valida derechos
//    if ($objUsuario->getPermiso(3)== '0'){ 
//        ?>
<!--        <script type="text/javascript">
        alert("No tiene acceso a esta opción");    
        top.location = "../aplicacion.php";     
        </script>    -->
        <?php
//    } 
//    exit($objUsuario->getOficinaId());
    BorrarDenunciaRAM();    
?>
<html>

<head>
  <title>Listar Bandeja</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">
  function MostrarHechos(hechos, denuncia){
    //variable local
    var ventana = document.getElementById('NarracionHecho');
    ventana.style.marginTop = "100px";
    ventana.style.left = ((document.body.clientWidth-350) / 2) +  "px";
    ventana.style.display = 'block';     
    
    //agregar el numero de denuncia
    hechos= "NARRACIÓN DE HECHOS DE LA DENUNCIA NÚMERO: "+denuncia+"\n\n"+hechos;
    document.getElementById("hechos").innerHTML = hechos;
  }
  
  function CerrarHechos(){
    var ventana = document.getElementById('NarracionHecho');
    ventana.style.display = 'none';      
  }
  
  function AsignarFiscalia(numero){
      document.location= "asignarfiscal.php?id="+numero;
  }
  
  function Recargar(accion){ 
    document.location.href= 'BandejaFiscalia.php?opcion='+accion;
  }
  </script>

   <script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

</head>
<body>

<br><br>
<div align="center"><strong><h3>Listado de Denuncias</h3></strong></div>
<table align="center" id="tblOpciones" name="tblOpciones" border="1">
    <tr>
        <td>
            <input type="radio" name="rdOpciones" id="rdOpciones1" value="SinAsignar" 
                   onclick="Recargar('sin');" checked>Sin asignar
            <input type="radio" name="rdOpciones" id="rdOpciones2" value="Asignadas"
                   onclick="Recargar('asi');">Asignadas
            <input type="radio" name="rdOpciones" id="rdOpciones3" value="Rotar"
                   onclick="Recargar('rot');">Rotar a otra fiscalía
        </td>
    </tr>
</table>

<br>

<?php
session_start();
        echo '

         <table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
                      <thead>
                        <tr>
        <th><strong>&nbsp;Número de denuncia&nbsp;</strong></th>
          <th><strong>&nbsp;Fecha de creación&nbsp;</strong></th>
          <th><strong>&nbsp;Fiscalia asignada&nbsp;</strong></th>
          <th><strong>&nbsp;Hechos&nbsp;</strong></th>
          <th><strong>&nbsp;Asignar&nbsp;</strong></th>
                         </tr>
                      </thead>
                      <tbody>';

    
        //$ubicacion= $objUsuario->getOficinaId();        
        $ubicacion= $objUsuario->getBandejaId();        
//        exit($ubicacion);

        if (isset($_GET['opcion']))
        {             
            if ($_GET['opcion']== 'sin'){                
                $regDenuncias= ListarPendientesFiscal($ubicacion, 'noasignada');
                ?>
                <script type="text/javascript">
                    document.getElementById('rdOpciones1').checked= true;
                </script>
                <?php                
            }
            if ($_GET['opcion']== 'asi'){
                $regDenuncias= ListarPendientesFiscal($ubicacion, 'asignada');
                ?>
                <script type="text/javascript">
                    document.getElementById('rdOpciones2').checked= true;
                </script>
                <?php                
            }
        }
        else {    
            $regDenuncias= ListarPendientesFiscal($ubicacion, 'noasignada');            
        }
        $fila= pg_fetch_array($regDenuncias);

  while ($fila)
  { 
                $hechos= $fila["cnarracionhecho"];
                $id= $fila["tdenunciaid"];
    echo "<tr class='Grid'>";                  
               
    echo "<td>"; echo $fila["tdenunciaid"]; echo "</td>";
    echo "<td>"; echo $fila["dfechadenuncia"]; echo "</td>";
    echo "<td>"; echo $fila["cdescripcion"]; echo "</td>";
    echo "<td>"; 
                    echo "<a href= 'javascript:MostrarHechos(\"$hechos\", \"$id\")'> Ver </a>";
    echo "</td>";
    echo "<td>"; 
                    echo "<a href= 'javascript:AsignarFiscalia(\"$id\")'> Asignar </a>";
    echo "</td>";                
    echo "</tr>";
                
                $fila= pg_fetch_array($regDenuncias);
  }
    ?>
  </tbody>
</table>

</body>

<!-- para ventana modal -->
<div onclick="CerrarHechos();" id="NarracionHecho" style="position: fixed; width: 600px; height: 325px; top: 0; left: 0;
     font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; 
     font-weight: normal; border: #333333 3px solid; background-color: #FAFAFA; 
     color: #000000; display:none;">
    
    <script type="text/javascript">
        document.write(varhechos);
    </script>
    
    <textarea cols="96" rows="24" id="hechos" name="hechos">       
    </textarea>    
</div>
</html>