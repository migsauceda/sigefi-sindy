<!--controles para los campos del formulario, clases y funciones-->
<?php 	                                
        include "../clases/Usuario.php";
	include("../clases/controles/funct_select.php");

	//clase
	include("../clases/Denuncia.php");

	//funciones genericas
	include "../funciones/php_funciones.php";
        
        //inicia sesión
//        session_start(); 
        
        if (isset($_SESSION['objUsuario'])){
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            header("location:index.php");
        }

        //si el objeto ya existe, inicializarlo de nuevo para mostrar los datos
        if(isset($_SESSION["oDenuncia"])){ 
            $oDenuncia= $_SESSION["oDenuncia"];             
        }      
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Datos Generales</title> 
          <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
        
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
    <script src="../java_script/js/jquery.datetimepicker.js"></script>  
    <script src="../funciones/funciones.js"></script>         

</head>
<style type="text/css">
    .ui-datepicker {
        font-size: 11px;
        margin-left:10px
     }     
</style>
<body>

<p><div align="center"><strong>Datos Generales de la Denuncia</strong></div></p>
<br><br>

<script type="text/javascript">
    $(function(){
        $("#txtFechaDenuncia").datetimepicker({
            format:'d/m/Y H:m',
            formatTime:'H:m',
            formatDate:'DD/MM/YYYY'
        });
    });
    
    $(function(){
        $("#txtFechaHecho").datetimepicker({
            format:'d/m/Y H:m',
            formatTime:'H:m',
            formatDate:'DD/MM/YYYY'
        });
    });    
</script>

<!--funciones java script a usar en el formulario-->
<script type="text/javascript">
function LlenarFormulario(){ 
    
    document.getElementById("cboDepto0").value= "<?php echo $objUsuario->getDeptoRecepcionId(); ?>";
    document.getElementById("cboMuni0").value= "<?php echo $objUsuario->getMuniRecepcionId(); ?>";        
                       
    <?php
    if(isset($_SESSION["oDenuncia"])){
    ?>

    //llena depto, municipio, aldea, barrio
    LlenaDireccionHecho("<?php echo($oDenuncia->getDepartamentoHecho());?>",
                        "<?php echo($oDenuncia->getMunicipioHecho());?>",
                        "<?php echo($oDenuncia->getAldeaCaserioHecho());?>",
                        "<?php echo($oDenuncia->getBarrioColoniaHecho());?>"
                        );
    <?php
    }
    ?>               
}                
</script>                                

<!--formulario principal width="70%" --> 
<FORM  name="frmDenuncia" action="procesagenerales.php" method="POST" onSubmit="return ValidarGenerales(this); ">
<table id="tbl1" align="center" border="0" cellspacing="0" cellpading="0">
  <tbody>
  <input type="hidden" name="txtDireccionHecho" id="txtDireccionHecho">
  <input type="hidden" name="txtDireccionDenuncia" id="txtDireccionDenuncia">
    <tr>
        <td>
	<TABLE align="center" border="0" class="TablaCaja" cellspacing="0" cellpading="0">
	<tr class="SubTituloCentro"><TH colspan="8">Números de</TH></tr>
   	<tr class="SubTituloDerecha">
		<th>Entrevista</th><th>SEDI / Interno</th><th>Autopsia</th><th>Levantamieto</th><th>Transito</th><th>Judicial</th><th>Policial</th><th>Único MP</th></tr>
	<tr class="Grid">
                <!--entrevista-->
		<td>                           
<!--                    <input name="txtEntrevista" type="text" id="txtEntrevista" size="10" maxlength="10"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                           { echo($oDenuncia->getTomaTurno()); } ?>" readonly/> -->
                    <input name="txtEntrevista" type="text" id="txtEntrevista" size="10" maxlength="10"
                       value="0" readonly/>                            
                </td>
                
                <!--sedi-->
		<td>                           
                    <input name="txtDenuncia" type="text" id="txtDenuncia" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getNumero()); } ?>"/> 
                </td>

                <!--autopsia-->
		<td>                           
                    <input name="txtAutopsia" type="text" id="txtAutopsia" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getAutopsia()); } ?>"/> 
                </td>              

                <!-- levantamiento -->
		<td>                           
                    <input name="txtLevantamiento" type="text" id="txtLevantamiento" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getLevantamiento()); } ?>"/> 
                </td>           
                
                <!--policia transito-->
		<td>                           
                    <input name="txtTransito" type="text" id="txtTransito" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getTransito()); } ?>"/> 
                </td>               
                
                <!--judicial-->
		<td>
                    <input name="txtExpediente" type="text" id="txtExpediente" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getExpedienteJudicial()); } ?>"/>
                </td>
                
                <!--policial-->
		<td>
                    <input name="txtExpPolicial" type="text" id="txtExpPolicial" size="10" maxlength="19"
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getExpedientePolicial()); } ?>"/>                    
                </td>
                
                <!--unico del mp-->
		<td>
                    <input name="txtmp" type="text" id="txtmp" size="15" maxlength="19" readonly
                       value="<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getDenunciaId()); } ?>"/>                    
                </td>                
	</tr>
 	</TABLE>
    </td>

    </tr>
  </tbody>
</table>
<br>
<table id="tbl1" align="center" border="0" cellspacing="0" cellpading="0"> 
    <td>
    <TABLE align="center" border="0" class="TablaCaja" cellspacing="1" cellpading="0">
    <tr class="SubTituloCentro"><th colspan="3">Fechas y Horas de</th></tr>
    <tr class="SubTituloDerecha">
            <th>Denuncias</th><th>Hecho</th></tr>
    <tr class="Grid">
            <td>
                <input name="txtFechaDenuncia" type="text" id="txtFechaDenuncia" size="17" maxlength="16"                       
                   value="<?php if (isset($_SESSION['oDenuncia']))
                   { echo($oDenuncia->getFechaDenunciaFormato()); } ?>" required/> 
            </td>
            <td>
                <input name="txtFechaHecho" type="text" id="txtFechaHecho" size="17" maxlength="16"
                   value="<?php if (isset($_SESSION['oDenuncia']))
                   { echo($oDenuncia->getFechaHechoFormato()); } ?>"/>
            </td>              
    </tr>        
    </table>     
    </td>
</table>    
<br>
<table align="center" border="0" class="TablaCaja" cellspacing="1" cellpading="0" width="100%">
  <tbody>
    <tr class="SubTituloCentro"><th colspan="3"><strong>Denuncia tomada en</strong></th></tr>
    <tr class="SubTituloDerecha">
      <td>Departamento</td>
      <td>Municipio</td>
      <td>Recepcionada en</td>
    </tr>
    <tr class="Grid">
      <td>
          <input type="text" name="Departamento" id="Departamento" size="30"
                 value="<?php echo $objUsuario->getDeptoRecepcion(); ?>" readonly="readonly"/>
          <input type="hidden" name="cboDepto0" id="cboDepto0" size="1"
                 value="<?php echo $objUsuario->getDeptoRecepcionId() ?>"/>
      </td>
      <td id="tdMuni0">
          <input type="text" name="Municipio" id="Municipio" size="30"
                 value="<?php echo $objUsuario->getMuniRecepcion(); ?>" readonly="readonly"/>
          <input type="hidden" name="cboMuni0" id="cboMuni0" size="1"
                 value="<?php echo $objUsuario->getMuniRecepcionId() ?>"/>       
      </td>
      <td>
        <input type="text" name="txtRecepcion" id=txtRecepcion" size="30"
               value="<?php echo $objUsuario->getOficina(); ?>" readonly="readonly"/>
        <input type="hidden" name="cboRecepcion" id="cboRecepcion"
               value="<?php echo $objUsuario->getOficinaId(); ?>"/>
      </td>
    </tr>
  </tbody>
</table>

<br>
<br>
<table align="center" border="0" class="TablaCaja" width="100%">
  <tbody>
    <tr class="SubTituloCentro"><Th colspan="4"><strong>Lugar de los hechos</strong></Th></tr>
    <tr class="SubTituloDerecha">
      <td>Departamento</td>
      <td>Municipio</td>
      <td>Ciudad o Aldea</td>
      <td>Barrio</td>
    </tr>
    <tr class="Grid">
      <td>
	<?php 
		$resDepto2= CargarDepto();
		 combo("cboDepto2",$resDepto2,"cdepartamentoid","cdescripcion","",
                         "onchange='llena_muni(".'"cboDepto2"'.",".'"cboMuni2"'.","
                         .'"tdMuni2"'.",".'"12"'.",".'"cboAldea2"'.",".'"cboBarrio2"'
                         .")'");
	?>
      </td>
      <td id="tdMuni2">
	<?php
		combo("cboMuni2","","cmunicipioid","cdescripcion","",
                      "onchange='llena_aldea(".'"cboDepto2"'.",".'"cboMuni2"'.",
                      ".'"cboAldea2"'.",".'"tdAldea2"'.",".'"6"'.",".'"cboBarrio"'.")'");
	?>
      </td>
      <td id="tdAldea2">
	<?php
            combo("cboAldea2","","cbaldeaId","cdescripcion","","");
	?>
      </td>
      <td id="tdBarrio2">
	<?php
		combo("cboBarrio2","","cbarrioId","cdescripcion","","");
	?>
      </td>
    </tr>
    <tr>
      <td colspan="4"><br>Detalle de dirección: 
          <input type="text" name="txtDetalle" id="txtDetalle" maxlength="199" size="90">
          <script type="text/javascript">
              document.getElementById("txtDetalle").value= 
                  "<?php if (isset($_SESSION['oDenuncia']))
                       { echo($oDenuncia->getDetalleDireccion()); } ?>";
          </script>
      </td>
    </tr>
    <tr>
        <td colspan="4"><br>Clase de lugar de hechos: 
	<?php
                $lugar= CargarClaseLugar();
		combo("cboClaseLugar",$lugar,"nlugarid","cdescripcion","","");
	?>            
        </td>
    </tr>
  </tbody>
</table>

<br>
<br>
<table align="center" border="0" class="TablaCaja" cellspacing="1" cellpading="0" width="100%">
<TR class="SubTituloCentro"><Th><strong><div align="left">Narración de hecho</div></strong></Th></TR>
<tr class="SubTituloDerecha">
    <TD>
        <textarea cols="108" rows="6" id="hechos" name="hechos">
                  <?php if (isset($_SESSION['oDenuncia']))
                      { echo($oDenuncia->getNarracionHecho()); }
                      else
{?><?php } ?>
        </textarea>
    </TD>
</tr>
</table>
<br>
<table align="center">
  <tbody>
    <tr>
      <td><INPUT type="submit" name="btnSubmit" value="Guardar dato"></td>
      <td><INPUT type="reset" name="btnReset" value="Limpiar campos" onclick="alert(document.getElementById('hora').value);"></td>
    </tr>
  </tbody>
</table>
</FORM>
</body>
</html>

<script type="text/javascript">
LlenarFormulario();

//llena todos los combos de direccion
function LlenaDireccionHecho(depto, muni, aldea, barrio){  //depto, muni, aldea, barrio
//  alert(depto+","+muni+","+aldea+","+barrio);
    $.ajax({
        data:"accion=depto",
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_llenadireccion.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Departamento: "+quepaso);
        },
        success: function(data){
            $("#cboDepto2").html(data); //crea la lista de deptos
            $("#cboDepto2 option[value="+depto+"]").attr("selected",true);
//            $("#cboDepto2").attr("value",depto); //selecciona el depto
            //ajax para llenar el municipio
            $.ajax({
                data: "accion=muni&coddepto="+depto,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Municipio: "+quepaso);
                },
                success: function(data){
                    $("#cboMuni2").html(data);
                    $("#cboMuni2 option[value="+muni+"]").attr("selected",true);
//                    $("#cboMuni2").attr("value",muni);
                    //ajax para llenar la ciudad o aldea
                    $.ajax({                        
                        data: "accion=aldea&codmuni="+muni+"&coddepto="+depto+"&codaldea="+aldea,
                        type: "POST",
                        dataType: "html",
                        url: "../funciones/ajax_llenadireccion.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Aldea o Ciudad: "+quepaso);
                        },
                        success: function(data){
                            $("#cboAldea2").html(data);
                            $("#cboAldea2 option[value="+aldea+"]").attr("selected",true);
//                            $("#cboAldea2").attr("value",aldea);
                        }
                    })
                }
            })
        }
    })
    $.ajax({
        data: "accion=barrio&codmuni="+muni+"&coddepto="+depto+"&codaldea="+aldea+"&codbarrio="+barrio,
        type: "POST",
        dataType: "html",
        url: "../funciones/ajax_llenadireccion.php",
        error: function(objeto, quepaso, otroobj){
            alert("Error al cargar Barrio o Colonia");        
        },
        success: function(data){
            $("#cboBarrio2").html(data);
            $("#cboBarrio2 option[value="+barrio+"]").attr("selected",true);
//            $("#cboBarrio2").attr("value",barrio);            
        }
    })
}//de la funcin llena direccion

//llena clase lugar del hecho
document.getElementById("cboClaseLugar").value=
        "<?php
            if (isset($_SESSION['oDenuncia'])) { 
                echo($oDenuncia->getLugarHecho());                
            } 
        ?>";
</script>