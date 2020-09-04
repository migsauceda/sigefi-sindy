<?php

require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Emilson');
$pdf->SetTitle('Crear PDF');
$pdf->SetSubject('TCPDF Tutorial');

// set default header data
$pdf->SetHeaderData('logo_unah.gif', '20', 'UNIVERSIDAD NACIONAL AUTONOMA DE HONDURAS', 'EJEMPLO PARA CREAR TABLA');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '50', PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin('10');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print
$html = '<table align="center" border="1" width="50%">			
			<tr style="background-color:blue;">
				<td>NOMBRE</td>
				<td>APELLIDO</td>
			</tr>
			<tr>
				<td>Emilson</td>
				<td>Acosta</td>
			</tr>
			<tr>
				<td>Omar</td>
				<td>Giron</td>
			</tr>
		</table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('ejemplo_tabla.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+