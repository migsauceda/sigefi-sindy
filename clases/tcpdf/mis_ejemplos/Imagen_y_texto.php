<?php

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Emilson');
$pdf->SetTitle('Crear PDF');
$pdf->SetSubject('TCPDF Tutorial');

// set default header data
$pdf->SetHeaderData('logo_example.jpg', '20', 'EJEMPLO PARA EL USO DE IMAGENES Y ESCRITURA DE TEXTO', 'En Este Ejemplo Se Escribira Texto Sobre la Imagen');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '50', PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// -------------------------------------------------------------------

// add a page
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(200);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
//$pdf->Image('../images/image_demo.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// Stretching, position and alignment example

$pdf->SetFont('helvetica', '', 10);

$pdf->SetXY(28, 30);
$html="Acosta Giron";
$pdf->Image('../images/certificado.jpg', '', '', 150, 150, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

$pdf->writeHTMLCell($w=0, $h=0, $x='52', $y='69', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="Emilson";
$pdf->writeHTMLCell($w=0, $h=0, $x='52', $y='76', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="Introduccion a PHP";
$pdf->writeHTMLCell($w=0, $h=0, $x='91', $y='84', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// -------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('imagen_y_texto.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
