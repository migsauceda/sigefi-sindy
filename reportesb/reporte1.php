<?php session_start();
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');
$denuncia=$_SESSION['denunciaid'];
//$usuario=$_SESSION['usr'];
$usuario=$_SESSION['usuario'];
$impresion;

$archivo="impresiones_denuncia/denuncia$denuncia".".txt";
/*$fp = fopen($archivo,"a+"); 
$impresion = fgets($fp, 30);
if ($impresion==""){
	fwrite($fp, -1, 30); 
}
fclose($fp); 

$fp = fopen($archivo,"r"); 
$impresion = fgets($fp, 30);
$impresion=$impresion+1;
fclose($fp);

$fp = fopen($archivo,"w"); 
fwrite($fp, $impresion, 30);
fclose($fp);*/

$conexion=new cls_conexion();
$conexion->conectar();
$resultado;
$resultadoDelitos;
$resultadosTemp;

$consulta="select tbl_denuncia.dfechadenuncia, tbl_denuncia.dfechahecho, tbl_denuncia.cdeptodenuncia, 
tbl_denuncia.cmunicipiodenuncia, tbl_denuncia.cdeptohecho, tbl_denuncia.cmunicipiohecho, 
tbl_denuncia.caldeahecho, tbl_denuncia.ccaseriohecho, tbl_denuncia.nlugarrecepcion, 
tbl_denuncia.cestadodenuncia, tbl_denuncia.cnarracionhecho, tbl_denuncia.cexpedientesedi, 
tbl_denuncia.cexpedientejudicial, tbl_denuncia.cdetalledireccionhecho, tbl_denuncia.tdenunciaid,
tbl_denuncia.cexpedientepolicial, tbl_denuncia.basignadafiscalia, tbl_denuncia.cdirecciondenuncia,
 tbl_denuncia.cdireccionhecho, tbl_denuncia.ccreada, tbl_denunciante.cdocumentoid as doc_denunciante, tbl_denunciante.cnombres as nomb_denunciante, tbl_denunciante.capellidos as apellidos_denunciante, tbl_denunciante.cgenero as gen_denunciante, tbl_denunciante.nprofesionid as prof_denunciante, tbl_denunciante.nocupacionid as ocupacion_denunciante, tbl_denunciante.nescolaridadid as esc_denunciante, tbl_denunciante.cnacionalidadid as nac_denunciante, tbl_denunciante.netniaid as etnia_denunciante, tbl_denunciante.ndiscapacidadid as discapacidad_denunciante, tbl_denunciante.iedad as edad_denunciante, tbl_denunciante.cunidadmedidaedad as unidad_medida_edad_denunciante, tbl_denunciante.crangoedad as rago_edad_denunciante, tbl_denunciante.cdepartamentoid as depto_denunciante, tbl_denunciante.cmunicipioid as municipio_denunciante, tbl_denunciante.caldeaid as aldea_denunciante, tbl_denunciante.cdetalle as detalle_denunciante, tbl_denunciante.cbarrioid as barrio_denunciante, tbl_denunciante.corientacionsexual as orientacion_sexual_denunciante, tbl_denunciante.cdireccion as direccion_denunciante, tbl_denunciante.nestadocivil as estado_civil_denunciante, tbl_denunciante.nconocido as conocido_denunciante, tbl_imputado.cdocumentoid as doc_imputado, tbl_imputado.cnombres as nomb_imputado, tbl_imputado.capellidos as apellidos_imputado, tbl_imputado.cgenero as gen_imputado, tbl_imputado.nprofesionid as prof_imputado, tbl_imputado.nocupacionid as ocupacion_imputado, tbl_imputado.nescolaridadid as esc_imputado, tbl_imputado.cnacionalidadid as nac_imputado, tbl_imputado.netniaid as etnia_imputado, tbl_imputado.ndiscapacidadid as discapacidad_imputado, 
tbl_imputado.iedad as edad_imputado, tbl_imputado.cunidadmedidaedad as 
unidad_medida_edad_imputado, tbl_imputado.crangoedad as rago_edad_imputado, 
tbl_imputado.cdepartamentoid as depto_imputado, tbl_imputado.cmunicipioid as 
municipio_imputado, tbl_imputado.caldeaid as aldea_imputado, tbl_imputado.cdetalle as 
detalle_imputado, tbl_imputado.cbarrioid as barrio_imputado, tbl_imputado.corientacionsexual as orientacion_sexual_imputado, tbl_imputado.cdireccion as direccion_imputado, tbl_imputado.nestadocivil as estado_civil_imputado, tbl_imputado.nfiscaliaid as 
fiscalia_imputado, tbl_imputado.nconocido as conocido_imputado, tbl_imputado.calias as 
alias_imputado, tbl_imputado.bmenorinfractor as menor_infractor_imputado, 
tbl_imputado.crepresentantelegalmenor as representante_legal_menor_imputado, 
tbl_ofendido.cdocumentoid as doc_ofendido, tbl_ofendido.cnombres as nomb_ofendido, 
tbl_ofendido.capellidos as apellidos_ofendido, tbl_ofendido.cgenero as gen_ofendido, 
tbl_ofendido.nprofesionid as prof_ofendido, tbl_ofendido.nocupacionid as ocupacion_ofendido, 
tbl_ofendido.nescolaridadid as esc_ofendido, tbl_ofendido.cnacionalidadid as nac_ofendido, 
tbl_ofendido.netniaid as etnia_ofendido, tbl_ofendido.ndiscapacidadid as discapacidad_ofendido, 
tbl_ofendido.iedad as edad_ofendido, tbl_ofendido.cunidadmedidaedad as 
unidad_medida_edad_ofendido, tbl_ofendido.crangoedad as rago_edad_ofendido, 
tbl_ofendido.cdepartamentoid as depto_ofendido, tbl_ofendido.cmunicipioid as 
municipio_ofendido, tbl_ofendido.caldeaid as aldea_ofendido, tbl_ofendido.cdetalle as 
detalle_ofendido, tbl_ofendido.cbarrioid as barrio_ofendido, 
tbl_ofendido.corientacionsexual as orientacion_sexual_ofendido, tbl_ofendido.cdireccion as 
direccion_ofendido, tbl_ofendido.nestadocivil as estado_civil_ofendido, 
tbl_ofendido.bvive as vive_ofendido, tbl_ofendido.nconocido as conocido_ofendido, 
tbl_ofendido.crepresentantelegal as representante_legal_ofendido, 
tbl_ofendido.cesmenor as menor_ofendido 
from tbl_denuncia inner join tbl_denunciante on 
tbl_denuncia.tdenunciaid=tbl_denunciante.tdenunciaid inner join tbl_imputado on 
tbl_denuncia.tdenunciaid=tbl_imputado.tdenunciaid inner join tbl_ofendido on 
tbl_denuncia.tdenunciaid=tbl_ofendido.tdenunciaid 
where tbl_denuncia.tdenunciaid='$denuncia'";

$resultado=$conexion->consultar($consulta);	
$resultado1=$conexion->consultar($consulta);
$resultado2=$conexion->consultar($consulta);
$resultado3=$conexion->consultar($consulta);

$resultadoDelitos=$conexion->consultar("select tbl_denuncia.tdenunciaid, tbl_delito.ndelitoid, tbl_delito.cdescripcion from tbl_denuncia inner join tbl_imputado_delito on 
tbl_denuncia.tdenunciaid=tbl_imputado_delito.tdenunciaid inner join
tbl_delito on tbl_imputado_delito.ndelito=tbl_delito.ndelitoid where tbl_denuncia.tdenunciaid='$denuncia'");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'DENUNCIA COMPLETA', 'Fecha: '.$fecha.'  Hora: '.$hora.'               Usuario: '.$usuario.'               Número de Impresión: '.$impresion);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9.5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins('5', '50', '5'); //margen izq, top y derecho
$pdf->SetHeaderMargin('15'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('10'); //configura el margen entre el pie de pag y fin de pag

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 10, '', true); //familia, estilo, tam, archivo fuente, fuente subconjunto

// Add a page
$pdf->AddPage();

// Set some content to print
if (pg_num_rows($resultado)>0){
	$html='Datos de la Denuncia<br><br>
			<table align="center" border="1">			
				<tr>
					<td width="10%">Denuncia</td>
					<td width="14%">Fecha Denuncia</td>
					<td width="14%">Fecha del Hecho</td>
					<td width="15.5%">Depto. Denuncia</td>
					<td width="15.5%">Municipio Denuncia</td>
					<td width="16%">Depto. del Hecho</td>
					<td width="15%">Municipio del Hecho</td>
				</tr>';
	$i=0;
	$row=pg_fetch_assoc($resultado);
	$html.="<tr>
				<td>$row[tdenunciaid]</td>
				<td>$row[dfechadenuncia]</td>
				<td>$row[dfechahecho]</td>";
				
	$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[cdeptodenuncia]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
	
	$resultadosTemp1=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[cmunicipiodenuncia]' and cdepartamentoid='$row[cdeptodenuncia]'");
	$rowTemp1=pg_fetch_assoc($resultadosTemp1);
				 
	$html.="	<td>$rowTemp[cdescripcion]</td>
				<td>$rowTemp1[cdescripcion]</td>";
	
	$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
				
	$html.="	<td>$rowTemp[cdescripcion]</td>";
	
	$resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[cmunicipiohecho]' and cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
	
	$html.="	<td>$rowTemp[cdescripcion]</td>
			</tr>";
	
	$html.='</table><br>';
	
	$html.='<table align="center" border="1">			
				<tr>
					<td width="15%">Aldea del Hecho</td>
					<td width="15%">Caserio del Hecho</td>
					<td width="13%">Lugar de Recepción</td>
					<td width="11%">Estado de Denuncia</td>
					<td width="32%">Narracion del Hecho</td>
					<td width="14%">Expediente Sedi</td>
				</tr>';
	
	$resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[caldeahecho]' and cmunicipioid='$row[cmunicipiohecho]' and cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
		
	$html.="<tr>
				<td>$rowTemp[cdescripcion]</td>
				<td>$row[ccaseriohecho]</td>";
	
	$resultadosTemp=$conexion->consultar("select * from tbl_lugarrecepcion where nlugarid='$row[nlugarrecepcion]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
	
	$html.="	<td>$rowTemp[cdescripcion]</td>
				<td>$row[cestadodenuncia]</td>
				<td>$row[cnarracionhecho]</td>
				<td>$row[cexpedientesedi]</td>
			</tr>";
				
	$html.='</table><br>';
	
	$html.='<table align="center" border="1">			
				<tr>
					<td>Expediente Judicial</td>
					<td>Detalle Dirección del Hecho</td>
					<td>Expediente Policial</td>
					<td>Asignada Fiscalía</td>
					<td>Dirección de la Denuncia</td>
					<td>Dirección del Hecho</td>
				</tr>';
				
	$html.="<tr>
				<td>$row[cexpedientejudicial]</td>
				<td>$row[cdetalledireccionhecho]</td>
				<td>$row[cexpedientepolicial]</td>";
	
	if ($row['basignadafiscalia']==true){
	$html.="	<td>Si</td>";
	}else{
	$html.="	<td>No</td>";
	}
	
	$html.="	<td>$row[cdirecciondenuncia]</td>
				<td>$row[cdireccionhecho]</td>
			</tr>";
			
	$html.='</table><br>';
	
	$html.='<table align="center" border="1">			
				<tr>
					<td width="15%">Creada</td>
				</tr>';
	
	$html.="<tr>
				<td>$row[ccreada]</td>
			</tr>";
	
	$html.='</table><br><br>';

	$html.='Datos Denunciante(s)<br><br>';
	

        
	$resultado=$resultado1;
	while ($row=pg_fetch_assoc($resultado)){
		$html.='<table align="center" border="1">
					<tr>
						<td>Documento</td>
						<td>Nombre Completo</td>
						<td>Género</td>
						<td>Profesión</td>
						<td>Ocupación</td>
					</tr>';
		
		$html.="<tr>
					<td>$row[doc_denunciante]</td>
					<td>$row[nomb_denunciante] $row[apellidos_denunciante]</td>";
					
		if ($row['gen_denunciante']=="m"){
		$html.="	<td>Masculino</td>";
		}else{
		$html.="	<td>Femenino</td>";
		}
		
		$resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['prof_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['ocupacion_denunciante']=$rowTemp['cdescripcion'];
		
		$html.="	<td>$row[prof_denunciante]</td>
					<td>$row[ocupacion_denunciante]</td>
				</tr>";
		
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Escolaridad</td>
						<td>Nacionalidad</td>
						<td>Etnia</td>
						<td>Discapacidad</td>
						<td>Edad</td>
						<td>Unidad Medida Edad</td>
					</tr>';
		
		$resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where nescolaridadid='$row[esc_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['esc_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where cnacionalidadid='$row[nac_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['nac_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_etnia where netniaid='$row[etnia_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['etnia_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where ndiscapacidadid='$row[discapacidad_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['discapacidad_denunciante']=$rowTemp['cdescripcion'];
		
		$html.="<tr>
					<td>$row[esc_denunciante]</td>
					<td>$row[nac_denunciante]</td>
					<td>$row[etnia_denunciante]</td>
					<td>$row[discapacidad_denunciante]</td>
					<td>$row[edad_denunciante]</td>
					<td>$row[unidad_medida_edad_denunciante]</td>
				</tr>";
		
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td width="10%">Rango Edad</td>
						<td width="18%">Departamento</td>
						<td width="18%">Municipio</td>
						<td width="18%">Aldea</td>
						<td width="18%">Detalle</td>
						<td width="18%">Barrio</td>
					</tr>';
		
		$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[depto_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$deptoid=$row['depto_denunciante'];
		$row['depto_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[municipio_denunciante]' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$municipioid=$row['municipio_denunciante'];
		$row['municipio_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[aldea_denunciante]' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$aldeaid=$row['aldea_denunciante'];
		$row['aldea_denunciante']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_barrio where cbarrioid='$row[barrio_denunciante]' and caldeaid='$aldeaid' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['barrio_denunciante']=$rowTemp['cdescripcion'];
		
		$html.="<tr>
					<td>$row[rago_edad_denunciante]</td>
					<td>$row[depto_denunciante]</td>
					<td>$row[municipio_denunciante]</td>
					<td>$row[aldea_denunciante]</td>
					<td>$row[detalle_denunciante]</td>
					<td>$row[barrio_denunciante]</td>
				</tr>";
		
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Orientación Sexual</td>
						<td>Dirección</td>
						<td>Estado Civil</td>
						<td>Conocido</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where ncivil='$row[estado_civil_denunciante]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['estado_civil_denunciante']=$rowTemp['cdescripcion'];
					
		$html.="<tr>
					<td>$row[orientacion_sexual_denunciante]</td>
					<td>$row[direccion_denunciante]</td>
					<td>$row[estado_civil_denunciante]</td>";
					
		if ($row['conocido_denunciante']==true){
		$html.="	<td>Si</td>";
		}else{
		$html.="	<td>No</td>";
		}
		
		$html.="</tr>";
					
		$html.='</table><br><br>';
	}
	
	$resultado=$resultado2;			
	$html.='Datos Imputado(s)<br><br>';
	
	while ($row=pg_fetch_assoc($resultado)){
		$html.='<table align="center" border="1">
					<tr>
						<td>Documento del Imputado</td>
						<td>Nombre Completo</td>
						<td>Género</td>
						<td>Profesión</td>
						<td>Ocupación</td>
						<td>Escolaridad</td>
					</tr>';
		
		$html.="<tr>
					<td>$row[doc_imputado]</td>
					<td>$row[nomb_imputado] $row[apellidos_imputado]</td>";
		
		if ($row['gen_imputado']=="m"){
		$html.="	<td>Masculino</td>";
		}else{
		$html.="	<td>Femenino</td>";
		}
					
		$resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['prof_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['ocupacion_imputado']=$rowTemp['cdescripcion'];
				
		$resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where 
		nescolaridadid='$row[esc_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['esc_imputado']=$rowTemp['cdescripcion'];
				
		$html.="	<td>$row[prof_imputado]</td>
					<td>$row[ocupacion_imputado]</td>
					<td>$row[esc_imputado]</td>
				</tr>";
		
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Nacionalidad</td>
						<td>Etnia</td>
						<td>Discapacidad</td>
						<td>Edad</td>
						<td>Unidad Medida Edad</td>
						<td>Rango Edad</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where 
		cnacionalidadid='$row[nac_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['nac_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_etnia where 
		netniaid='$row[etnia_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['etnia_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where 
		ndiscapacidadid='$row[discapacidad_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['discapacidad_imputado']=$rowTemp['cdescripcion'];
					
		$html.="<tr>
					<td>$row[nac_imputado]</td>
					<td>$row[etnia_imputado]</td>
					<td>$row[discapacidad_imputado]</td>
					<td>$row[edad_imputado]</td>
					<td>$row[unidad_medida_edad_imputado]</td>
					<td>$row[rago_edad_imputado]</td>
				</tr>";
					
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Departamento</td>
						<td>Municipio</td>
						<td>Aldea</td>
						<td>Detalle</td>
						<td>Barrio</td>
						<td>Orientación Sexual</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[depto_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$deptoid=$row['depto_imputado'];
		$row['depto_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_municipio where 
		cmunicipioid='$row[municipio_imputado]' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$municipioid=$row['municipio_imputado'];
		$row['municipio_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_aldea where
		caldeaid='$row[aldea_imputado]' and cmunicipioid='$municipioid' and
		 cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$aldeaid=$row['aldea_imputado'];
		$row['aldea_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_barrio where 
		cbarrioid='$row[barrio_imputado]' and caldeaid='$aldeaid' and 
		cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['barrio_imputado']=$rowTemp['cdescripcion'];
					
		$html.="<tr>
					<td>$row[depto_imputado]</td>
					<td>$row[municipio_imputado]</td>
					<td>$row[aldea_imputado]</td>
					<td>$row[detalle_imputado]</td>
					<td>$row[barrio_imputado]</td>
					<td>$row[orientacion_sexual_imputado]</td>
				</tr>";
					
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Dirección</td>
						<td>Estado Civil</td>
						<td>Fiscalía</td>
						<td>Conocido</td>
						<td>Alias</td>
						<td>Menor Infractor</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where 
		ncivil='$row[estado_civil_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['estado_civil_imputado']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_fiscalia where 
		nfiscaliaid='$row[fiscalia_imputado]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['fiscalia_imputado']=$rowTemp['cdescripcion'];
		
		if ($row['conocido_imputado']==true){
			$row['conocido_imputado']="Si";
		}else{
			$row['conocido_imputado']="No";
		}
		
		if ($row['menor_infractor_imputado']==true){
			$row['menor_infractor_imputado']="Si";
		}else{
			$row['menor_infractor_imputado']="No";
		}
					
		$html.="<tr>
					<td>$row[direccion_imputado]</td>
					<td>$row[estado_civil_imputado]</td>
					<td>$row[fiscalia_imputado]</td>
					<td>$row[conocido_imputado]</td>
					<td>$row[alias_imputado]</td>
					<td>$row[menor_infractor_imputado]</td>
				</tr>";
					
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td width="25%">Representante Legal Menor</td>
					</tr>';
					
		$html.="<tr>
					<td>$row[representante_legal_menor_imputado]</td>
				</tr>";
					
		$html.='</table><br><br>';
	}
	
	$resultado=$resultado3;
	$html.='Datos Ofendido(s)<br><br>';
	
	while ($row=pg_fetch_assoc($resultado)){
		$html.='<table align="center" border="1">			
					<tr>
						<td>Documento</td>
						<td>Nombre Completo</td>
						<td>Género</td>
						<td>Profesión</td>
						<td>Ocupación</td>
						<td>Escolaridad</td>
					</tr>';
					
		$html.="<tr>
					<td>$row[doc_ofendido]</td>
					<td>$row[nomb_ofendido] $row[apellidos_ofendido]</td>";
		
		if ($row['gen_ofendido']=="m"){
		$html.="	<td>Masculino</td>";
		}else{
		$html.="	<td>Femenino</td>";
		}
					
		$resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['prof_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['ocupacion_ofendido']=$rowTemp['cdescripcion'];
				
		$resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where 
		nescolaridadid='$row[esc_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['esc_ofendido']=$rowTemp['cdescripcion'];
					
		$html.="	<td>$row[prof_ofendido]</td>
					<td>$row[ocupacion_ofendido]</td>
					<td>$row[esc_ofendido]</td>
				</tr>";
					
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Nacionalidad</td>
						<td>Etnia</td>
						<td>Discapacidad</td>
						<td>Edad</td>
						<td>Unidad Medida Edad</td>
						<td>Rango Edad</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where 
		cnacionalidadid='$row[nac_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['nac_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_etnia where 
		netniaid='$row[etnia_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['etnia_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where 
		ndiscapacidadid='$row[discapacidad_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['discapacidad_ofendido']=$rowTemp['cdescripcion'];
					
		$html.="<tr>
					<td>$row[nac_ofendido]</td>
					<td>$row[etnia_ofendido]</td>
					<td>$row[discapacidad_ofendido]</td>
					<td>$row[edad_ofendido]</td>
					<td>$row[unidad_medida_edad_ofendido]</td>
					<td>$row[rago_edad_ofendido]</td>
				</tr>";
					
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Departamento</td>
						<td>Municipio</td>
						<td>Aldea</td>
						<td>Detalle</td>
						<td>Barrio</td>
						<td>Orientación Sexual</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais 
		where cdepartamentoid='$row[depto_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$deptoid=$row['depto_ofendido'];
		$row['depto_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_municipio where 
		cmunicipioid='$row[municipio_ofendido]' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$municipioid=$row['municipio_ofendido'];
		$row['municipio_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_aldea where 
		caldeaid='$row[aldea_ofendido]' and cmunicipioid='$municipioid' and 
		cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$aldeaid=$row['aldea_ofendido'];
		$row['aldea_ofendido']=$rowTemp['cdescripcion'];
		
		$resultadosTemp=$conexion->consultar("select * from tbl_barrio where 
		cbarrioid='$row[barrio_ofendido]' and caldeaid='$aldeaid' and 
		cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['barrio_ofendido']=$rowTemp['cdescripcion'];
					
		$html.="<tr>
					<td>$row[depto_ofendido]</td>
					<td>$row[municipio_ofendido]</td>
					<td>$row[aldea_ofendido]</td>
					<td>$row[detalle_ofendido]</td>
					<td>$row[barrio_ofendido]</td>
					<td>$row[orientacion_sexual_ofendido]</td>
				</tr>";		
			
		$html.='</table><br>';
		
		$html.='<table align="center" border="1">			
					<tr>
						<td>Dirección</td>
						<td>Estado Civil</td>
						<td>Aún Vive</td>
						<td>Conocido</td>
						<td>Representante Legal</td>
						<td>Es Menor</td>
					</tr>';
					
		$resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where 
		ncivil='$row[estado_civil_ofendido]'");
		$rowTemp=pg_fetch_assoc($resultadosTemp);
		$row['estado_civil_ofendido']=$rowTemp['cdescripcion'];
		
		if ($row['vive_ofendido']==true){
			$row['vive_ofendido']="Si";
		}else{
			$row['vive_ofendido']="No";
		}
		
		if ($row['conocido_ofendido']==true){
			$row['conocido_ofendido']="Si";
		}else{
			$row['conocido_ofendido']="No";
		}
					
		$html.="<tr>
					<td>$row[direccion_ofendido]</td>
					<td>$row[estado_civil_ofendido]</td>
					<td>$row[vive_ofendido]</td>
					<td>$row[conocido_ofendido]</td>
					<td>$row[representante_legal_ofendido]</td>
					<td>$row[menor_ofendido]</td>
				</tr>";		
					
		$html.='</table><br><br>';
	}
	
	$html.='Datos del Delito<br><br>
			<table align="center" border="1">			
				<tr>
					<td width="15%">Delito</td>
					<td width="30%">Descripción del Delito</td>
				</tr>';
				
	while($rowDelitos=pg_fetch_assoc($resultadoDelitos)){
		$html.="<tr>
				<td>$rowDelitos[ndelitoid]</td>
				<td>$rowDelitos[cdescripcion]</td>
			</tr>";	
	}
				
	$html.='</table><br>';
}

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Denuncia '.$denuncia.' Completa.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+