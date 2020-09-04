<?php
session_start();
/*la unica función es invocar la funcion: ValidarEstado('FinalizarNueva');     
 * para saber si finalizar o no una denuncia
 * se hace asi para evitar que al cargar los tab se ejecute esta funcion
 * al hacer la llamada desde los mismos tabs
 */
include_once "../funciones/php_funciones.php";
include_once './clases/class_conexion_pg.php';

//saber si habilitar o no el boton de guardar, 
//validando si la denuncia esta completa
$valor = $_SESSION['denunciaid'];
$objConexion=new Conexion(); 
$sql= "select denunciacompleta($valor);";

$resultado=$objConexion->ejecutarComando($sql);
$indicador=pg_num_rows($resultado);
if ($indicador == 1)
    $_SESSION['denuncia_completa']= 1;
else
    $_SESSION['denuncia_completa']= 0;


//deja en estado de espera
//ValidarEstado('FinalizarNueva');   
//exit($_SESSION['estado']);
?>

<html>
    <head>
        <!--<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=ProcesaFinalizarDenuncia.php"> -->
<!--        <script type="text/javascript" src="../java_script/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="../java_script/jquery-ui-1.8.12.custom.min.js"></script>       -->
    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>            
    
    <script type="text/javascript">
        function Estado(){
            //varifica el valor del campo estado de la tabla tbl_controlestados
            //solo si esta en Nuevo se puede modificar la denuncia
            //en caso contrario se modifica solo el exp y no la denuncia
            $.ajax({
                data: "Parametro=control",
                type: "GET",
                dataType: "text",
                url: "../funciones/ajax_llamar_funciones.php",
                error: function(){
                    alert("Error al revisar el estado de la denuncia");
                },
                success: function(data){
                    document.getElementById("modificar").value= data.trim();
                }
            });//ajax
        }
        
        function RevisarCompleto(){
            //verifica que efectivamente se hayan guardado todos los elementos de la denuncia
            //generales, denunciantes, denunciados, ofendidos y opcionalmente parentescos
            $.ajax({
                data: "Parametro=validar",
                type: "GET",
                dataType: "text",
                url: "../funciones/ajax_llamar_funciones.php",
                error: function(){
                    alert("Error al revisar si la denuncia esta completa ");
                },
                success: function(data){   
                    //7:generales, 9:denunciates, 11:denunciados
                    //13:ofendidos, 15:relaciones (opcional)
                    general=    data[7];
                    denunaiante=data[9];
                    denunciado= data[11];
                    ofendido=   data[13];
                    relacion=   data[15];
                    
                    if (general > 0){
                        //ok
                        document.getElementById("generales").value= 'Completo';
                    }
                    else{
                        document.getElementById("generales").value= 'Incompleto';
                    }
                    
                    if (denunaiante > 0){
                        //ok
                        document.getElementById("denunciante").value= 'Completo, '+denunaiante+' Denunciantes';                        
                    }   
                    else{
                        document.getElementById("denunciante").value= 'Incompleto';
                    }
                    
                    if (denunciado > 0){
                        //ok
                        document.getElementById("denunciado").value= 'Completo, '+denunciado+' Denunciados';
                    }       
                    else{
                        document.getElementById("denunciado").value= 'Incompleto';
                    }
                    
                    if (ofendido > 0){
                        //ok
                        document.getElementById("ofendido").value= 'Completo, '+ofendido+' Ofendido';
                    }     
                    else{
                        document.getElementById("ofendido").value= 'Incompleto';
                    }

                    if (relacion > 0){
                        //ok
                        document.getElementById("relacion").value= 'Completo';
                    }     
                    else{
                        document.getElementById("relacion").value= 'Incompleto';
                    }                    
                }//success
            }); //ajax              
        }        
        
        function ForzarModificar(){
            //cambia el valor del campo estado en la tabla tbl_controlestados
            //lo cambia a Nueva para que se pueda modificar la denuncia
            $.ajax({
                data: "Parametro=forzar",
                type: "GET",
                dataType: "text",
                url: "../funciones/ajax_llamar_funciones.php",
                error: function(){
                    alert("Error al cambiar el estado de la denuncia a modificable");
                },
                success: function(data){
                      window.open("../aplicacion.php",'_parent');
//                      window.open("../frmExpediente.php",'_parent');
//                    location.href= "../frmExpediente.php";
                }
            });
        }     
        
        function MensajeContinuar(){
//            alert("Se continua con la misma denuncia");
            window.open("../aplicacion.php",'_parent');

//            location.href= "../frmExpediente.php";
        }        
        
        function GenerarPDF(){
            var Modificar= document.getElementById("modificar").value;            
            Modificar= Modificar.trim();
//            document.getElementById("modificar").value == "Modificable"
            if (Modificar == "Modificable"){ 
                var Modificar= "si";
            }
            else{
//                alert("La denuncia impresa NO se modificará");
            }
            
            $.ajax({
                data: "Parametro=pdf&Modificar="+Modificar,
                type: "GET",
                dataType: "text",
                url: "../funciones/ajax_llamar_funciones.php",
                error: function(){
                    alert("Error al crear archivo PDF");
                },
                success: function(data){ 
                    location.href= '../reportes/reporte1b.php?denunciaprn='+data;                
			//location.href= '../reportes/denuncia_pdf.php?denunciaprn='+data; 
                }
            });
        }        
        
        function GenerarFe(){
            if (document.getElementById("modificar").value == "Modificable"){ 
                var Modificar= "si";
            }
            else{
//                alert("La denuncia impresa NO se modificará");
            }
            
            $.ajax({
                data: "Parametro=pdf&Modificar="+Modificar,
                type: "GET",
                dataType: "text",
                url: "../funciones/ajax_llamar_funciones.php",
                error: function(){
                    alert("Error al crear archivo PDF");
                },
                success: function(data){ alert(data);
                    location.href= '../reportes/FeDenuncia.php?denunciaprn='+data;                
                }
            });
        }        
    </script>
    
    </head>
    <body>
        <h3 align="center">Estado de la denuncia actual</h3>
        
	<table align="center">
	<tbody align="right">
	<tr>
	<td>Usuario</td>
	<td><INPUT type="text" name="usr" id="usr" size="20"></td>
	</tr>
	<tr>
	<td>Fecha</td>
	<td><INPUT type="text" name="fecha" id="fecha" size="20"></td>
	</tr>
	<tr>
	<td>Número único</td>
	<td><INPUT type="text" name="numero" id="numero" size="20"></td>
	</tr>
	<tr>
	<td>Estado de la denuncia</td>
	<td><INPUT type="text" name="modificar" id="modificar" size="20"></td>
	</tr>        
	<tr>
	<td>Datos generales</td>
        <td><INPUT type="text" name="generales" id="generales" size="20"></td>
	</tr>
	<tr>
	<td>Datos del denunciante</td>
	<td><INPUT type="text" name="denunciante" id="denunciante" size="20"></td>
	</tr>
	<tr>
	<td>Datos del denunciado</td>
	<td><INPUT type="text" name="denunciado" id="denunciado" size="20"></td>
	</tr>
	<tr>
	<td>Datos del ofendido</td>
	<td><INPUT type="text" name="ofendido" id="ofendido" size="20"></td>
	</tr>
	<tr>
	<td>Relación entre participantes</td>
	<td><INPUT type="text" name="relacion" id="relacion" size="20"></td>
	</tr>        
	</tbody>
	</table>
  
        <script type="text/javascript">     
            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");            
            Fecha= new Date;
            dia= Fecha.getDate();
            mes= Fecha.getMonth();
            anio= Fecha.getFullYear();
            document.getElementById("usr").value= "<?php echo $_SESSION['usuario'];?>";
            document.getElementById("fecha").value= dia+" de "+meses[mes]+" de "+anio;
            document.getElementById("numero").value= "<?php echo $_SESSION['denunciaid'];?>";   
            
            document.getElementById("modificar").value=   "<?php echo $_SESSION['denunciaid'];?>";
            
            Estado();
            RevisarCompleto();
        </script>  
        
        <br>
        <table align="center" border="1">
            <tr>
            <td><input type="button" value="Forzar modificar" onclick="ForzarModificar();";></td>
<!--            <td><input type="button" value="Continuar con la denuncia actual" onclick="MensajeContinuar();";></td>-->
            <td><input type="button" value="Imprimir borrador" onclick="GenerarPDF();"></td>
            <td><input type="button" value="Fe de denucnia" onclick="GenerarFe();"></td>            
            <!--<td><input type="button" id="btnGuardar" value="Guardarla e ir al menú principal" onclick="Guardar();" disabled></td>-->            
            </tr>
        </table>
        <script>
            if(<?php echo $_SESSION['denuncia_completa']; ?>== 1){
                document.getElementById("btnGuardar").disabled= false;
            }
            else{
                document.getElementById("btnGuardar").disabled= true;
            }
        </script>
        
    </body>
</html>
