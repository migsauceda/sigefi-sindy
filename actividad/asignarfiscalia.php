<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- inclusion de archivos -->
<!--controles para los campos del formulario y conexion-->
<?php 	include("../clases/controles/funct_text.php");
	include("../clases/controles/funct_select.php");	
	include("../clases/controles/funct_radio.php");
	include("../clases/controles/funct_check.php");

	include("../clases/class_conexion_pg.php");

	//funciones genericas
	include "../funciones/php_funciones.php";        
?>
<head>
  <title>Asignar Fiscalia</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
    
    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>    


    <style type="text/css">
        .ui-datepicker {
            font-size: 11px;
            margin-left:10px
         }
    </style>

    <!-- para validar datos e inicializar variable contador de input en tablas -->
    <script type="text/javascript">
        function tmp(){
            alert(document.getElementById("CodFiscalia").value);
        }
        var i= 0;
        function Validar(Tabla){ 
            var filas2= document.getElementById("tblAsignar").rows.length
            error= 0;
            
            //validar fechas
            if (Tabla.txtFechaAsignacion.value== "")
            {
                alert("ERROR: Ingrese fecha de asignación");
                error= 2;
            }
                        
            //se sabe que la primer fila con datos del imputado es la 3
            //numerada desde 0
            filas2--; 
            while (filas2 >= 3)
            {                           
                document.getElementById("CodImputado").value= 
                    document.getElementById("CodImputado").value + "," +
                    document.getElementById("txtDenunciadoid"+filas2).value;
             
                if (document.getElementById("cboFiscalia"+filas2).value== 0)
                {
                    error= 1;
                    alert("ERROR: Existe un denunciado sin fiscalia.");
                }
                
                document.getElementById("CodFiscalia").value= 
                    document.getElementById("CodFiscalia").value + "," +
                    document.getElementById("cboFiscalia"+filas2).value;
                
                filas2--;    
            }
            
            if (error== 1 || error== 2)
            {
                document.getElementById("CodImputado").value= "";
                document.getElementById("CodFiscalia").value= "";
                return false; //existen errores
            }                
            else
                return true;
        }
    </script>
    
    <script type="text/javascript">   
        function InsertarFila(Tabla, Fila, RangoEdad, Denunciadotxt, Denunciadoid, Fiscalia){
//            alert(Tabla+Fila+Denunciadotxt+Denunciadoid+Fiscalia);
            var fil=document.getElementById(Tabla).insertRow(Fila);            

            //delitos
            col00= document.createElement("td"); 
            txtDelito= document.createElement("span");
            txtDelito.id= "txtDelito"+Fila;
            col00.appendChild(txtDelito); 
            fil.appendChild(col00);
 
            $.ajax({
               data: "denunciado="+Denunciadoid,
               type: "POST",
               dataType: "html",
               url: "../funciones/ajax_Delitos_Imputado.php",
               error: function(obj, que, otro){
                   alert("Error ajax al cargar el listado de delitos por denunciado");
               },
               success: function(data){ 
                    document.getElementById("txtDelito"+Fila).innerHTML= data;
               }
            });    

            //rango de edad
            col0= document.createElement("td"); 
            txtRango= document.createElement("span");
            txtRango.id= "txtRango"+Fila;
            col0.appendChild(txtRango); 
            fil.appendChild(col0);            
            
            $.ajax({
               data: "denunciado="+Denunciadoid,
               type: "POST",
               dataType: "html",
               url: "../funciones/ajax_RangoEdadImputado.php",
               error: function(obj, que, otro){
                   alert("Error ajax al cargar el rango de edad por denunciado");
               },
               success: function(data){
                    document.getElementById("txtRango"+Fila).innerHTML= data;
               }
            }); 
            
            //imputado nombre
            col1= document.createElement("td");             
            txtDenunciadoNomb= document.createElement("input");
            txtDenunciadoNomb.type= "text";
            txtDenunciadoNomb.name= "txtDenunciado"+Fila;
            txtDenunciadoNomb.id= "txtDenunciado"+Fila;
            txtDenunciadoNomb.value= Denunciadotxt;
            txtDenunciadoNomb.size= 30;
            txtDenunciadoNomb.readonly= "readonly";

            col1.appendChild(txtDenunciadoNomb); 
            fil.appendChild(col1);    
            
            //imputado codigo       
            txtDenunciadoid= document.createElement("input");
            txtDenunciadoid.type= "hidden";
            txtDenunciadoid.name= "txtDenunciadoid"+Fila;
            txtDenunciadoid.id= "txtDenunciadoid"+Fila;
            txtDenunciadoid.value= Denunciadoid;         

            col1.appendChild(txtDenunciadoid); 
            fil.appendChild(col1);                
            
            //fiscalia actual
            col2= document.createElement("td"); 
            txtFiscalia= document.createElement("input");
            txtFiscalia.type= "text";
            txtFiscalia.name= "txtFiscalia"+Fila;
            txtFiscalia.id= "txtFiscalia"+Fila;
            txtFiscalia.value= Fiscalia;

            col2.appendChild(txtFiscalia); 
            fil.appendChild(col2);           
            
            //fiscalia nueva
            col3= document.createElement("td");
            cbo= document.createElement("select");
            cbo.id="cboFiscalia"+Fila;
            cbo.name="cboFiscalia"+Fila;
            opt=document.createElement("option");
            opt.value= "0";
            opt.text= "Seleccione...";
            opt.selected= "selected";
            cbo.appendChild(opt);
           
            //cargar todas las fiscalias en el combo
            <?php
            $curFiscalias= CargarFiscalia();
            while ($regFiscalias= pg_fetch_array($curFiscalias)){
            ?>
                opt=document.createElement("option");
                opt.value= "<?php echo($regFiscalias[ibandejaid]); ?>";
                opt.text= "<?php echo($regFiscalias[cdescripcion]); ?>";
                cbo.appendChild(opt);                    
            <?php
            }
            ?>
            col3.appendChild(cbo);                        
            fil.appendChild(col3); 
        }
    </script>    

</head>

<body>

<script type="text/javascript">
    $(function() {
        $( "#txtFechaAsignacion" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });
    });

    function CalDenuncia(){
        $( "#txtFechaAsignacion" ).datepicker();

    }
    
    function Imputados(denuncia, destino){
        CargarImputado(denuncia);
//        alert(destino);
    }
</script>
 
<br><br>
<FORM action="procesaasignarfiscalia.php" method="POST" id="frmAsignar" onsubmit=" return Validar(this);">
<table width="80%"align="center" border="1" name="tblAsignar" id="tblAsignar" class="TablaCaja">
<!-- titulo de la tabla -->
<TR class="SubTituloCentro"><TH colspan="5" align="center"><strong>Asignación por Imputado</strong></TH></TR>

<!-- celdas independientes para la fecha -->
<tr>
    <td align="right"><strong>Fecha asignación </strong></td>
<TD colspan="4"><input type="text" name="txtFechaAsignacion" id="txtFechaAsignacion" size="15" required>
</TD>
</tr>

<!-- titulos de las columnas-->
<tr align="center">
<td width="20%"><strong>Delitos</strong></td>
<TD width="8%"><strong>Rango de edad</strong></TD>
<TD width="15%"><strong>Imputado / Niño infractor</strong></TD>
<TD width="5%"><strong>Fiscalia actual</strong></TD>
<TD width="5%"><strong>Fiscalia nueva</strong></TD>
</tr>
</table> <!-- fin tabla de datos -->

<!-- campos ocultos para guardar los codigos de: imputado, fiscalia y denunciaid -->
<input type="hidden" id="CodImputado" name="CodImputado">
<input type="hidden" id="CodFiscalia" name="CodFiscalia">
<input type="hidden" id="txtDenunciaId" name="txtDenunciaId">

<!-- conocer el numero de filas de la tabla -->
<script type="text/javascript">
    document.getElementById("txtDenunciaId").value= "<?php echo $_GET['id']; ?>";
    var tbl= document.getElementById("tblAsignar");
    var filas= tbl.rows.length;
</script>

<!-- ciclo para repetir filas por cada denunciado "personaid","nombrecompleto"-->
<?php
$resDenunciado= CargarDenunciados($_GET['id']);

while($registro= pg_fetch_array($resDenunciado))
{
    //cargar fiscalia actual
    $resFiscaliaA= CargarFiscaliaActual($_GET['id'], $registro[personaid]);
    $regFiscaliaA= pg_fetch_array($resFiscaliaA);
?>

<!-- crear fila denamicamente -->
<script type="text/javascript">
    InsertarFila("tblAsignar", filas, 
        "<?php echo($registro[rango]); ?>",
        "<?php echo($registro[nombrecompleto]); ?>", 
        "<?php echo($registro[personaid]); ?>", 
        "<?php echo($regFiscaliaA[cdescripcion]); ?>");
        
    filas++;
</script>

<?php
}
?>  
<script text="type/javascript">
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    var FechaActual = dd+'/'+mm+'/'+yyyy;   
    document.getElementById('txtFechaAsignacion').value= FechaActual;
</script>
<br>
<!-- tabla para mostrar los botones -->
<table align="center">
  <tbody>
    <tr>
      <td><INPUT type="submit" name="btnSubmit" value="Guardar datos"></td>
      <td><INPUT type="reset" name="btnReset" value="Limpiar campos"></td>
    </tr>
  </tbody>
</table>
</FORM>
</body>
</html>