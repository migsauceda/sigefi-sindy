<?php 
include "../clases/Usuario.php";
include_once "../clases/class_conexion_pg.php";

session_start(); 
//saber si esta conectado y si tiene derechos
if (isset($_SESSION['objUsuario'])){
    $objUsuario= $_SESSION['objUsuario'];        
}else{
    header("location:index.php");
}
//valida derechos
/*
 * COMENTADO PARA QUE LOS FISCALES Y TODOS PUEDAN METER DENUCNIAS
if ($objUsuario->getPermiso(2)== '0' && $objUsuario->getPermiso(1)== '0'){ 
    ?>
    <script type="text/javascript">
    alert("No tiene acceso a esta opción.");    
    top.location = "../aplicacion.php";     
    </script>    
    <?php
}
*/

//iniciar una nueva denuncia si ya ha ingresado otras
if(isset($_GET['CambiarEstado'])){ 
    if ($_GET['CambiarEstado']== 'NUEVA'){ 
        //borrar registros en tabla control de estados, para que no quede denuncia pendiente    
        //$Usr= $_SESSION['usuario']; 
        
        if (!isset($_SESSION['denunciaid'])){
            $_SESSION['denunciaid']= 0;
        }
        
        $Usr= $objUsuario->getUsuario();
        $sql= "select mini_sedi.controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";

        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);                       

        $_SESSION['CambiarTab']= '0';
        $_SESSION['generales']= 'f';
        $_SESSION['denunciante']= 'f';
        $_SESSION['ofendido']= 'f';
        $_SESSION['denunciado']= 'f';    
        $_SESSION['relaciones']= 'f';

        unset($oDenuncia);
        unset($oDenunciante);
        unset($oOfendido);
        unset($oDenunciado);
        unset($oRelaciones); 

        unset($_SESSION["oDenuncia"]);
        unset($_SESSION["oDenunciante"]);
        unset($_SESSION["oOfendido"]);
        unset($_SESSION["oDenunciado"]);       
        unset($_SESSION["oRelaciones"]);
        unset($_SESSION["denunciaid"]);            

        //sessions para controlar varios imputados, denunciados y ofendidos
        unset($_SESSION["oDenuncianteCola"]);
        unset($_SESSION["oDenunciadoCola"]);
        unset($_SESSION["oOfendidoCola"]); 
        
        if (isset($_SESSION['estado'])){
            $_SESSION['estado']= 'Espera';
        }
    }
}
    
//traer las entrevistas pendientes de convertir a denuncias
//para esa bandeja
$objConexion= new Conexion();
$sql= "SELECT cnombres || ', ' || capellidos as nombres, entrevistaid, cnumerotomaturno as turno, ccreada from mini_sedi.entrevistas()";
$reg= $objConexion->ejecutarComando($sql);
echo pg_num_rows($reg);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Convertir Entrevista en Denuncia</title>
        <script src="../java_script/js/jquery-1.10.2.js"></script>
        <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>           
    </head>
    <body>      
        <div align='center'>
            <h3>Crear denuncia a partir de un formulario nuevo<br>o una entrevista</h3>
            <input type='button' name='nueva' id='nueva' value='A partir de un formulario nuevo'
                   onclick="CrearDenuncia('nueva');">
            <br><br>
            <label>Lista de entrevistados</label>
            <br>
            <select name="pendientes" id="pendientes" size='5' onclick="DesabilitaBotones();">
                <?php
                while ($opcion= pg_fetch_array($reg))
                {
                ?>
                    <option value="<?php echo $opcion['entrevistaid']; ?>"><?php echo $opcion['nombres']; ?> </option>
                <?php
                }
                ?>
            </select>
            <br>
            <input type='button' name='entrevista' id='entrevista' value='A partir de entrevista seleccionada' 
                   onclick="CrearDenuncia('entrevista');" disabled>
        </div>
    </body>

<script type="text/javascript">
    (function (){ 
       //para saber si hay denuncias pendientes para este usuario
        $.ajax({
            data: "dato=estado",
            type: "GET",
            dataType: "text",
            url: "../funciones/ajax_estado_denuncia.php",
            error: function(){
                alert("frmConvertirEntrevista.php: Error al recuperar estado de la denuncia: ");
            },
            success: function(data){ 
                Estado= data;

                if (Estado== "Completando"){  
                    CrearNueva= confirm("Tiene una denuncia pendiente. ¿Desea borrarla e iniciar una nueva?");
                    if (CrearNueva){
                        //borrarla
                        location.href='../denuncia/frmConvertirEntrevista.php?CambiarEstado=NUEVA';
                    }
                    else{
                        //alert("Se continuará con la denuncia actual");
                        location.href= "../denuncia/frmExpediente.php";
                    }                    
                }
                if (Estado== "Espera"){  
                    //no hace nada, continua en esta ventana
                }
                else{
                    //esta en estado de espera. se inicia una nueva
                    //location.href='../denuncia/frmExpediente.php?CambiarEstado=SI';
                }
            }//success
        }); //ajax       
    }());
    function DesabilitaBotones(){
        document.getElementById('nueva').disabled= true;
        document.getElementById('entrevista').disabled= false;
    }
    
    function CrearDenuncia(opcion){ 
        if (opcion=== 'entrevista'){
            //llamar procedimiento en la base de datos que haga la copia
            //y luego ponga la bandera de bconvertido en tbl_entrevista a true
            $.ajax({
                data: "entrevistaid="+document.getElementById('pendientes').value,
                type: "POST",
                dataType: "text",
                url: "../funciones/ajax_convertir_entrevista.php", 
                error: function(objeto, quepaso, otroobj){
                    alert("Error al copiar datos del denunciante: "+objeto.value+quepaso+otroobj);        
                },
                success: function(data){
//                    alert(data);
                    location.href= "../denuncia/frmExpediente.php";
                }
            });            
//            alert(document.getElementById('pendientes').value);
        }
        else{
            location.href='frmExpediente.php?CambiarEstado=SI';
        }
    }
</script>
</html>
