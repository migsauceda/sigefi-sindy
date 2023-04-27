<?php
    include("clases/Usuario.php");
//    include "funciones/php_funciones.php";

    session_start();

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }
?>

<html>
<head>
    <TITLE></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="pro_drop_1/pro_drop_1.css" />

<script src="pro_drop_1/stuHover.js" type="text/javascript"></script>
<script type="text/javascript" src="./funciones/funciones.js"></script>

<link href="./java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script src="./java_script/js/jquery-1.10.2.js"></script>
<script src="./java_script/js/jquery-ui-1.10.4.custom.js"></script>

<style type="text/css">
    html {
        height: auto;
    }

    body {
        height: auto;
        margin: 0px;
        padding: 0px;
    }

    .contenedor {
        position: relative;
        width: 1200px;
        /*height:1800px;*/
        padding-bottom: 177%;
        overflow: hidden;
    }

    .contenedor iframe {
        position: absolute;
        top:0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<script type="text/javascript">
function EvaluarEstado(){
//    event.returnValue= false;
    alert("prueba 55");
    $.ajax({
        data: "dato=permiso",
        type: "GET",
        dataType: "text",
        url: "./funciones/ajax_permisos.php",
        error: function(){
            alert("Error al validar los permisos");
        },
        success: function(data){
            Permiso= data;

            if (Permiso!= "Receptor"){
//                alert("No tiene el perfil de Receptor de Denuncias");
                return false;
            }
            else //ajax para validar estados
            {
                $.ajax({
                    data: "dato=estado",
                    type: "GET",
                    dataType: "text",
                    url: "./funciones/ajax_estado_denuncia.php",
                    error: function(){
                        alert("Error al recuperar estado de la denuncia: ");
                    },
                    success: function(data){
                        Estado= data;

                        if (Estado== "Completando"){
                            CrearNueva= confirm("Desea crear una nueva denuncia perdiendo los datos no guardados.");
                            if (CrearNueva)
                                //iniciar nueva denuncia perdiendo la actual, no cambia de estado
//                                frames['destino'].location.href='./denuncia/frmExpediente.php?CambiarEstado=NUEVA';

                                frames['destino'].location.href='./denuncia/frmConvertirEntrevista.php?CambiarEstado=NUEVA';
                            else{
                                //alert("Se continuará con la denuncia actual");
                                alert("93");
                                frames['destino'].location.href= "./denuncia/frmExpediente.php";
                            }
                        }
                        else{
                            //se esta en estado de espera y se inicia una nueva denuncia,
                            //cambia de estado: de espera a completando
//                            frames['destino'].location.href='./denuncia/frmExpediente.php?CambiarEstado=SI';
            alert('banner 100')                ;
            frames['destino'].location.href='./denuncia/frmConvertirEntrevista.php';
                        }
                    }//success
                }); //ajax
            }
        }
    });//ajax para validar entrada
}
</script>

<script type="text/javascript">
function Recargar(){
    //alert("<?php echo $objUsuario->getIp(); ?>");
    Estado= "<?php echo $_SESSION['estado']; ?>";

    if(Estado== 'Completando'){
        Accion= "<?php if(isset($_SESSION['accion'])){ echo $_SESSION['accion'];} else {0;}?>";
        if (Accion== 1)
        {
//            frames['destino'].location.href='./frmExpediente.php?CambiarEstado=NO';
        frames['destino'].location.href='./denuncia/frmExpediente.php?CambiarEstado=NO';
        }
    }
}
</script>

</head>
<body onload="Recargar();">
<!-- solo para el logo -->
<table align="center" border="0">
  <tbody>
    <tr align="center">
      <TD></TD>
      <TD><IMG src="imagenes/LogoMPSI2.png" alt="LogoMP" width="260" height="90" align="middle" border="0"></TD>
      <td width="160"></td>
      <td><h1>SISTEMA DE EXPEDIENTES</h1></td>
    </tr>
  </tbody>
</table>

<!-- el menu en si -->
<table align="center" border="0">
    <tbody>
    <!-- nombre de usuario y ubcacion -->
    <tr>
        <br>
        <td><b>Usuario: </b><?php echo($objUsuario->getUsuario());?></td>
        <td colspan="2"><b>Ubicación: </b><?php echo($objUsuario->getOficina());?></td>
        <td><b>Rol: </b><?php echo($objUsuario->getRol());?></td>
    </tr>
    <tr>
        <td><b>Expediente actual:</b>Ninguno</tr>
    </tr>

    <!--menu colgante-->
    <tr>
	<TD colspan="5" align="center">
            <div class="menu" style="z-index: 2;" align="center">
            <span class="preload1"></span>
            <span class="preload2"></span>

            <ul id="nav">
                    <li class="top"><a href="busqueda.php" target="destino" id="inicio" class="top_link"><span>Búsqueda</span></a></li>
                    <li class="top"><a href="#nogo2" id="recepcion" class="top_link"><span class="down">Recepción de denuncias</span></a>
                            <ul class="sub">
                                    <li><a href="#nogo3" class="fly">Denuncia</a>
                                                    <ul>
                                                            <!--<li><a href="denuncia/frmExpediente.php" target="destino" onclick="EvaluarEstado();">Crear nueva</a></li>-->
                                                            <li><a href="denuncia/frmConvertirEntrevista.php" target="destino">Crear nueva</a></li>
							    <li><a href="Ministerio_PublicoJQCambios/principal.php" target="destino">Entrevista previa</a></li>
                                                            <li><a href="reportes/rptRemisionInterfaz.php" target="destino">Control de entregas</a></li>
                                                            <li><a href="reportes/denuncia_pdf.php" target="destino">Imprimir</a></li>
                                                            <li><a href="indicador_12/modulo_indicador_12.php" target="destino">Ingresar opinion de los usuarios</a></li>
                                                    </ul>
                                    </li>
                                    <li class="mid"><a href="#nogo6" class="fly">Administrar</a>
                                                    <ul>
                                        <li><a href="actividad/BandejaContenido.php" target="destino">Asignar a fiscalía</a></li>
					<li><a href="reportes/Reportefechas.php" target= "destino">Reporte Usuario MRD</a></li>	

                                                            <li><a href="#nogo9">Eliminar</a></li>
							
                                                    </ul>
                                    </li>
                            </ul>
                    </li>
                    <li class="top"><a href="#nogo10" id="fiscalia" class="top_link"><span class="down">Fiscalías</span></a>
                            <ul class="sub">
                                    <li><a href="actividad/actividadb.php" target="destino">Diligencias</a></li>
                                    <li><a href="denuncia/frmExpediente.php" target="destino">Modificar expediente</a></li>
                                    <li><a href="actividad/BandejaFiscalia.php" target="destino">Asignar fiscal</a></li>
                                    <li><a href="actividad/RotarFiscal.php" target="destino">Rotar expediente</a></li>
                            </ul>
                    </li>
                    <li class="top"><a href="#nogo14" id="reportes" class="top_link"><span class="down">Reportes</span></a>
                            <ul class="sub">
					<li><a href="Ministerio_PublicoJQCambios/index.php" target="destino">Reportes</a></li>
					<li><a href="reportes/menu.php" target="destino">Buscar denuncia</a></li>
					     <?php if($objUsuario->getRolId() ==16){ //jefe de seccion?>
						 <li><a href="reporteria/reporte_jefe_seccion.php" target="destino">Reporte Jefe Sección</a></li>
					      <?php }else if($objUsuario->getRolId() ==4 || $objUsuario->getRolId() ==5){ //director de fiscales y fiscal general?>
						<li><a href="reporteria/reporte_gerencia_bandejas.php" target="destino">Reporte Gerencia</a></li>
					    <?php }else if($objUsuario->getRolId() ==3){ //jefe de fiscalia?>
						 <li><a href="reporteria/reporte_carga_individual.php" target="destino">Reporte Carga Individual</a></li>
						 <li><a href="reporteria/reporte_jefe_fiscalia.php" target="destino">Reporte Jefe de Fiscalía</a></li>
						 <li><a href="reportes/ExpedientesActualizados.php" target="destino">Actualizados</a></li>
						 <li><a href="reportes/ExpedientesNoActualizados.php" target="destino">No actualizados</a></li>
					    <?php }else if ($objUsuario->getRolId() ==2){ //fiscal de primera linea?>
					      <li><a href="reporteria/reporte_carga_individual.php" target="destino">Reporte Carga Individual</a></li>
					    <?php } ?>

                                        <!--<li><a href="reportes/rpt_Gerencialesfrm.php" target="destino">Gerenciales</a></li>
                                        <li><a href="reportes/rpt_Fiscalfrm.php" target="destino">Fiscales</a></li>-->
<!--                                    <li><a href="reportes/rpt_ExpedienteFiscal.php" target="destino">Expedientes asignados</a></li>-->
                                    <!--<li><a href="reportes/con_reporte6b.php" target="destino">Actividad fiscal</a></li>-->
                            </ul>

                    </li>
                    <li class="top"><a href="#nogo53" id="estadisticas" class="top_link"><span class="down">Estadísticas</span></a>
                            <ul class="sub">
			<li><a href="reportes/Reporteimp.php" target="destino">Imputado Fiscalia Delito</a></li>
			<li><a href="reportes/Reporteofendido.php" target="destino">Ofendido Fiscalia Delito</a></li>
			<li><a href="reportes/Rimpocu.php" target="destino">Imputado Ocupacion, Profesion </a></li>
			<li><a href="reportes/Rofeocu.php" target="destino">Ofendido Ocupacion, Profesion </a></li>
			<li><a href="reportes/Rdepto.php" target="destino">Depto,Municipio del Imputado</a></li>
			<li><a href="reportes/Rdeptofe.php" target="destino">Depto,Municipio del Ofendido </a></li>
			<li><a href="reportes/RDepartamentos.php" target="destino">General por Depto y Municipio</a></li>
			<li><a href="reportes/vaciadoprimer.php" target="destino">General 1</a></li>
			<li><a href="reportes/Consultas/menu.php" target="destino">DIPEGEC</a></li>
                        <li><a href="http://172.17.0.254:8080" target="_blank">Indicadores</a></li>
		
<!--                                    <li><a href="reportes/observatoriofrm.php" target="destino">Observatorio</a></li>
                                    <li><a href="reportes/con_hojacontroldiario.php" target="destino">Control diario</a></li>
                                    <li><a href="reportes/con_reporte2.php" target="destino">Lugar de recepción</a></li>
                                    <li><a href="reportes/con_reporte3.php" target="destino">Usuario</a></li>
                                    <li><a href="reportes/con_reporte4.php" target="destino">Fiscal</a></li>
                                    <li><a href="reportes/con_reporte5.php" target="destino">Asignadas por fiscal</a></li>
                                    <li><a href="reportes/con_reporte7.php" target="destino">Expediente completo</a></li>
                                    <li><a href="reportes/frecuencias_delito.php" target="destino">Frecuencias de delitos</a></li>
                                    <li><a href="reportes/frecuencias_alcaldia1.php" target="destino">Formularios</a></li>-->
                            </ul>
                    </li>
                    <li class="top"><a href="#nogo57" id="admon" class="top_link"><span>Administración de usuarios</span></a>
                            <ul class="sub">
                                <li><a href="./administracion/CambiarClave.php" target="destino">Cambiar mi clave</a></li>
                                <!--<li><a href="./administracion/AdmonUsr.php" target="destino">Crear usuario</a></li>-->
                            </ul>
                    </li>

                    <li class="top"><a href="#nogo57" id="admon" class="top_link"><span>Agenda Fiscal</span></a>
                           <ul class="sub">
                              
                              <?php
                              if ($objUsuario->getRolId()==2)
                              {
                              ?>
                                  <li><a href="agenda/alarmas.php" target="destino">Agenda</a></li>
                                <?php
                              }

                              elseif ($objUsuario->getRolId()==3)
                              {
                              ?>
                                  <li><a href="agenda/busqueda_fiscalia.php" target="destino">Agenda</a></li>
                                <?php
                              }

                              elseif ($objUsuario->getRolId()==16)
                              {
                              ?>
                                  <li><a href="agenda/busqueda_fiscal2.php" target="destino">Agenda</a></li>
                                <?php
                              }
                              else
                                {}
                                ?>

                            </ul>
                    </li>



                    <li class="top"><a href="logout.php" id="salir" class="top_link"><span class="down">Salir</span></a>
                    </li>
            </ul>
            </div>
	</TD>
    </tr>
  </tbody>
</table>

<center>
<div class="contenedor" >
<iframe src="about:blank" id="destino" name="destino" width="1220" height="5000" scrolling="auto" frameborder="0">
</iframe>
</div>
</center>
</body>
</html>
 <!--width="1220" height="100%"-->
 <!--marginwidth="0" marginheight="0" frameborder="0" align="center" scrolling="yes"-->
