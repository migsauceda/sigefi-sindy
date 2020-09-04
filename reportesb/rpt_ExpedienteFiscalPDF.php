<?php
session_start();
//include "../funciones/php_funciones.php";
include("../clases/class_conexion_pg.php");
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'EXPEDIENTES ASIGNADOS AL FISCAL: '.strtoupper($_SESSION['nombreusr']), 'Fecha: '.$fecha.'  Hora: '.$hora.'  Usuario: '.$_SESSION['usuario']);

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
				<td>Nombre Denunciado</td>
				<td>Sexo</td>
				<td>Número de Denuncia</td>
				<td>Estado</td>
				<td>Fecha Asignación</td>
			</tr>';

$fiscalid= $_SESSION['identidad'];

$inicio= $_POST['txtFInicio'];
$inicio= substr($inicio, 6, 4).substr($inicio, 0, 2).substr($inicio, 3, 2);
$fin= $_POST['txtFFin'];
$fin= substr($fin, 6, 4).substr($fin, 0, 2).substr($fin, 3, 2);

if ($_POST['chbMostrarTodo']== 'chk')
{
    $sql= "SELECT tdenunciaid, dfechaasignacion, bactivo, trim(cnombres) || ', ' || trim(capellidos) nombres, 
       cgenero from expediente_fiscal('$fiscalid');";    
}    
else{    
    $sql= "SELECT tdenunciaid, dfechaasignacion, bactivo, trim(cnombres) || ', ' || trim(capellidos) nombres, 
       cgenero from expediente_fiscal('$fiscalid') 
       where dfechaasignacion >= to_date('$inicio','yyyymmdd')  and dfechaasignacion<= to_date('$fin','yyyymmdd');";
}

$conexion= new Conexion();
$cursor= $conexion->ejecutarProcedimiento($sql);
$reg= pg_fetch_array($cursor);

while ($reg){
    $html.="<tr>
                <td>$reg[nombres]</td>
                <td>$reg[cgenero]</td>
                <td>$reg[tdenunciaid]</td>
                <td>$reg[bactivo]</td>
                <td>$reg[dfechaasignacion]</td>
            </tr>";
    
    $reg= pg_fetch_array($cursor);
}  

$html.="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->Output('Expedientes por fiscal.pdf', 'I');

//echo $reg['nombres'];
?>
       