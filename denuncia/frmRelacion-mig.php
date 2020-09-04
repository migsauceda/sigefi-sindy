<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
    session_start();
    
    include("../clases/class_conexion_pg.php");
    include("../clases/Imputado.php");
    include("../clases/Relaciones.php");
    
    //imputado
    $objConexion=new Conexion(); 

    $sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
         ."from tbl_imputado where tdenunciaid= ".$_SESSION['denunciaid'];

    $resImputado=$objConexion->ejecutarComando($sql);
    $result= pg_fetch_array($resImputado);
    $imputado_desc= array($result['nombrecompleto']);
    $imputado_val= array($result['tpersonaid']);
    while ($result= pg_fetch_array($resImputado)){
        array_push($imputado_desc, $result['nombrecompleto']);
        array_push($imputado_val,  $result['tpersonaid']);            
    }

    //denunciante
    $objConexion=new Conexion(); 

    $sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
            ."from tbl_denunciante where tdenunciaid= ".$_SESSION['denunciaid'];       

    $resDenunciante=$objConexion->ejecutarComando($sql);
    $result= pg_fetch_array($resDenunciante);
    $denunciante_desc= array($result['nombrecompleto']);
    $denunciante_val=  array($result['tpersonaid']);
    while ($result= pg_fetch_array($resDenunciante))
    {
        array_push($denunciante_desc, $result['nombrecompleto']);
        array_push($denunciante_val,  $result['tpersonaid']);
    } 
        
    //ofendido
    $objConexion=new Conexion(); 
    $sql= "select tpersonaid, cnombres || ' ' || capellidos as nombrecompleto "
            ."from tbl_ofendido where tdenunciaid= ".$_SESSION['denunciaid'];

    $resOfendido=$objConexion->ejecutarComando($sql);
    $result= pg_fetch_array($resOfendido);
    $ofendidos_desc= array($result['nombrecompleto']);
    $ofendidos_val= array($result['tpersonaid']);
    while ($result= pg_fetch_array($resOfendido))
    {
        array_push($ofendidos_desc, $result['nombrecompleto']);
        array_push($ofendidos_val,  $result['tpersonaid']);
    }    
    
    //parentesco
    $objConexion=new Conexion(); 
    $sql= "select nparentescoid, cdescripcion, creciproco from tbl_parentescos;";
    $resParentescos=$objConexion->ejecutarComando($sql);
    $parentescos_desc= array();
    $parentescos_val= array();
    while ($result= pg_fetch_array($resParentescos))
    {
        array_push($parentescos_desc, $result['cdescripcion']);
        array_push($parentescos_val,  $result['nparentescoid']);
    }  
    
    //si ya se ha guardado relaciones para esta denuncia
    if(isset($_SESSION["relaciones"])){
        if ($_SESSION['relaciones']== 't'){
            $oRelaciones= new Relaciones();
            
//            $RelacionesDenunciante= 
//                    $oRelaciones->RecuperarDenunciante($_SESSION['denunciaid']);
//            $RelacionesOfendido= 
//                    $oRelaciones->RecuperarOfendido($_SESSION['denunciaid']);
        }
    }
?>
<html>

<head>
  <title>Relaciones</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 

<!--variables para contar filas de alias y delitos-->
<script type="text/javascript">
	var Denunciante= 2;
	var Ofendido= 2;
	var Contador= 0;
	var Actual= 0;
</script>
</head>

<body>

<p><div align="center"><strong>Relaciones</strong></div></p>
<br><br>

<!--script para llenar tablas-->
<!--javas scripts para llenar los combos-->
<script type="text/javascript">
function CopiarParentesco(frm)
{
    frm.txtcontadordenunciante.value= <?php echo count($denunciante_desc); ?>;
    frm.txtcontadorofendido.value= <?php echo count($ofendidos_desc); ?>;
    frm.txtcontadorimputado.value= <?php echo count($imputado_desc); ?>;    

    return true;

}
</script>

<!-- mostrar mensaje de grabacion exitosa -->
<!-- orm_denuncia.php llama a esta pagina cuando tiene exito en grabar -->
<?php
if (isset($_GET["rsl"]))
    if($_GET["rsl"]== 100)
    {
        unset($_GET["rsl"]);
?>
        <script type="text/javascript">
            alert("Se han guardado las relaciones entre los implicados.");  
            parent.location.href = "../frmExpediente.php"; 
        </script>            
<?php          
    }
?> 

<?php
if (isset($_GET["rsl"]))
    if($_GET["rsl"]== 200)
    {
?>
    <script type="text/javascript">
        alert("Se han modificado los datos generales de la denuncia");
    </script>    
<?php
    unset($_GET["rsl"]);
    }
 ?>   
    
<form name="frmRelaciones" id="frmRelaciones" action="procesarelaciones.php" method="POST" onsubmit="return CopiarParentesco(this);">
	<input type="hidden" name="txtcontadordenunciante" id="txtcontadordenunciante">
	<input type="hidden" name="txtcontadorofendido" id="txtcontadorofendido">
        <input type="hidden" name="txtcontadorimputado" id="txtcontadorimputado">

<!--        <table id="tblBoton" align="center" width="70%" border="0">
            <tr><td>
                    <button type="button"id="btnActualizar" onclick="document.location.reload();">Ingresar relaciones</button>
            </td></tr>
        </table>-->
	<table align="center">
            <TR><TD><input type="submit" value="Guardar"></TD>
	</TR>
	</table>        
        <br>
	<table id="tblDenunciante" name="tblDenunciante" align="center" border="0"
               width="70%" class="TablaCaja">
            <tr class="SubTituloCentro"><th colspan="2">Relación entre el Denunciado y los Denunciantes</th></tr>
        <?php 
            //nombre del denunciado, imputado
            $fila= 0;
            $contaimputado= 0;
            for($contaimputado= 0; $contaimputado < count($imputado_desc); $contaimputado++){
                echo "<tr>";
                echo "<td id=\"tdimpu$contaimputado\" colspan='2'>La relación entre el <strong>denunciado: </strong>";

                //agregar codigo                                                    
                echo "<input type='hidden' name='denunciadoid$contaimputado' id='denunciadoid$contaimputado'>";
                echo "<script type=\"text/javascript\">";
                echo "document.getElementById('denunciadoid$contaimputado').value= $imputado_val[$contaimputado]";
                echo "</script>";
                
                //ahora el nombre                           
                echo $imputado_desc[$contaimputado];
                
                echo "</td>";
                echo "</tr>";
                echo "<tr><td><strong>Con el Denunciante</strong></td> <td><strong>Parentesco</strong></td>";
                echo "</tr>";

                //lista de denunciantes
                for($j= 0; $j < count($denunciante_desc); $j++){
                    if ($j%2 == 0)
                        echo "<tr id=\"tr$fila\" style=\"background-color:aliceblue\">";
                    else
                        echo "<tr id=\"tr$fila\" style=\"background-color:white\">";
                    
                    //columna para el nombre
                    echo "<td id=\"td$fila\">";                    
                    //agregar codigo                                                    
                    echo "<input type='hidden' name='denuncianteid$fila' id='denuncianteid$fila'>";
                    echo "<script type=\"text/javascript\">";
                    echo "document.getElementById('denuncianteid$fila').value= $denunciante_val[$j]";
                    echo "</script>";
                    
                    //ahora el nombre
                    echo $denunciante_desc[$j];
                    echo "</td>";
                    
                    //columna para el combo de parentesco
                    echo "<td id=\"tdp$fila\">";                    
                    echo "<select name= 'parid$fila' id= 'parid$fila'>";
                    $i= 0;
                    for($i= 0; $i < count($parentescos_desc); $i++){
                        echo "<option value='$parentescos_val[$i]'>$parentescos_desc[$i]</option>";
                    }
                    echo "</select>";                    
                    
                    if (isset($oRelaciones)){  
                        $RelacionesDenunciante= 
                            $oRelaciones->RecuperarDenunciante($_SESSION['denunciaid']);
                        while ($row= pg_fetch_array($RelacionesDenunciante)){                            
                            if ($imputado_val[$contaimputado]== $row['nimputadoid'] && 
                                $denunciante_val[$j]== $row['ndenuncianteid']){
                                $parentesco= $row['nparentescoid'];
                                echo "<script type=\"text/javascript\">";
                                echo "document.getElementById('parid$fila').value=$parentesco;";
                                echo "</script>";                                
                            }
                        }
                    }
                    echo "</td>";
                    echo "</tr>";    
                    
                    $fila++;
                }                
            }
        ?>                
	</table>

        <br><br>
        
	<table id="tblOfendido" name="tblOfendido" align="center" border="0"
               width="70%" class="TablaCaja">
            <tr class="SubTituloCentro"><th colspan="2">Relación entre el Denunciado y los Ofendidos</th></tr>             
        <?php 
            //nombre del denunciado, imputado
            $fila= 0;
            $contaofendido= 0;
            for($contaofendido= 0; $contaofendido < count($imputado_desc); $contaofendido++){
                echo "<tr>";
                echo "<td id=\"tdimpu2$contaofendido\" colspan='2'>La relación entre el <strong>denunciado: </strong>";

                //agregar codigo                                                    
                echo "<input type='hidden' name='denunciadoid2$contaofendido' id='denunciadoid2$contaofendido'>";
                echo "<script type=\"text/javascript\">";
                echo "document.getElementById('denunciadoid2$contaofendido').value= $imputado_val[$contaofendido]";
                echo "</script>";
                //ahora el nombre                           
                echo $imputado_desc[$contaofendido];
                
                echo "</td>";
                echo "</tr>";
                echo "<tr><td><strong>Con el Ofendido</strong></td> <td><strong>Parentesco</strong></td>";
                echo "</tr>";

                //lista de ofendido
                for($j= 0; $j < count($ofendidos_desc); $j++){
                    if ($j%2 == 0)
                        echo "<tr id=\"tr$fila\" style=\"background-color:aliceblue\">";
                    else
                        echo "<tr id=\"tr$fila\" style=\"background-color:white\">";
                    
                    //columna para el nombre
                    echo "<td id=\"td$fila\">";                    
                    //agregar codigo                                                    
                    echo "<input type='hidden' name='ofendidoid$fila' id='ofendidoid$fila'>";
                    echo "<script type=\"text/javascript\">";
                    echo "document.getElementById('ofendidoid$fila').value= $ofendidos_val[$j]";
                    echo "</script>";
                    //ahora el nombre
                    echo $ofendidos_desc[$j];
                    echo "</td>";
                    
                    //columna para el combo de parentesco
                    echo "<td id=\"tdp$fila\">";                    
                    echo "<select name= 'parid2$fila' id= 'parid2$fila'>";
                    $i= 0;
                    for($i= 0; $i < count($parentescos_desc); $i++){
                        echo "<option value='$parentescos_val[$i]'>$parentescos_desc[$i]</option>";
                    }
                    echo "</select>";                    
                   
                    if (isset($oRelaciones)){   
                        $RelacionesOfendido= 
                            $oRelaciones->RecuperarOfendido($_SESSION['denunciaid']);                        
                        while ($row= pg_fetch_array($RelacionesOfendido)){
                            if ($imputado_val[$contaofendido]== $row['nimputadoid'] && 
                                $ofendidos_val[$j]== $row['nofendidoid']){
                                $parentesco= $row['nparentescoid'];
                                echo "<script type=\"text/javascript\">";
                                echo "document.getElementById('parid2$fila').value=$parentesco;";
                                echo "</script>";                                
                            }
                        }
                    }                    
                    echo "</td>";
                    echo "</tr>";    
                    
                    $fila++;
                }                
            }
        ?>                
        </table>
        <!--97 79 99 36 ana iris unah posface--> <!--97 79 99 36 ana iris -->
        
	<br>
	<table align="center">
            <TR><TD><input type="submit" value="Guardar"></TD>
	</TR>
	</table>
</form>
</body>
</html>

