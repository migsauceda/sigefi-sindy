<?php session_start();
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');
$condiciones=$_SESSION['condiciones'];
$condicionesFecha=$_SESSION['condicionesFecha'];
$fechasIni=$_SESSION['fechasIni'];
$fechasFin=$_SESSION['fechasFin'];
$fiscalias=$_SESSION['fiscalias'];
$fiscales=$_SESSION['fiscales'];
$estados=$_SESSION['estados'];
$usuario=$_SESSION['usuario'];

$conexion=new cls_conexion();
$conexion->conectar();
$resultado=array();//resultado para denuncias
$resultado1=array();//resultado para denunciados
$i=0;

//echo "select cfiscal, tbl_fiscal.cnombres, tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, 
//count(tabla.denuncias) as denuncias, tabla.bactivo as estado from 
//(select distinct cfiscal, tdenunciaid as denuncias, bactivo from tbl_imputado_fiscal where $condicionesFecha[$i] order by cfiscal) as
//tabla inner join tbl_fiscal on tabla.cfiscal=tbl_fiscal.cfiscalid inner join tbl_fiscalia on
//tbl_fiscal.nfiscaliaid=tbl_fiscalia.nfiscaliaid where $condiciones[$i] group by cfiscal, tbl_fiscal.cnombres, 
//tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, tabla.bactivo order by cfiscal";

for ($i=0;$i<sizeof($condiciones);$i++){
	//denuncias
	$resultado[$i]=$conexion->consultar("select cfiscal, tbl_fiscal.cnombres, tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, 
count(tabla.denuncias) as denuncias, tabla.bactivo as estado from 
(select distinct cfiscal, tdenunciaid as denuncias, bactivo from tbl_imputado_fiscal where $condicionesFecha[$i] order by cfiscal) as
tabla inner join tbl_fiscal on tabla.cfiscal=tbl_fiscal.cfiscalid inner join tbl_fiscalia on
tbl_fiscal.nfiscaliaid=tbl_fiscalia.nfiscaliaid where $condiciones[$i] group by cfiscal, tbl_fiscal.cnombres, 
tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, tabla.bactivo order by cfiscal");
	//denunciados
	$resultado1[$i]=$conexion->consultar("select cfiscal, tbl_fiscal.cnombres, tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, 
count(tabla.cfiscal) as denunciados, tabla.bactivo as estado from 
(select distinct cfiscal, timputadoid as imputados, bactivo from tbl_imputado_fiscal where $condicionesFecha[$i] order by cfiscal) as
tabla inner join tbl_fiscal on tabla.cfiscal=tbl_fiscal.cfiscalid inner join tbl_fiscalia on
tbl_fiscal.nfiscaliaid=tbl_fiscalia.nfiscaliaid where $condiciones[$i] group by cfiscal, tbl_fiscal.cnombres, 
tbl_fiscal.capellidos, tbl_fiscalia.cdescripcion, tabla.bactivo order by cfiscal");
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'FRECUENCIA DE DENUNCIAS ASIGNADAS POR FISCAL, POR RANGO DE FECHAS Y ESTADO', 'Fecha: '.$fecha.'  Hora: '.$hora.'               Usuario: '.$usuario);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9.5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins('10', '55', '10'); //margen izq, top y derecho
$pdf->SetHeaderMargin('10'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('10'); //configura el margen entre el pie de pag y fin de pag

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 11, '', true); //familia, estilo, tam, archivo fuente, fuente subconjunto

// Add a page
$pdf->AddPage();

// Set some content to print
$html='<table align="center" border="1">			
			<tr>
				<td>Nombre Fiscalia</td>
				<td>Nombre Fiscal</td>
				<td>Num. Denuncias Asignadas</td>
				<td>Num. Denunciados</td>
				<td>Fecha Inicio</td>
				<td>Fecha Fin</td>
				<td>Estado</td>
			</tr>';
$i=0;

for ($i=0;$i<sizeof($resultado);$i++){
	while ($row=pg_fetch_assoc($resultado[$i])){
		$row1=pg_fetch_assoc($resultado1[$i]);//denunciados
		$html.="<tr>
					<td>$row[cdescripcion]</td>
					<td>$row[cnombres] $row[capellidos]</td>
					<td>$row[denuncias]</td>
					<td>$row1[denunciados]</td>
					<td>$fechasIni[$i]</td>
					<td>$fechasFin[$i]</td>";
					if ($row['bactivo']=="t"){
						$html.="<td>Activo</td></tr>";
					}else{
						$html.="<td>Inactivo</td></tr>";
					}					
	}
}

$html.='</table><br>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Frecuencia de denuncias asignadas por fiscal por rango de fechas y estado.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+