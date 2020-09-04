<?php session_start();

include('../clases/class_conexion_pg.php');
require_once('tcpdf/tcpdf.php');
$denuncia=$_SESSION['denuncia'];
$usuario=$_SESSION['usuario'];

$conexion=new Conexion();

/*
$resultado=$conexion->ejecutarProcedimiento("select tbl_denuncia.tdenunciaid, tbl_imputado_denuncia.tpersonaid as imputado, 
tbl_imputado_fiscal.cfiscal, tbl_imputado_actividad.tpersonaid, 
tbl_imputado_actividad.dfecha, tbl_actividad.nactividadid, tbl_actividad.cdescripcion as actividad, 
tbl_etapa.netapaid, tbl_etapa.cdescripcion as etapa, tbl_materia.nmateria, tbl_materia.cdescripcion as 
materia, tbl_fiscal.cnombres as nomb_fiscal, tbl_fiscal.capellidos as ape_fiscal, 
tbl_imputado.cnombres as nomb_imputado, tbl_imputado.capellidos as ape_imputado
from tbl_denuncia inner join tbl_imputado_denuncia on tbl_denuncia.tdenunciaid=
tbl_imputado_denuncia.tdenunciaid inner join tbl_imputado_fiscal on tbl_denuncia.tdenunciaid=
tbl_imputado_fiscal.tdenunciaid inner join tbl_imputado_actividad on
tbl_imputado_fiscal.cfiscal=tbl_imputado_actividad.cfiscalid inner join tbl_actividad on 
tbl_imputado_actividad.nactividadid=tbl_actividad.nactividadid inner join tbl_etapa on
tbl_actividad.netapaid=tbl_etapa.netapaid inner join tbl_materia on tbl_imputado_actividad.nmateriaid=
tbl_materia.nmateria inner join tbl_fiscal on tbl_imputado_actividad.cfiscalid=tbl_fiscal.cfiscalid 
inner join tbl_imputado on tbl_imputado_denuncia.tpersonaid=tbl_imputado.tpersonaid 
where tbl_denuncia.tdenunciaid=$denuncia order by tbl_imputado_actividad.dfecha");
*/

$resultado=$conexion->ejecutarProcedimiento("
SELECT 
  tbl_imputado_actividad.tdenunciaid, 
  tbl_imputado_actividad.tpersonaid as imputado, 
  tbl_imputado_actividad.cfiscalid, 
  tbl_imputado_actividad.dfecha, 
  tbl_imputado_actividad.nactividadid, 
  tbl_actividad.cdescripcion as actividad, 
  tbl_imputado_actividad.netapa, 
  tbl_etapa.cdescripcion as etapa, 
  tbl_imputado_actividad.nmateriaid, 
  tbl_materia.cdescripcion as materia, 
  tbl_fiscal.cnombres as nomb_fiscal, 
  tbl_fiscal.capellidos as ape_fiscal, 
  tbl_imputado.cnombres as nomb_imputado, 
  tbl_imputado.capellidos as ape_imputado
FROM 
  mini_sedi.tbl_actividad, 
  mini_sedi.tbl_etapa, 
  mini_sedi.tbl_materia, 
  mini_sedi.tbl_imputado_actividad, 
  mini_sedi.tbl_imputado, 
  mini_sedi.tbl_fiscal
WHERE 
  tbl_actividad.nactividadid = tbl_imputado_actividad.nactividadid AND
  tbl_imputado_actividad.tpersonaid = tbl_imputado.tpersonaid AND
  tbl_imputado_actividad.nmateriaid = tbl_materia.nmateria AND
  tbl_imputado_actividad.netapa = tbl_etapa.netapaid AND
  tbl_fiscal.cfiscalid = tbl_imputado_actividad.cfiscalid AND
  tbl_imputado_actividad.tdenunciaid=$denuncia 
ORDER BY
  tbl_imputado_actividad.dfecha ASC;
");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
$pdf->SetHeaderData('mp_logo.png', '30', 'HISTORIAL DE ACTIVIDAD FISCAL POR CASO POR DENUNCIADO', 'Fecha: '.$fecha.'  Hora: '.$hora.'               Usuario: '.$usuario);

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
$i=0;
$m=0;
$infActividades=array();
$etapa="";
$materia="";
$etapaAnt="";
$materiaAnt="";
$fiscal="";
$denunciado="";
$fiscalAnt="";
$denunciadoAnt="";

while ($row=pg_fetch_assoc($resultado)){
	$etapa=$row['netapaid'];
	$materia=$row['nmateria'];
	$fiscal=$row['cfiscal'];
	$denunciado=$row['imputado'];
	
	if ($m==0){
		$etapaAnt=$etapa;
		$materiaAnt=$materia;
		$fiscalAnt=$fiscal;
		$denunciadoAnt=$denunciado;
                $infActividades[$i]="<table border= \"0\" id= \"datosgenerales\">";
                $i++;
		$infActividades[$i]= "<tr><td><strong>Fiscal: </strong>$row[nomb_fiscal] $row[ape_fiscal]</td></tr>";
                $i++;
                $infActividades[$i].="<tr><td><strong>Denunciado: </strong>$row[nomb_imputado] $row[ape_imputado]</td></tr>";
                $i++;
                $infActividades[$i].="<tr><td><strong>Denuncia: </strong>$denuncia</td></tr>";
                $i++;
		$infActividades[$i].="<tr><td><strong>Materia: </strong>$row[materia]&nbsp;&nbsp;&nbsp;&nbsp;<strong>Etapa:</strong> $row[etapa]</td></tr>";
                $i++;
                $infActividades[$i]="</table>";
                $i++;
                $infActividades[$i]="<br><table border= \"0\">";
                $i++;                
                $infActividades[$i].="<tr><th><strong>ACTIVIDAD</strong></th><th><strong>FECHA</strong></th></tr>";
                $i++;
	}

	if (($materia==$materiaAnt) && ($etapa==$etapaAnt)){
		$m=1;                
		$infActividades[$i].="<tr><td>$row[actividad]</td><td>$row[dfecha]</td></tr>";
	}else{
		$i++;
//		$m=0;
		if ($fiscal!=$fiscalAnt){//en caso de que fiscal sea distinto, puede tener mismo imputado o distinto imputado
			$infActividades[$i]="<tr><td><strong>Fiscal:</strong> $row[nomb_fiscal] $row[ape_fiscal]</td></tr>";
                        $i++;
                        $infActividades[$i]="<tr><td><strong>Denunciado:</strong> $row[nomb_imputado] $row[ape_imputado]</td></tr>";
		}else{
			if ($denunciado!=$denunciadoAnt){//en caso de que denunciado sea distinto para el mismo fiscal
				$infActividades[$i]="<tr><td><strong>Fiscal:</strong> $row[nomb_fiscal] $row[ape_fiscal]</td></tr>";
                                $i++;
                                $infActividades[$i]="<tr><td><strong>Denunciado:</strong> $row[nomb_imputado] $row[ape_imputado]</td></tr>";
			}
		}
		$infActividades[$i].="<tr><td><strong>Materia: </strong>$row[materia]&nbsp;&nbsp;&nbsp;&nbsp;<strong>Etapa:</strong> $row[etapa]</td></tr>";
		$infActividades[$i].="<tr><td>$row[actividad]</td><td>$row[dfecha]</td></tr>";
	}

	$etapaAnt=$etapa;
	$materiaAnt=$materia;	
	$fiscalAnt=$fiscal;
	$denunciadoAnt=$denunciado;	
}
$infActividades[$i].="</table>";
//echo sizeof($infActividades)."<br>";
$html="";

for ($j=0;$j<sizeof($infActividades);$j++){
	$html.=$infActividades[$j];
}

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Historial de actividad fiscal por caso '.$denuncia.' por denunciado.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+

