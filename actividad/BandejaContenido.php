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
//    if ($objUsuario->getPermiso(4)== '0'){ 
//        ?>
<!--        <script type="text/javascript">
        alert("No tiene acceso a esta opción");    
        top.location = "../aplicacion.php";     
        </script>    -->
        //<?php
//    }
    
    //conocer la cantidad total de registros
    $TotalRegistros= ContarListarContenidoBandeja($objUsuario->getSubBandejaId());

    //cantidad de registros a ver por pantalla
    $limit= 15;
    $offset= 0;
    
    BorrarDenunciaRAM();    
?>
<html>

<head>
  <title>Listar Bandeja</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 

  <script type="text/javascript">
  function MostrarHechos(hechos, idn){
    var ventana = document.getElementById('NarracionHecho');
    ventana.style.marginTop = "100px";
    ventana.style.left = ((document.body.clientWidth-350) / 2) +  "px";
    ventana.style.display = 'block';     
     
    document.getElementById("idden").innerHTML = idn;
    document.getElementById("hechos").innerHTML = hechos;
  }
  
  function CerrarHechos(){
    var ventana = document.getElementById('NarracionHecho');
    ventana.style.display = 'none';      
  }
  
  function AsignarFiscalia(numero){ 
      document.location= "asignarfiscalia.php?id="+numero;
  }
  
  function ModificarLimites(limite){
    if (limite== "ant"){
        <?php 
            if (isset($_POST['actual'])){
                $offset= (int)$_POST['actual'];
                $offset -= $limit;
                if ($offset < 0) $offset= 0;                   
            }
        ?>
        document.getElementById('actual').value= "<?php echo $offset; ?>";
    }
        
    if (limite== "sig"){      
        <?php 
            if (isset($_POST['actual'])){
                $offset= (int)$_POST['actual'];
                $offset += $limit;                
            }        
        ?>   
        document.getElementById('actual').value= "<?php echo $offset; ?>";
    }      
    }  
  </script>

</head>
    <style type="text/css">
        .LetraTabla{
          font-family:Verdana, Arial, Helvetica, sans-serif;
          font-size:20px;
        }
    </style>
  
    <style type="text/css">
            body,html{background-color:transparent;}
            .Fila_0{
                background-color: #FFFFFF;
                font-family:Verdana, Arial, Helvetica, sans-serif;
                font-size:15px;    
                height: 35px;
            }
            .Fila_1{
                background-color: #F8F8FF;
                font-family:Verdana, Arial, Helvetica, sans-serif;
                font-size:15px; 
                height: 35px;
            }                         
    </style> 
<body>

<br>
<form id="frmAsignarFiscalia" method="post">
    <div align="center"><strong><h3>Denuncias sin Asignar a Fiscalía</h3></strong></div>
    
    <div align="center">
        <progress value="0" id="progreso" max="<?php echo $TotalRegistros; ?>" </progress>;
    </div>
    <div align="center"> <input type="submit" id="ant" name="ant" value="Anterior" 
                                onclick='ModificarLimites("ant")'> 
                         <input type="submit" id="sig" name="sig" value="Siguiente"
                                onclick='ModificarLimites("sig")'>
                         <br><br><strong>Buscar por número:</strong>
                         <br><input type="text" id="buscar" name="buscar" maxlength="10" size="10">
                         <input type="button" id="bAsignar" name="bAsignar" value="Asignar" 
                                onclick="javascript:AsignarFiscalia(document.getElementById('buscar').value)">
    </div>    
    <br>
    <input type="hidden" name="opc" id="opc">
    <input type="hidden" name="actual" id="actual">
        
    <table align="center" id="contenido" name="contenido" border="1" class="TablaCaja">
      <tbody align="center">
        <tr class="SubTituloCentro">
          <th><strong>&nbsp;Número SEDI&nbsp;</strong></th>
          <th><strong>&nbsp;Número de denuncia&nbsp;</strong></th>
          <th><strong>&nbsp;Fecha de creación&nbsp;</strong></th>
          <th><strong>&nbsp;Lugar de recepción&nbsp;</strong></th>
          <th><strong>&nbsp;Hechos&nbsp;</strong></th>
          <th><strong>&nbsp;Asignar&nbsp;</strong></th>
        </tr>
        
        <?php 
            //$regDenuncias= ListarContenidoBandeja($_SESSION['bandeja'], $limit, $offset);
            $regDenuncias= ListarContenidoBandeja($objUsuario->getSubBandejaId(), 1000, $offset);
            $fila= pg_fetch_array($regDenuncias);
            
            if (!isset($_POST['actual'])){              
                $offset = 0;   
        ?>
                <script type="text/javascript">
                document.getElementById('actual').value= "0";
                </script>
        <?php
            }
            else{
        ?>
                <script type="text/javascript">
                document.getElementById('actual').value= "<?php echo $_POST['actual']; ?>";
                document.getElementById("progreso").value = document.getElementById('actual').value;
                </script>
        <?php 
            }                        
            $i= 1;
            while ($fila)
            { 
        
                    $hechos= $fila["cnarracionhecho"];
                    $id= $fila["tdenunciaid"];
            ?>
                    <script type="text/javascript">
                    var Hechos= <?php echo $hechos; ?>
                    </script>
                    <tr class="<?php if($i % 2 == 0) echo Fila_1; else echo Fila_0; ?>" >
                    <td><?php echo $fila["cexpedientesedi"]; ?> </td>
                    <td><?php echo $fila["tdenunciaid"]; ?> </td>
                    <td><?php echo $fila["dfechadenuncia"]; ?> </td>
                    <td><?php echo $fila["cdescripcion"]; ?> </td>
            <?php
                    echo "<td>"; 
                        echo "<a href= 'javascript:MostrarHechos(\"$hechos\", \"$id\")'> Ver </a>";
                    echo "</td>";
                    echo "<td>"; 
                        echo "<a href= 'javascript:AsignarFiscalia(\"$id\")'> Asignar </a>";
                    echo "</td>";  
                    echo "</tr>";
                    
                    $fila= pg_fetch_array($regDenuncias);
                    $i++;
            }
        ?>
      </tbody>
    </table>
</form>
</body>

<!-- para ventana modal -->
<div onclick="CerrarHechos();" id="NarracionHecho" style="position: fixed; width: 600px; height: 325px; top: 0; left: 0;
     font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; 
     font-weight: normal; border: #333333 3px solid; background-color: #FAFAFA; 
     color: #000000; display:none;">
    
    <script type="text/javascript">
        document.write(varhechos);
    </script>
    
    <strong> Narración de hechos, denuncia: </strong><span id="idden"></span>
    <textarea cols="72" rows="20" id="hechos" name="hechos">       
    </textarea>    
</div>
</html>