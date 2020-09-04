<?php session_start();
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');

$condiciones=$_SESSION['condiciones'];
$fechasIni=$_SESSION['fechasIni'];
$fechasFin=$_SESSION['fechasFin'];
$sedes=$_SESSION['sedes'];
$usuarios=$_SESSION['usuarios'];
$usuario=$_SESSION['usuario'];

$conexion=new cls_conexion();
$conexion->conectar();
$resultado=array();
$i=0; 

for ($i=0;$i<=count($condiciones);$i++){
    $resultado[$i]=$conexion->consultar("select mini_sedi.tbl_denuncia.ccreada, tbl_usuarios.nombreapellido, tbl_lugarrecepcion.cdescripcion, 
count(mini_sedi.tbl_denuncia.ccreada) as denuncias_capturadas 
from mini_sedi.tbl_denuncia inner join mini_sedi.tbl_lugarrecepcion on mini_sedi.tbl_denuncia.nlugarrecepcion=tbl_lugarrecepcion.nlugarid 
inner join mini_sedi.tbl_usuarios on mini_sedi.tbl_denuncia.ccreada=tbl_usuarios.usuario 
where $condiciones[$i] 
group by mini_sedi.tbl_denuncia.ccreada, tbl_usuarios.nombreapellido, 
tbl_lugarrecepcion.cdescripcion order by mini_sedi.tbl_denuncia.ccreada");
//	$resultado[$i]=$conexion->consultar("select tbl_controlestados.usr, tbl_usuarios.nombreapellido, tbl_lugarrecepcion.cdescripcion, 
//count(tbl_controlestados.usr) as denuncias_capturadas from tbl_controlestados inner join 
//tbl_denuncia on tbl_controlestados.denuncia=tbl_denuncia.tdenunciaid inner join tbl_lugarrecepcion on 
//tbl_denuncia.nlugarrecepcion=tbl_lugarrecepcion.nlugarid inner join tbl_usuarios on
//tbl_controlestados.usr=tbl_usuarios.usuario where $condiciones[$i] group by 
//tbl_controlestados.usr, tbl_usuarios.nombreapellido, tbl_lugarrecepcion.cdescripcion 
//order by tbl_controlestados.usr");
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'FRECUENCIA DE DENUNCIAS CAPTURADAS POR USUARIO, POR RANGO DE FECHAS Y POR SEDES', 'Fecha: '.$fecha.'  Hora: '.$hora.'               Usuario: '.$usuario);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9.5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins('15', '55', '15'); //margen izq, top y derecho
$pdf->SetHeaderMargin('10'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('10'); //configura el margen entre el pie de pag y fin de pag

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 11, '', true); //familia, estilo, tam, archivo fuente, fuente subconjunto

// Add a page
$pdf->AddPage();

// Set some content to print
$html='<table align="center" border="1" width="100%">			
			<tr>
				<td>Usuario</td>
				<td>Nombre Usuario</td>
				<td>Sede</td>
				<td>Num. Denuncias Capturadas</td>
				<td>Fecha Inicio</td>
				<td>Fecha Fin</td>
			</tr>';
$i=0;

for ($i=0;$i<sizeof($resultado);$i++){
	while ($row=pg_fetch_assoc($resultado[$i])){
		$html.="<tr>
					<td>$row[usr]</td>
					<td>$row[nombreapellido]</td>
					<td>$row[cdescripcion]</td>
					<td>$row[denuncias_capturadas]</td>
					<td>$fechasIni[$i]</td>
					<td>$fechasFin[$i]</td>
				</tr>";					
	}
}

$html.='</table><br>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='15', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Frecuencia de denuncias capturadas por usuario, por rango de fechas y por sedes.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+