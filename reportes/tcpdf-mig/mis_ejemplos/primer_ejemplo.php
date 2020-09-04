<?php

require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetAuthor('Emilson');
$pdf->SetTitle('Crear PDF');
$pdf->SetSubject('TCPDF Tutorial');

// set default header data
$pdf->SetHeaderData('', '20', 'Primer Ejemplo con la Libreria TCPDF', 'Uso de Metodos');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins('20', '45', '20'); //margen izq, top y derecho
$pdf->SetHeaderMargin('10'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('20'); //configura el margen entre el pie de pag y fin de pag

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 14, '', true); //familia, estilo, tam, archivo fuente, fuente subconjunto

// Add a page
$pdf->AddPage();

// Set some content to print
$html = <<<EOD
<h1>Bienvenido al Primer Ejemplo con la libreria TCPDF</h1>
<i>En donde se han usado algunos de sus metodos.</i>
<p>Este Texto fue escrito utilizando el metodo <i>writeHTMLCell()</i> pero tambien se puede usar los metodos: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Para mayor informacion puede ver la documentacion de la libreria en donde se encuentran mas ejemplos</p>
EOD;

$var='El siguiente valor fue pasado mediante GET: ';
$var.=$_GET['variable'];
$html .= $var;
$html .= "<br><h1>Fin de Ejemplo</h1>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('ejemplo1.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+