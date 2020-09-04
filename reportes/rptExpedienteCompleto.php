<?php
session_start(); 
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');

$usuario=$_SESSION['usuario'];

if (isset($_GET['denunciaprn'])){
    $denuncia= $_GET['denunciaprn'];
}

$conexion=new cls_conexion();
$conexion->conectar();

$sqlGenerales= "SELECT
DISTINCT mini_sedi.tbl_denuncia.tdenunciaid,
depto_den.cdescripcion AS depto_den,
muni_den.cdescripcion AS muni_den,
depto_hecho.cdescripcion AS depto_hecho,
muni_hecho.cdescripcion AS muni_hecho,
aldea_hecho.cdescripcion AS aldea_muni,
barrio_hecho.cdescripcion AS barrio_hecho,
mini_sedi.tbl_denuncia.cdetalledireccionhecho,
mini_sedi.tbl_denuncia.dfechadenuncia,
mini_sedi.tbl_denuncia.thoradenuncia,
mini_sedi.tbl_denuncia.dfechahecho,
mini_sedi.tbl_denuncia.thorahecho,
mini_sedi.tbl_clase_lugar_hecho.cdescripcion AS clase_lugar_hecho,
mini_sedi.tbl_denuncia.cexpedientepolicial,
mini_sedi.tbl_denuncia.cexpedientejudicial,
mini_sedi.tbl_denuncia.clevantamiento,
mini_sedi.tbl_denuncia.ctransito,
mini_sedi.tbl_denuncia.cautopsia,
mini_sedi.tbl_usuarios.nombres,
mini_sedi.tbl_usuarios.apellidos,
mini_sedi.tbl_denuncia.cnarracionhecho,
mini_sedi.tbl_denuncia.cmunicipiohecho
FROM
mini_sedi.tbl_denuncia
INNER JOIN mini_sedi.tbl_departamentopais AS depto_den ON mini_sedi.tbl_denuncia.cdeptodenuncia = depto_den.cdepartamentoid AND mini_sedi.tbl_denuncia.cdeptohecho = depto_den.cdepartamentoid
INNER JOIN mini_sedi.tbl_municipio AS muni_den ON muni_den.cdepartamentoid = depto_den.cdepartamentoid AND mini_sedi.tbl_denuncia.cmunicipiohecho = muni_den.cmunicipioid AND mini_sedi.tbl_denuncia.cmunicipiodenuncia = muni_den.cmunicipioid
INNER JOIN mini_sedi.tbl_departamentopais AS depto_hecho ON mini_sedi.tbl_denuncia.cdeptohecho = depto_hecho.cdepartamentoid
INNER JOIN mini_sedi.tbl_municipio AS muni_hecho ON mini_sedi.tbl_denuncia.cdeptohecho = muni_hecho.cdepartamentoid AND mini_sedi.tbl_denuncia.cmunicipiohecho = muni_hecho.cmunicipioid
INNER JOIN mini_sedi.tbl_aldea AS aldea_hecho ON mini_sedi.tbl_denuncia.cdeptohecho = aldea_hecho.cdepartamentoid AND mini_sedi.tbl_denuncia.cmunicipiohecho = aldea_hecho.cmunicipioid AND mini_sedi.tbl_denuncia.caldeahecho = aldea_hecho.caldeaid
INNER JOIN mini_sedi.tbl_barrio AS barrio_hecho ON mini_sedi.tbl_denuncia.cdeptohecho = barrio_hecho.cdepartamentoid AND mini_sedi.tbl_denuncia.cmunicipiohecho = barrio_hecho.cmunicipioid AND mini_sedi.tbl_denuncia.caldeahecho = barrio_hecho.caldeaid AND mini_sedi.tbl_denuncia.ccaseriohecho = barrio_hecho.cbarrioid
INNER JOIN mini_sedi.tbl_clase_lugar_hecho ON mini_sedi.tbl_denuncia.nlugarid = mini_sedi.tbl_clase_lugar_hecho.nlugarid
INNER JOIN mini_sedi.tbl_imputado_fiscal ON mini_sedi.tbl_imputado_fiscal.tdenunciaid = mini_sedi.tbl_denuncia.tdenunciaid
INNER JOIN mini_sedi.tbl_usuarios ON mini_sedi.tbl_imputado_fiscal.cfiscal = mini_sedi.tbl_usuarios.identidad
WHERE
mini_sedi.tbl_denuncia.tdenunciaid = '$denuncia' AND
mini_sedi.tbl_imputado_fiscal.bactivo = true
";

$sqlDenunciado= "SELECT
	mini_sedi.tbl_imputado.cnombres,
	mini_sedi.tbl_imputado.capellidos,
	mini_sedi.tbl_tipodocumento.cdescripcion,
	mini_sedi.tbl_imputado.cdocumentoid,
	mini_sedi.tbl_imputado.cgenero,
	mini_sedi.tbl_imputado.csexo,
	mini_sedi.tbl_imputado.iedad,
	mini_sedi.tbl_imputado.cunidadmedidaedad,
	mini_sedi.tbl_estadoscivil.cdescripcion AS estado_civil,
	mini_sedi.tbl_etnia.cdescripcion AS etnia,
	mini_sedi.tbl_discapacidad.cdescripcion AS discapacidad,
	mini_sedi.tbl_ocupacion.cdescripcion AS ocupacion,
	mini_sedi.tbl_profesion.cdescripcion AS porfesion,
	mini_sedi.tbl_nacionalidad.cdescripcion AS nacionalidad,
	mini_sedi.tbl_departamentopais.cdescripcion AS depto,
	mini_sedi.tbl_municipio.cdescripcion AS muni,
	mini_sedi.tbl_aldea.cdescripcion AS ciudad_aldea,
	mini_sedi.tbl_barrio.cdescripcion AS barrio,
	mini_sedi.tbl_imputado.cdetalle AS detalle_dir,
	mini_sedi.tbl_imputado.ctelefono AS telef,
	mini_sedi.tbl_imputado.aplicalgbti AS lgbti,
	mini_sedi.tbl_usuarios.nombres AS fiscal_nom,
	mini_sedi.tbl_usuarios.apellidos AS fiscal_ape,
	mini_sedi.tbl_imputado_fiscal.bactivo AS fisc_activo,
	mini_sedi.tbl_imputado_fiscal.dfechaasignacion AS asignado_fiscal,
	mini_sedi.tbl_bandejas.cdescripcion AS bandeja
FROM
	mini_sedi.tbl_imputado
INNER JOIN mini_sedi.tbl_tipodocumento ON mini_sedi.tbl_imputado.ntipodocumento = mini_sedi.tbl_tipodocumento.ndocumentoid
INNER JOIN mini_sedi.tbl_estadoscivil ON mini_sedi.tbl_imputado.nestadocivil = mini_sedi.tbl_estadoscivil.ncivil
INNER JOIN mini_sedi.tbl_etnia ON mini_sedi.tbl_imputado.netniaid = mini_sedi.tbl_etnia.netniaid
INNER JOIN mini_sedi.tbl_discapacidad ON mini_sedi.tbl_imputado.ndiscapacidadid = mini_sedi.tbl_discapacidad.ndiscapacidadid
INNER JOIN mini_sedi.tbl_nacionalidad ON mini_sedi.tbl_imputado.cnacionalidadid = mini_sedi.tbl_nacionalidad.cnacionalidadid
INNER JOIN mini_sedi.tbl_ocupacion ON mini_sedi.tbl_imputado.nocupacionid = mini_sedi.tbl_ocupacion.nocupacionid
INNER JOIN mini_sedi.tbl_profesion ON mini_sedi.tbl_imputado.nprofesionid = mini_sedi.tbl_profesion.nprofesionid
INNER JOIN mini_sedi.tbl_departamentopais ON mini_sedi.tbl_imputado.cdepartamentoid = mini_sedi.tbl_departamentopais.cdepartamentoid
INNER JOIN mini_sedi.tbl_municipio ON mini_sedi.tbl_imputado.cdepartamentoid = mini_sedi.tbl_municipio.cdepartamentoid
AND mini_sedi.tbl_imputado.cmunicipioid = mini_sedi.tbl_municipio.cmunicipioid
INNER JOIN mini_sedi.tbl_aldea ON mini_sedi.tbl_imputado.cdepartamentoid = mini_sedi.tbl_aldea.cdepartamentoid
AND mini_sedi.tbl_imputado.cmunicipioid = mini_sedi.tbl_aldea.cmunicipioid
AND mini_sedi.tbl_imputado.caldeaid = mini_sedi.tbl_aldea.caldeaid
INNER JOIN mini_sedi.tbl_barrio ON mini_sedi.tbl_imputado.cdepartamentoid = mini_sedi.tbl_barrio.cdepartamentoid
AND mini_sedi.tbl_imputado.cmunicipioid = mini_sedi.tbl_barrio.cmunicipioid
AND mini_sedi.tbl_imputado.caldeaid = mini_sedi.tbl_barrio.caldeaid
AND mini_sedi.tbl_imputado.cbarrioid = mini_sedi.tbl_barrio.cbarrioid
INNER JOIN mini_sedi.tbl_imputado_fiscal ON mini_sedi.tbl_imputado_fiscal.timputadoid = mini_sedi.tbl_imputado.tpersonaid
INNER JOIN mini_sedi.tbl_usuarios ON mini_sedi.tbl_usuarios.identidad = mini_sedi.tbl_imputado_fiscal.cfiscal
INNER JOIN mini_sedi.tbl_imputado_fiscalia ON mini_sedi.tbl_imputado_fiscalia.timputadoid = mini_sedi.tbl_imputado.tpersonaid
AND mini_sedi.tbl_imputado.tdenunciaid = mini_sedi.tbl_imputado_fiscalia.tdenunciaid
INNER JOIN mini_sedi.tbl_bandejas ON mini_sedi.tbl_imputado_fiscalia.nfiscaliaid = mini_sedi.tbl_bandejas.ibandejaid
WHERE
	mini_sedi.tbl_imputado.tdenunciaid = '$denuncia'
AND mini_sedi.tbl_imputado_fiscal.bactivo = TRUE";

$sqlDelitos= "SELECT
mini_sedi.tbl_delito.cdescripcion,
mini_sedi.tbl_imputado_delito.cclasificacion
FROM
mini_sedi.tbl_imputado_delito
INNER JOIN mini_sedi.tbl_imputado ON mini_sedi.tbl_imputado_delito.tpersonaid = mini_sedi.tbl_imputado.tpersonaid AND mini_sedi.tbl_imputado.tdenunciaid = mini_sedi.tbl_imputado_delito.tdenunciaid
INNER JOIN mini_sedi.tbl_delito ON mini_sedi.tbl_imputado_delito.ndelito = mini_sedi.tbl_delito.ndelitoid
WHERE
mini_sedi.tbl_imputado.tdenunciaid = '$denuncia'";

$sqlAlias= "SELECT
mini_sedi.tbl_imputado_alias.alias
FROM
mini_sedi.tbl_imputado
INNER JOIN mini_sedi.tbl_imputado_alias ON mini_sedi.tbl_imputado_alias.tpersonaid = mini_sedi.tbl_imputado.tpersonaid AND mini_sedi.tbl_imputado.tdenunciaid = mini_sedi.tbl_imputado_alias.tdenunciaid
WHERE
mini_sedi.tbl_imputado.tdenunciaid = '$denuncia'";

$sqlArma= "";

$sqlTransporte="";

$sqlMovil="";

/*
 * frm del reporte del expediene
 
<!doctype html>
<html>
	<head>
		<title>CKEditor - Classic Version</title>
	</head>
	<body>
		<div id="divEncabezado" title="divEncabezado">
			<table align="center" border="0" cellpadding="0" cellspacing="0" height="171" width="796">
				<tbody>
					<tr>
						<td>
							<img alt="Logo MP" height="90" src="http://portalunico.iaip.gob.hn/img/poderejecutivo/ministerio.jpg" width="213" /></td>
						<td>
							<h1 style="text-align: center;">
								<span style="font-family:arial,helvetica,sans-serif;"><strong>Sistema de Gesti&oacute;n Fiscal</strong><br />
								<strong>SIGEFI</strong></span></h1>
							<h2 style="text-align: center;">
								<strong>Expediente Completo</strong></h2>
							<p>
								<span style="font-family:arial,helvetica,sans-serif;"><strong>Expediente N&deg;</strong><br />
								<strong>Actualizado al </strong></span></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="divGenerales" title="divGenerales">
			<p>
				<strong><span style="font-family:arial,helvetica,sans-serif;">Generales:</span></strong></p>
			<p>
				<span style="font-family:arial,helvetica,sans-serif;">Denuncia tomada en &lt;detalle..&gt; &lt;depto...&gt; en fecha &lt;fecha&gt; a las &lt;hora&gt; horas, sobre hechos ocurridos en fechas &lt;fecha hecho&gt; a las &lt;hora hecho&gt; horas en &lt;detalle dir hecho&gt;, &lt;depto hecho...&gt;, dicho lugar de los hechos es catalogado como &lt;clase lugar...&gt;</span></p>
			<p>
				<span style="font-family:arial,helvetica,sans-serif;">La narraci&oacute;n de los hechos seg&uacute;n el denunciante fue la siguiente: &lt;narracion&gt;</span></p>
		</div>
		<div id="divDenunciado" title="divDenunciado">
			<p>
				<span style="font-family:arial,helvetica,sans-serif;"><strong>Denunciado: n de nn</strong></span></p>
			<table border="1" cellpadding="0" cellspacing="0" height="123" width="1321">
				<tbody>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Nombre completo&nbsp; <span style="font-family:arial,helvetica,sans-serif;">Edad</span></span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Nacionalidad</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Documento de identificacion</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Genero miembro de comunidad LGBTI</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Sexo</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Estado civil</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Escolaridad</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Profesion u oficio</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Ocupaci&oacute;n</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Domicilio&nbsp; tel&eacute;fono</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Grupo &eacute;tnico&nbsp; discapacidad</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Alias</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Delitos o faltas</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Tipo de arma u objeto utilizado</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Transporte</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">M&oacute;vil o contexto en que ocurren los hechos (seg&uacute;n narra denunciante)</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Condici&oacute;n del agresor &lt;cond&gt; posee trabajo remunerado &lt;si-no&gt; Asiste a centro de educaci&oacute;n &lt;si-no&gt;</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Objetos robados o hurtados</span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="divOfendido" title="divOfendido">
			<p>
				<strong><span style="font-family:arial,helvetica,sans-serif;">Ofendido: n de nn</span></strong></p>
			<table border="1" cellpadding="0" cellspacing="0" height="123" width="1321">
				<tbody>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Nombre completo&nbsp; <span style="font-family:arial,helvetica,sans-serif;">Edad</span></span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Nacionalidad</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Documento de identificacion</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Genero miembro de comunidad LGBTI</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Sexo</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Estado civil</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Escolaridad</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Profesion u oficio</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Ocupaci&oacute;n</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Domicilio&nbsp; tel&eacute;fono</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Grupo &eacute;tnico&nbsp; discapacidad</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Para delitos sexuales: Victima embarazada &lt;si-no&gt; Frecuencia del hecho &lt;---&gt; Posee trabajo remunerado &lt;----&gt; Asiste acentro educacinal &lt;----&gt; N&uacute;mero de hijos &lt;---&gt;</span></td>
					</tr>
					<tr>
						<td colspan="2">
							Para suicidios: Hubieron intentos previos &lt;---&gt; Antecedentes de enfermedad mental &lt;---&gt; Mecanismo de muerte &lt;---&gt;</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="divDenunciante" title="divDenunciante">
			<p>
				<strong><span style="font-family:arial,helvetica,sans-serif;">Denunciante: n de nn</span></strong></p>
			<table border="1" cellpadding="0" cellspacing="0" height="123" width="1321">
				<tbody>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Nombre completo&nbsp; <span style="font-family:arial,helvetica,sans-serif;">Edad</span></span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Nacionalidad</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Documento de identificacion</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Genero miembro de comunidad LGBTI &lt;--&gt; con nombre asumido &lt;--&gt;</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Sexo</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Estado civil</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Escolaridad</span></td>
					</tr>
					<tr>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Profesion u oficio</span></td>
						<td>
							<span style="font-family:arial,helvetica,sans-serif;">Ocupaci&oacute;n</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Domicilio&nbsp; tel&eacute;fono</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Grupo &eacute;tnico&nbsp; discapacidad</span></td>
					</tr>
					<tr>
						<td colspan="2">
							<span style="font-family:arial,helvetica,sans-serif;">Apoderado legal &lt;--&gt; Numero de colegiado &lt;---&gt;</span></td>
					</tr>
				</tbody>
			</table>
		</div></body>
</html>
*/