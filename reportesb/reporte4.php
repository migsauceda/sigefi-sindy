<?php session_start();
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');
$condiciones=$_SESSION['condiciones'];
$fechasIni=$_SESSION['fechasIni'];
$fechasFin=$_SESSION['fechasFin'];
$fiscalias=$_SESSION['fiscalias'];
$estados=$_SESSION['estados'];
$usuario=$_SESSION['usuario'];

$conexion=new cls_conexion();
$conexion->conectar();
$resultado=array();
$i=0;
for ($i=0;$i<sizeof($condiciones);$i++){
	$resultado[$i]=$conexion->consultar("select tbl_fiscalia.cdescripcion, tbl_imputado_fiscalia.bactivo, count(tbl_imputado_fiscalia.nfiscaliaid) as total from tbl_imputado_fiscalia inner join tbl_fiscalia on tbl_imputado_fiscalia.nfiscaliaid=tbl_fiscalia.nfiscaliaid where $condiciones[$i] group by tbl_imputado_fiscalia.nfiscaliaid, tbl_fiscalia.cdescripcion, tbl_imputado_fiscalia.bactivo order by tbl_fiscalia.cdescripcion");
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'FRECUENCIA DE DENUNCIAS ASIGNADAS POR FISCALÍA, POR RANGO DE FECHAS Y ESTADO', 'Fecha: '.$fecha.'  Hora: '.$hora.'               Usuario: '.$usuario);

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
$html='<table align="center" border="1" width="95%">			
			<tr>
				<td>Nombre Fiscalia</td>
				<td>Num. Denuncias Asignadas</td>
				<td>Fecha Inicio</td>
				<td>Fecha Fin</td>
				<td>Estado</td>
			</tr>';
$i=0;

for ($i=0;$i<sizeof($resultado);$i++){
	while ($row=pg_fetch_assoc($resultado[$i])){
		$html.="<tr>
					<td>$row[cdescripcion]</td>
					<td>$row[total]</td>
					<td>$fechasIni[$i]</td>
					<td>$fechasFin[$i]</td>";
					if ($row['bactivo']=="t"){
						$html.="<td>Activo</td></tr>";
					}else{
						$html.="<td>Inactivo</td></tr>";
					}					
		
		/*$fechaDenuncia=$row['dfechadenuncia'];
		for($i=0;$i<sizeof($fechasIni);$i++){//echo $fechaDenuncia."<br>";
			$timestamp1 = mktime(0, 0, 0, substr($fechasIni[$i], 5, 2), $dia=substr($fechasIni[$i], 8, 2), substr($fechasIni[$i], 0, 4));//echo $timestamp1."<br>";
			$timestamp2 = mktime(0, 0, 0, substr($fechaDenuncia, 5, 2), $dia=substr($fechaDenuncia, 8, 2), substr($fechaDenuncia, 0, 4)); //echo $timestamp2."<br>";
			$timestamp3 = mktime(0, 0, 0, substr($fechasFin[$i], 5, 2), $dia=substr($fechasFin[$i], 8, 2), substr($fechasFin[$i], 0, 4));//echo $timestamp3."<br>";echo $row['cdescripcion']."<br>".$sedes[$i]."<br>";
			if(($timestamp2>=$timestamp1) && ($timestamp2<=$timestamp3) && ($row['nlugarid']==$sedes[$i])){
				$html.="<td>$fechasIni[$i]</td>
						<td>$fechasFin[$i]</td>";
			}
		}	*/
				//$html.="</tr>";
	}
}

$html.='</table><br>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='25', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Frecuencia de denuncias asignadas por fiscalía por rango de fechas y estado.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+