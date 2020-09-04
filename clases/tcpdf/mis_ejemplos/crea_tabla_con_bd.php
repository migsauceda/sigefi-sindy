<?php

require_once('../tcpdf.php');
require_once('cls_conexion.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$conexion=new cls_conexion();
$conexion->conectar();

// set document information
$pdf->SetAuthor('Emilson');
$pdf->SetTitle('Crear PDF');
$pdf->SetSubject('TCPDF Tutorial');

// set default header data
$pdf->SetHeaderData('logo_example.jpg', '10', "Ejemplo de Creacion de Tabla desde una Base de Datos", "Departamentos de Honduras");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

$resultado1=$conexion->consultar("select * from departamentos");

$html='<table align="center" border="1" width="80%">			
			<tr style="background-color:#36F;">
				<td>NOMBRE</td>
				<td>CABECERA</td>
				<td>PAIS</td>
			</tr>';
$i=0;
while ($row = pg_fetch_row($resultado1)) {
	$i++;
	
	if (($i%2)==0){
		$html.='<tr style="background-color:#CCC;">';
	}else{
		$html.='<tr style="background-color:white;">';	
	}
	$html.="<td>$row[1]</td>
			<td>$row[2]</td>
			<td>$row[3]</td>
		  </tr>";
}
$html.='</table>';

$pdf->writeHTMLCell($w=0, $h=0, $x='40', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('tabla_bd.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
