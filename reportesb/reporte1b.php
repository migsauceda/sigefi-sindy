<?php session_start();
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');
$denuncia=$_SESSION['denunciaid'];
//$usuario=$_SESSION['usr'];
$usuario=$_SESSION['usuario'];
$impresion;

if (isset($_GET['denunciaprn'])){
    $denuncia= $_GET['denunciaprn'];
}

$archivo="impresiones_denuncia/denuncia$denuncia".".txt";

$conexion=new cls_conexion();
$conexion->conectar();
$resultado;
$resultadoDelitos;
$resultadosTemp;

$consulta="select tbl_pdf_denuncia.dfechadenuncia, tbl_pdf_denuncia.dfechahecho, tbl_pdf_denuncia.cdeptodenuncia, 
tbl_pdf_denuncia.cmunicipiodenuncia, tbl_pdf_denuncia.cdeptohecho, tbl_pdf_denuncia.cmunicipiohecho, 
tbl_pdf_denuncia.caldeahecho, tbl_pdf_denuncia.ccaseriohecho, tbl_pdf_denuncia.nlugarrecepcion, 
tbl_pdf_denuncia.cestadodenuncia, tbl_pdf_denuncia.cnarracionhecho, tbl_pdf_denuncia.cexpedientesedi, 
tbl_pdf_denuncia.cexpedientejudicial, tbl_pdf_denuncia.cdetalledireccionhecho, tbl_pdf_denuncia.tdenunciaid,
tbl_pdf_denuncia.cexpedientepolicial, tbl_pdf_denuncia.basignadafiscalia, tbl_pdf_denuncia.cdirecciondenuncia,
 tbl_pdf_denuncia.cdireccionhecho, tbl_pdf_denuncia.ccreada, tbl_pdf_denunciante.cdocumentoid as doc_denunciante, tbl_pdf_denunciante.cnombres as nomb_denunciante, tbl_pdf_denunciante.capellidos as apellidos_denunciante, tbl_pdf_denunciante.cgenero as gen_denunciante, tbl_pdf_denunciante.nprofesionid as prof_denunciante, tbl_pdf_denunciante.nocupacionid as ocupacion_denunciante, tbl_pdf_denunciante.nescolaridadid as esc_denunciante, tbl_pdf_denunciante.cnacionalidadid as nac_denunciante, tbl_pdf_denunciante.netniaid as etnia_denunciante, tbl_pdf_denunciante.ndiscapacidadid as discapacidad_denunciante, tbl_pdf_denunciante.iedad as edad_denunciante, tbl_pdf_denunciante.cunidadmedidaedad as unidad_medida_edad_denunciante, tbl_pdf_denunciante.crangoedad as rago_edad_denunciante, tbl_pdf_denunciante.cdepartamentoid as depto_denunciante, tbl_pdf_denunciante.cmunicipioid as municipio_denunciante, tbl_pdf_denunciante.caldeaid as aldea_denunciante, tbl_pdf_denunciante.cdetalle as detalle_denunciante, tbl_pdf_denunciante.cbarrioid as barrio_denunciante, tbl_pdf_denunciante.corientacionsexual as orientacion_sexual_denunciante, tbl_pdf_denunciante.cdireccion as direccion_denunciante, tbl_pdf_denunciante.nestadocivil as estado_civil_denunciante, tbl_pdf_denunciante.nconocido as conocido_denunciante, 
 tbl_pdf_imputado.tpersonaid as personaid_imputado, tbl_pdf_imputado.cdocumentoid as doc_imputado, tbl_pdf_imputado.cnombres as nomb_imputado, tbl_pdf_imputado.capellidos as apellidos_imputado, tbl_pdf_imputado.cgenero as gen_imputado, tbl_pdf_imputado.nprofesionid as prof_imputado, tbl_pdf_imputado.nocupacionid as ocupacion_imputado, tbl_pdf_imputado.nescolaridadid as esc_imputado, tbl_pdf_imputado.cnacionalidadid as nac_imputado, tbl_pdf_imputado.netniaid as etnia_imputado, tbl_pdf_imputado.ndiscapacidadid as discapacidad_imputado, 
tbl_pdf_imputado.iedad as edad_imputado, tbl_pdf_imputado.cunidadmedidaedad as 
unidad_medida_edad_imputado, tbl_pdf_imputado.crangoedad as rago_edad_imputado, 
tbl_pdf_imputado.cdepartamentoid as depto_imputado, tbl_pdf_imputado.cmunicipioid as 
municipio_imputado, tbl_pdf_imputado.caldeaid as aldea_imputado, tbl_pdf_imputado.cdetalle as 
detalle_imputado, tbl_pdf_imputado.cbarrioid as barrio_imputado, tbl_pdf_imputado.corientacionsexual as orientacion_sexual_imputado, tbl_pdf_imputado.cdireccion as direccion_imputado, tbl_pdf_imputado.nestadocivil as estado_civil_imputado, tbl_pdf_imputado.nfiscaliaid as 
fiscalia_imputado, tbl_pdf_imputado.nconocido as conocido_imputado, tbl_pdf_imputado.calias as 
alias_imputado, tbl_pdf_imputado.bmenorinfractor as menor_infractor_imputado, 
tbl_pdf_imputado.crepresentantelegalmenor as representante_legal_menor_imputado, 
tbl_pdf_ofendido.cdocumentoid as doc_ofendido, tbl_pdf_ofendido.cnombres as nomb_ofendido, 
tbl_pdf_ofendido.capellidos as apellidos_ofendido, tbl_pdf_ofendido.cgenero as gen_ofendido, 
tbl_pdf_ofendido.nprofesionid as prof_ofendido, tbl_pdf_ofendido.nocupacionid as ocupacion_ofendido, 
tbl_pdf_ofendido.nescolaridadid as esc_ofendido, tbl_pdf_ofendido.cnacionalidadid as nac_ofendido, 
tbl_pdf_ofendido.netniaid as etnia_ofendido, tbl_pdf_ofendido.ndiscapacidadid as discapacidad_ofendido, 
tbl_pdf_ofendido.iedad as edad_ofendido, tbl_pdf_ofendido.cunidadmedidaedad as 
unidad_medida_edad_ofendido, tbl_pdf_ofendido.crangoedad as rago_edad_ofendido, 
tbl_pdf_ofendido.cdepartamentoid as depto_ofendido, tbl_pdf_ofendido.cmunicipioid as 
municipio_ofendido, tbl_pdf_ofendido.caldeaid as aldea_ofendido, tbl_pdf_ofendido.cdetalle as 
detalle_ofendido, tbl_pdf_ofendido.cbarrioid as barrio_ofendido, 
tbl_pdf_ofendido.corientacionsexual as orientacion_sexual_ofendido, tbl_pdf_ofendido.cdireccion as 
direccion_ofendido, tbl_pdf_ofendido.nestadocivil as estado_civil_ofendido, 
tbl_pdf_ofendido.bvive as vive_ofendido, tbl_pdf_ofendido.nconocido as conocido_ofendido, 
tbl_pdf_ofendido.crepresentantelegal as representante_legal_ofendido, 
tbl_pdf_ofendido.cesmenor as menor_ofendido 
from tbl_pdf_denuncia inner join tbl_pdf_denunciante on 
tbl_pdf_denuncia.tdenunciaid=tbl_pdf_denunciante.tdenunciaid inner join tbl_pdf_imputado on 
tbl_pdf_denuncia.tdenunciaid=tbl_pdf_imputado.tdenunciaid inner join tbl_pdf_ofendido on 
tbl_pdf_denuncia.tdenunciaid=tbl_pdf_ofendido.tdenunciaid 
where tbl_pdf_denuncia.tdenunciaid= '$denuncia'";

$sqlDenunciante= "SELECT 
  tbl_etnia.cdescripcion as etnia_denunciante, 
  tbl_discapacidad.cdescripcion as discapacidad_denunciante, 
  tbl_escolaridad.cdescripcion as esc_denunciante, 
  tbl_pdf_denunciante.cdocumentoid, 
  tbl_pdf_denunciante.cnombres as nomb_denunciante, 
  tbl_pdf_denunciante.capellidos as apellidos_denunciante, 
  tbl_pdf_denunciante.cgenero as gen_denunciante, 
  tbl_pdf_denunciante.iedad as edad_denunciante, 
  tbl_tipodocumento.cdescripcion, 
  tbl_pdf_denunciante.cunidadmedidaedad, 
  tbl_nacionalidad.cdescripcion as nac_denunciante, 
  tbl_estadoscivil.cdescripcion as estado_civil_denunciante, 
  tbl_ocupacion.cdescripcion as ocupacion_denunciante, 
  tbl_profesion.cdescripcion as prof_denunciante, 
  tbl_pdf_denunciante.ctelefono, 
  tbl_departamentopais.cdescripcion as depto_denunciante, 
  tbl_municipio.cdescripcion as municipio_denunciante, 
  tbl_aldea.cdescripcion as aldea_denunciante, 
  tbl_barrio.cdescripcion as barrio_denunciante,
  tbl_pdf_denunciante.cdetalle as direccion_denuciante,
  tbl_pdf_denunciante.tdenunciaid,
  tbl_pdf_denunciante.ntipodocumento,
  tbl_pdf_denunciante.cdocumentoid
FROM 
  mini_sedi.tbl_etnia, 
  mini_sedi.tbl_discapacidad, 
  mini_sedi.tbl_escolaridad, 
  mini_sedi.tbl_pdf_denunciante, 
  mini_sedi.tbl_tipodocumento, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_estadoscivil, 
  mini_sedi.tbl_ocupacion, 
  mini_sedi.tbl_profesion, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_barrio
WHERE 
  tbl_pdf_denunciante.ndiscapacidadid = tbl_discapacidad.ndiscapacidadid AND
  tbl_pdf_denunciante.netniaid = tbl_etnia.netniaid AND
  tbl_pdf_denunciante.nescolaridadid = tbl_escolaridad.nescolaridadid AND
  tbl_pdf_denunciante.ntipodocumento = tbl_tipodocumento.ndocumentoid AND
  tbl_pdf_denunciante.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_pdf_denunciante.nestadocivil = tbl_estadoscivil.ncivil AND
  tbl_pdf_denunciante.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_pdf_denunciante.nprofesionid = tbl_profesion.nprofesionid AND
  tbl_pdf_denunciante.cdepartamentoid = tbl_departamentopais.cdepartamentoid AND
  tbl_pdf_denunciante.cmunicipioid = tbl_municipio.cmunicipioid AND
  tbl_pdf_denunciante.cdepartamentoid = tbl_municipio.cdepartamentoid AND
  tbl_pdf_denunciante.cdepartamentoid = tbl_aldea.cdepartamentoid AND
  tbl_pdf_denunciante.cmunicipioid = tbl_aldea.cmunicipioid AND
  tbl_pdf_denunciante.caldeaid = tbl_aldea.caldeaid AND
  tbl_pdf_denunciante.cdepartamentoid = tbl_barrio.cdepartamentoid AND
  tbl_pdf_denunciante.cmunicipioid = tbl_barrio.cmunicipioid AND
  tbl_pdf_denunciante.caldeaid = tbl_barrio.caldeaid AND
  tbl_pdf_denunciante.cbarrioid = tbl_barrio.cbarrioid and 
  tbl_pdf_denunciante.tdenunciaid = '$denuncia'"; 

$sqlDenunciado= "SELECT 
  tbl_etnia.cdescripcion as etnia_denunciado, 
  tbl_discapacidad.cdescripcion as discapacidad_denunciado, 
  tbl_escolaridad.cdescripcion as esc_denunciado, 
  tbl_pdf_imputado.tpersonaid as personaid_imputado,
  tbl_pdf_imputado.cdocumentoid, 
  tbl_pdf_imputado.cnombres as nomb_denunciado, 
  tbl_pdf_imputado.capellidos as apellidos_denunciado, 
  tbl_pdf_imputado.cgenero as gen_denunciado, 
  tbl_pdf_imputado.iedad as edad_denunciado, 
  tbl_tipodocumento.cdescripcion, 
  tbl_pdf_imputado.cunidadmedidaedad, 
  tbl_nacionalidad.cdescripcion as nac_denunciado, 
  tbl_estadoscivil.cdescripcion as estado_civil_denunciado, 
  tbl_ocupacion.cdescripcion as ocupacion_denunciado, 
  tbl_profesion.cdescripcion as prof_denunciado, 
  tbl_pdf_imputado.ctelefono, 
  tbl_departamentopais.cdescripcion as depto_denunciado, 
  tbl_municipio.cdescripcion as municipio_denunciado, 
  tbl_aldea.cdescripcion as aldea_denunciado, 
  tbl_barrio.cdescripcion as barrio_denunciado,
  tbl_pdf_imputado.cdetalle as direccion_denunciado,
  tbl_pdf_imputado.tdenunciaid,
  tbl_pdf_imputado.ntipodocumento,
  tbl_pdf_imputado.cdocumentoid  
FROM 
  mini_sedi.tbl_pdf_imputado, 
  mini_sedi.tbl_etnia, 
  mini_sedi.tbl_discapacidad, 
  mini_sedi.tbl_escolaridad, 
  mini_sedi.tbl_tipodocumento, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_estadoscivil, 
  mini_sedi.tbl_ocupacion, 
  mini_sedi.tbl_profesion, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_barrio
WHERE 
  tbl_pdf_imputado.nprofesionid = tbl_profesion.nprofesionid AND
  tbl_pdf_imputado.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_pdf_imputado.nescolaridadid = tbl_escolaridad.nescolaridadid AND
  tbl_pdf_imputado.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_pdf_imputado.ndiscapacidadid = tbl_discapacidad.ndiscapacidadid AND
  tbl_pdf_imputado.cdepartamentoid = tbl_departamentopais.cdepartamentoid AND
  tbl_pdf_imputado.cdepartamentoid = tbl_municipio.cdepartamentoid AND
  tbl_pdf_imputado.cmunicipioid = tbl_municipio.cmunicipioid AND
  tbl_pdf_imputado.cdepartamentoid = tbl_barrio.cdepartamentoid AND
  tbl_pdf_imputado.cmunicipioid = tbl_barrio.cmunicipioid AND
  tbl_pdf_imputado.caldeaid = tbl_barrio.caldeaid AND
  tbl_pdf_imputado.cbarrioid = tbl_barrio.cbarrioid AND
  tbl_pdf_imputado.cdepartamentoid = tbl_aldea.cdepartamentoid AND
  tbl_pdf_imputado.cmunicipioid = tbl_aldea.cmunicipioid AND
  tbl_pdf_imputado.caldeaid = tbl_aldea.caldeaid AND
  tbl_pdf_imputado.nestadocivil = tbl_estadoscivil.ncivil AND
  tbl_pdf_imputado.ntipodocumento = tbl_tipodocumento.ndocumentoid AND
  tbl_pdf_imputado.netniaid = tbl_etnia.netniaid and 
  tbl_pdf_imputado.tdenunciaid = '$denuncia'"; 

$sqlOfendido= "SELECT 
  tbl_etnia.cdescripcion as etnia_ofendido, 
  tbl_discapacidad.cdescripcion as discapacidad_ofendido, 
  tbl_escolaridad.cdescripcion as esc_ofendido, 
  tbl_pdf_ofendido.cdocumentoid, 
  tbl_pdf_ofendido.cnombres as nomb_ofendido, 
  tbl_pdf_ofendido.capellidos as apellidos_ofendido, 
  tbl_pdf_ofendido.cgenero as gen_ofendido, 
  tbl_pdf_ofendido.iedad as edad_ofendido, 
  tbl_tipodocumento.cdescripcion, 
  tbl_pdf_ofendido.cunidadmedidaedad, 
  tbl_nacionalidad.cdescripcion as nac_ofendido, 
  tbl_estadoscivil.cdescripcion as estado_civil_ofendido, 
  tbl_ocupacion.cdescripcion as ocupacion_ofendido, 
  tbl_profesion.cdescripcion as prof_ofendido, 
  tbl_pdf_ofendido.ctelefono, 
  tbl_departamentopais.cdescripcion as depto_ofendido, 
  tbl_municipio.cdescripcion as municipio_ofendido, 
  tbl_aldea.cdescripcion as aldea_ofendido, 
  tbl_barrio.cdescripcion as barrio_ofendido,
  tbl_pdf_ofendido.cdetalle as direccion_ofendido,
  tbl_pdf_ofendido.tdenunciaid,
  tbl_pdf_ofendido.ntipodocumento,
  tbl_pdf_ofendido.cdocumentoid  
FROM 
  mini_sedi.tbl_pdf_ofendido, 
  mini_sedi.tbl_etnia, 
  mini_sedi.tbl_discapacidad, 
  mini_sedi.tbl_escolaridad, 
  mini_sedi.tbl_tipodocumento, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_estadoscivil, 
  mini_sedi.tbl_ocupacion, 
  mini_sedi.tbl_profesion, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_barrio
WHERE 
  tbl_pdf_ofendido.nprofesionid = tbl_profesion.nprofesionid AND
  tbl_pdf_ofendido.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_pdf_ofendido.nescolaridadid = tbl_escolaridad.nescolaridadid AND
  tbl_pdf_ofendido.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_pdf_ofendido.ndiscapacidadid = tbl_discapacidad.ndiscapacidadid AND
  tbl_pdf_ofendido.cdepartamentoid = tbl_departamentopais.cdepartamentoid AND
  tbl_pdf_ofendido.cdepartamentoid = tbl_municipio.cdepartamentoid AND
  tbl_pdf_ofendido.cmunicipioid = tbl_municipio.cmunicipioid AND
  tbl_pdf_ofendido.cdepartamentoid = tbl_barrio.cdepartamentoid AND
  tbl_pdf_ofendido.cmunicipioid = tbl_barrio.cmunicipioid AND
  tbl_pdf_ofendido.caldeaid = tbl_barrio.caldeaid AND
  tbl_pdf_ofendido.cbarrioid = tbl_barrio.cbarrioid AND
  tbl_pdf_ofendido.cdepartamentoid = tbl_aldea.cdepartamentoid AND
  tbl_pdf_ofendido.cmunicipioid = tbl_aldea.cmunicipioid AND
  tbl_pdf_ofendido.caldeaid = tbl_aldea.caldeaid AND
  tbl_pdf_ofendido.nestadocivil = tbl_estadoscivil.ncivil AND
  tbl_pdf_ofendido.ntipodocumento = tbl_tipodocumento.ndocumentoid AND
  tbl_pdf_ofendido.netniaid = tbl_etnia.netniaid and 
  tbl_pdf_ofendido.tdenunciaid = '$denuncia'"; 
exit($consulta);
$resultado=$conexion->consultar($consulta);	
$resultado1=$conexion->consultar($sqlDenunciante); //deunciante
$resultado2=$conexion->consultar($sqlOfendido); //ofendido
$resultado3=$conexion->consultar($sqlDenunciado); //denunciado

//crear un encabezado y un pie de pagina
class mipdf extends TCPDF{
    //Page header
    public function Header() {       
        // Logo
//        $image_file = K_PATH_IMAGES.'/mp_logo.png';
        $image_file = 'mp_logo.png';
        $this->Image($image_file, 0, 0, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', 'B', 15);        
        $this->Ln(30);
        $this->Cell(0, 0,'DENUNCIA COMPLETA', 0, false, 'C', 0, '', 0, false, 'M', 'M');        
        //resumen de usr
        // Set font
        $this->setPageUnit('mm');
        $this->SetFont('helvetica', '', 9);  
        $this->sety(44);
        $this->SetX(111);
        $usuario=$_SESSION['usuario'];
        $this->Cell(0, 0,'Usuario: '.$usuario, 0, 1, 'C', 0, '', 0, false, 'M', 'M');  
        $this->sety(47);
        $this->SetX(143);
        $this->Cell(0, 0,'Fecha impresión: '.date("d/m/Y").', '.date("H:i:s"), 0, 1, 'C', 0, '', 0, false, 'M', 'M');                
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->setPageUnit('mm');
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $denuncia=$_SESSION['denunciaid'];
        $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().', Denuncia: '
                .$denuncia, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }    
}

// create new PDF document
$pdf = new mipdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");
// set default header data
//$pdf->SetHeaderData('mp_logo.png', '30', 'DENUNCIA COMPLETA', 'Fecha: '.$fecha.'  Hora: '.$hora.'Usuario: '.$usuario.'               Número de Impresión: '.$impresion);
        // Logo
//        $image_file = K_PATH_IMAGES.'/mp_logo.png';
//        $this->Image($image_file, 90, 5, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//        // Set font
//        $this->SetFont('helvetica', 'B', 15);
        // Title
//        $this->Ln(30);
//        $this->Cell(0, 0,'DENUNCIA COMPLETA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9.5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins('5', '50', '5'); //margen izq, top y derecho
$pdf->SetHeaderMargin('15'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('5'); //configura el margen entre el pie de pag y fin de pag

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 10, '', true); //familia, estilo, tam, archivo fuente, fuente subconjunto

// Add a page
$pdf->AddPage();

// Set some content to print
if (pg_num_rows($resultado)>0){
        //inicia datos generales de la denuncia
	$html.='<strong>Datos Generales de la Denuncia</strong><br>
			<table align="center" border="1" id="denuncia">			
				<tr>
                                    <td colspan="4"><strong>Números de</strong></td><td colspan="2"><strong>Fechas</strong></td>
                                </tr>
                                <tr>
                                    <strong>
                                    <td>MP</td>
                                    <td>SEDI</td>
                                    <td>Policial</td>
                                    <td>Judicial</td>

                                    <td>Denuncia</td>
                                    <td>Hecho</td>
                                    </strong>
				</tr>';
	$i=0;
	$row=pg_fetch_assoc($resultado);
        $fdenuncia= substr($row[dfechadenuncia],8,2)."/".
                                substr($row[dfechadenuncia],5,2)."/".substr($row[dfechadenuncia],0,4);
        $fhecho= substr($row[$row[dfechahecho]],8,2)."/".
                                substr($row[$row[dfechahecho]],5,2)."/".substr($row[$row[dfechahecho]],0,4);
	$html.="<tr>
				<td>$row[tdenunciaid]</td>
				<td>$row[cexpedientesedi]</td>
				<td>$row[cexpedientepolicial]</td>
                                <td>$row[cexpedientejudicial]</td>
                                                                
                                <td>$fdenuncia</td>
                                <td>$fhecho</td>
                </tr>";

        $html.="</table><br>";
        
        $html.='<table align="left" border="1" id="lugardenuncia">';
        
	$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[cdeptodenuncia]'");
	$rowTemp=pg_fetch_assoc($resultadosTemp);
        $depto= $rowTemp[cdescripcion];
        
        $resultadosTemp1=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[cmunicipiodenuncia]' and cdepartamentoid='$row[cdeptodenuncia]'");
        $rowTemp1=pg_fetch_assoc($resultadosTemp1);
        $muni= $rowTemp1[cdescripcion];
        
	$resultadosTemp=$conexion->consultar("select * from tbl_lugarrecepcion where nlugarid='$row[nlugarrecepcion]'");
	$rowTemp2=pg_fetch_assoc($resultadosTemp);
        $lugar= $rowTemp2[cdescripcion];
        
        $html.='<tr><td><strong>Denuncia tomada en</strong></td></tr><tr><td>';
        $html.="$lugar, Departamento de $depto municipio $muni"."</td></tr> </table><br>";
        
        $html.='<table align="left" border="1" id="lugarhecho">';
        
	$resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp4=pg_fetch_assoc($resultadosTemp);
        
	$resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[cmunicipiohecho]' and cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp3=pg_fetch_assoc($resultadosTemp);
        
	$resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[caldeahecho]' and cmunicipioid='$row[cmunicipiohecho]' and cdepartamentoid='$row[cdeptohecho]'");
	$rowTemp2=pg_fetch_assoc($resultadosTemp);
        
	$resultadosTemp=$conexion->consultar("select * from tbl_barrio where caldeaid='$row[caldeahecho]' and cmunicipioid='$row[cmunicipiohecho]' and cdepartamentoid='$row[cdeptohecho]' and cbarrio='$row[ccaseriohecho]'");
	$rowTemp1=pg_fetch_assoc($resultadosTemp);        
        
        $html.='<tr><td><strong>Hecho ocurrido en</strong></td></tr><tr><td>';
        $html.="$rowTemp1[cdescripcion] $rowTemp2[cdescripcion] $rowTemp3[cdescripcion] $rowTemp4[cdescripcion]</td></tr>";
        $html.='</table><br>';
        
        //narracion de hechos
        $hechos= $row[cnarracionhecho];
        
        //fin datos generales de la denuncia
        
        //inicio datos del denunciante    
	$resultado=$resultado1;
	while ($row=pg_fetch_assoc($resultado)){
            $html.='<strong>Datos Generales del denunciante</strong><br>
                    <table align="left" border="1" id="denunciante">';	
            
            //sexo
            if ($row['gen_denunciante']=="m"){
                $sexo= 'Masculino';
            }else{
                $sexo= 'Femenino';
            }
            
            //escolaridad
//            $resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where nescolaridadid='$row[esc_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $esc_denunciante= $rowTemp['cdescripcion'];   
            $esc_denunciante= $row[esc_denunciante];
            
            //nacionalidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where cnacionalidadid='$row[nac_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $nac_denunciante= $rowTemp['cdescripcion'];      
            $nac_denunciante= $row[nac_denunciante];
            
            //estado civil
//            $resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where ncivil='$row[estado_civil_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $estado_civil_denunciante= $rowTemp['cdescripcion'];
            $estado_civil_denunciante= $row[estado_civil_denunciante];
                
            //profesion
            $resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_denunciante]'");
            $rowTemp=pg_fetch_assoc($resultadosTemp);
            $prof_denunciante= $rowTemp['cdescripcion'];
            $prof_denunciante= $row[prof_denunciante];
                
            //ocupacion
//            $resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $ocupacion_denunciante= $rowTemp['cdescripcion'];  
            $ocupacion_denunciante= $row[ocupacion_denunciante];
            
            //etnia
//            $resultadosTemp=$conexion->consultar("select * from tbl_etnia where netniaid='$row[etnia_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $etnia_denunciante =$rowTemp['cdescripcion'];
            $etnia_denunciante = $row[etnia_denunciante];
		
            //discapacidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where ndiscapacidadid='$row[discapacidad_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $discapacidad_denunciante= $rowTemp['cdescripcion'];   
            $discapacidad_denunciante= $row[discapacidad_denunciante];
            
            //tipo de documento
            $resultadosTemp=$conexion->consultar("select * from tbl_tipodocumento where ndocumentoid='$row[ntipodocumento]'");
            $rowTemp=pg_fetch_assoc($resultadosTemp);
            $tipo_documento= $rowTemp['cdescripcion'];             
            
            //direccion depto, municipio, aldea, barrio
//            $resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[depto_denunciante]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $deptoid=$row['depto_denunciante'];
//            $depto_denunciante= $rowTemp['cdescripcion'];
            $depto_denunciante= $row[depto_denunciante];

//            $resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[municipio_denunciante]' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $municipioid=$row['municipio_denunciante'];
//            $municipio_denunciante= $rowTemp['cdescripcion'];
            $municipio_denunciante= $row['municipio_denunciante'];

//            $resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[aldea_denunciante]' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $aldeaid=$row['aldea_denunciante'];
//            $aldea_denunciante= $rowTemp['cdescripcion'];
            $aldea_denunciante= $row[aldea_denunciante];

//            $resultadosTemp=$conexion->consultar("select * from tbl_barrio where cbarrioid='$row[barrio_denunciante]' and caldeaid='$aldeaid' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $barrio_denunciante= $rowTemp['cdescripcion'];    
            $barrio_denunciante= $row[barrio_denunciante];
            
            $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[nomb_denunciante]</td></tr>";
            $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[apellidos_denunciante]</td></tr>";
            $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_denunciante</td><td><strong>Discapacidad</strong></td><td>$discapacidad_denunciante</td></tr>";
                        
            $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$esc_denunciante</td></tr>";
            $html.="<tr><td><strong>Documento identificación</strong></td><td>$tipo_documento</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";
                        
            if ($row[cunidadmedidaedad]== 'a')
                $row[cunidadmedidaedad]= 'años';
            else
                if ($row[cunidadmedidaedad]== 'm')
                    $row[cunidadmedidaedad]= 'meses';
                else
                    if ($row[cunidadmedidaedad]== 'd')
                        $row[cunidadmedidaedad]= 'días';
                    else
                        $row[cunidadmedidaedad]= '';
                    
            $html.="<tr><td><strong>Sexo</strong></td><td>$sexo</td><td><strong>Edad</strong></td><td>$row[edad_denunciante] $row[cunidadmedidaedad]</td></tr>";
            $html.="<tr><td><strong>Nacionalidad</strong></td><td>$nac_denunciante</td><td><strong>Estado civil</strong></td><td>$estado_civil_denunciante</td></tr>";            
            
            $html.="<tr><td><strong>Profesión</strong></td><td>$prof_denunciante</td><td><strong>Oficio</strong></td><td>$ocupacion_denunciante</td></tr>";
            $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$depto_denunciante, $municipio_denunciante,  $aldea_denunciante,  $barrio_denunciante</td></tr>";            
            $html.="<tr><td><strong></strong></td><td colspan=\"3\"></td>$row[direccion_denunciante]</tr>";            
            
            $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
            $html.="</table><br>";

	//fin datos denunciante
        }
        
        //inicio datos del ofendido    
	$resultado=$resultado2;
	while ($row=pg_fetch_assoc($resultado)){
            $html.='<strong>Datos Generales del ofendido</strong><br>
                    <table align="left" border="1" id="ofendido">';	
            
            //sexo
            if ($row['gen_ofendido']=="m"){
                $sexo= 'Masculino';
            }else{
                $sexo= 'Femenino';
            }
            
            //escolaridad
//            $resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where nescolaridadid='$row[esc_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $esc_ofendido= $rowTemp['cdescripcion'];      
            $esc_ofendido= $row[esc_ofendido];
            
            //nacionalidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where cnacionalidadid='$row[nac_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $nac_ofendido= $rowTemp['cdescripcion'];            
            $nac_ofendido= $row[nac_ofendido];
            
            //estado civil
//            $resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where ncivil='$row[estado_civil_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $estado_civil_ofendido= $rowTemp['cdescripcion'];
            $estado_civil_ofendido= $row[estado_civil_ofendido];
                
            //profesion
//            $resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $prof_ofendido= $rowTemp['cdescripcion'];
            $prof_ofendido= $row[prof_ofendido];
                
            //ocupacion
//            $resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $ocupacion_ofendido= $rowTemp['cdescripcion'];  
            $ocupacion_ofendido= $row[ocupacion_ofendido];
            
            //etnia
//            $resultadosTemp=$conexion->consultar("select * from tbl_etnia where netniaid='$row[etnia_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $etnia_ofendido =$rowTemp['cdescripcion'];
            $etnia_ofendido = $row[etnia_ofendido];
		
            //discapacidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where ndiscapacidadid='$row[discapacidad_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $discapacidad_ofendido= $rowTemp['cdescripcion'];  
            $discapacidad_ofendido= $row[discapacidad_ofendido];
            
            //tipo de documento
            $resultadosTemp=$conexion->consultar("select * from tbl_tipodocumento where ndocumentoid='$row[ntipodocumento]'");
            $rowTemp=pg_fetch_assoc($resultadosTemp);
            $tipo_documento= $rowTemp['cdescripcion'];             

            
            //direccion depto, municipio, aldea, barrio
//            $resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[depto_ofendido]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $deptoid=$row['depto_ofendido'];
//            $depto_ofendido= $rowTemp['cdescripcion'];
            $depto_ofendido= $row[depto_ofendido];

//            $resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[municipio_ofendido]' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $municipioid=$row['municipio_ofendido'];
//            $municipio_ofendido= $rowTemp['cdescripcion'];
            $municipio_ofendido= $row[municipio_ofendido];

//            $resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[aldea_ofendido]' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $aldeaid=$row['aldea_ofendido'];
//            $aldea_ofendido= $rowTemp['cdescripcion'];
            $aldea_ofendido= $row[aldea_ofendido];

//            $resultadosTemp=$conexion->consultar("select * from tbl_barrio where cbarrioid='$row[barrio_ofendido]' and caldeaid='$aldeaid' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $barrio_ofendido= $rowTemp['cdescripcion'];            
            $barrio_ofendido= $row[barrio_ofendido];
            
            $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[nomb_ofendido]</td></tr>";
            $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[apellidos_ofendido]</td></tr>";
            $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_ofendido</td><td><strong>Discapacidad</strong></td><td>$discapacidad_ofendido</td></tr>";
                        
            $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$esc_ofendido</td></tr>";
            $html.="<tr><td><strong>Documento identificación</strong></td><td>$tipo_documento</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";
                        
            if ($row[cunidadmedidaedad]== 'a')
                $row[cunidadmedidaedad]= 'años';
            else
                if ($row[cunidadmedidaedad]== 'm')
                    $row[cunidadmedidaedad]= 'meses';
                else
                    if ($row[cunidadmedidaedad]== 'd')
                        $row[cunidadmedidaedad]= 'días';
                    else
                        $row[cunidadmedidaedad]= '';
                    
            $html.="<tr><td><strong>Sexo</strong></td><td>$sexo</td><td><strong>Edad</strong></td><td>$row[edad_ofendido] $row[cunidadmedidaedad]</td></tr>";
            $html.="<tr><td><strong>Nacionalidad</strong></td><td>$nac_ofendido</td><td><strong>Estado civil</strong></td><td>$estado_civil_ofendido</td></tr>";            
            
            $html.="<tr><td><strong>Profesión</strong></td><td>$prof_ofendido</td><td><strong>Oficio</strong></td><td>$ocupacion_ofendido</td></tr>";
            $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$depto_ofendido, $municipio_ofendido,  $aldea_ofendido,  $barrio_ofendido</td></tr>";            
            $html.="<tr><td><strong></strong></td><td colspan=\"3\"></td>$row[direccion_ofendido]</tr>";            
            
            $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
            $html.="</table><br>";

	//fin datos ofendido
        }
        
       
        //inicio datos del denunciado  
        $contaimputado= 1;
	$resultado=$resultado3;
	while ($row=pg_fetch_assoc($resultado)){
            $html.="<strong>Datos Generales del denunciado número $contaimputado</strong><br>";
            $html.='<table align="left" border="1" id="imputado">';
            
            //imputado id (clave primaria)
            $personaid_imputado= $row['personaid_imputado'];
            
            //sexo
            if ($row['gen_imputado']=="m"){
                $sexo= 'Masculino';
            }else{
                $sexo= 'Femenino';
            }
            
            //escolaridad
//            $resultadosTemp=$conexion->consultar("select * from tbl_escolaridad where nescolaridadid='$row[esc_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $esc_denunciado= $rowTemp['cdescripcion'];   
            $esc_denunciado= $row[esc_denunciado];
            
            //nacionalidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_nacionalidad where cnacionalidadid='$row[nac_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $nac_denunciado= $rowTemp['cdescripcion'];            
            $nac_denunciado= $row[nac_denunciado];
            
            //estado civil
//            $resultadosTemp=$conexion->consultar("select * from tbl_estadoscivil where ncivil='$row[estado_civil_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $estado_civil_denunciado= $rowTemp['cdescripcion'];
            $estado_civil_denunciado= $row[estado_civil_denunciado];
                
            //profesion
//            $resultadosTemp=$conexion->consultar("select * from tbl_profesion where nprofesionid='$row[prof_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $prof_denunciado= $rowTemp['cdescripcion'];
            $prof_denunciado= $row[prof_denunciado];
                
            //ocupacion
//            $resultadosTemp=$conexion->consultar("select * from tbl_ocupacion where nocupacionid='$row[ocupacion_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $ocupacion_denunciado= $rowTemp['cdescripcion'];  
            $ocupacion_denunciado= $row[ocupacion_denunciado];
            
            //etnia
//            $resultadosTemp=$conexion->consultar("select * from tbl_etnia where netniaid='$row[etnia_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $etnia_denunciado =$rowTemp['cdescripcion'];
            $etnia_denunciado = $row[etnia_denunciado];
		
            //discapacidad
//            $resultadosTemp=$conexion->consultar("select * from tbl_discapacidad where ndiscapacidadid='$row[discapacidad_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $discapacidad_denunciado= $rowTemp['cdescripcion'];       
            $discapacidad_denunciado = $row[discapacidad_denunciado];
            
            //tipo de documento
            $resultadosTemp=$conexion->consultar("select * from tbl_tipodocumento where ndocumentoid='$row[ntipodocumento]'");
            $rowTemp=pg_fetch_assoc($resultadosTemp);
            $tipo_documento= $rowTemp['cdescripcion'];   
            
            //direccion depto, municipio, aldea, barrio
//            $resultadosTemp=$conexion->consultar("select * from tbl_departamentopais where cdepartamentoid='$row[depto_denunciado]'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $deptoid=$row['depto_denunciado'];
//            $depto_denunciado= $rowTemp['cdescripcion'];
            $depto_denunciado= $row[depto_denunciado];

//            $resultadosTemp=$conexion->consultar("select * from tbl_municipio where cmunicipioid='$row[municipio_denunciado]' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $municipioid=$row['municipio_denunciado'];
//            $municipio_denunciado= $rowTemp['cdescripcion'];
            $municipio_denunciado = $row[municipio_denunciado];

//            $resultadosTemp=$conexion->consultar("select * from tbl_aldea where caldeaid='$row[aldea_denunciado]' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $aldeaid=$row['aldea_denunciado'];
//            $aldea_denunciado= $rowTemp['cdescripcion'];
            $aldea_denunciado = $row[aldea_denunciado];

//            $resultadosTemp=$conexion->consultar("select * from tbl_barrio where cbarrioid='$row[barrio_denunciado]' and caldeaid='$aldeaid' and cmunicipioid='$municipioid' and cdepartamentoid='$deptoid'");
//            $rowTemp=pg_fetch_assoc($resultadosTemp);
//            $barrio_denunciado= $rowTemp['cdescripcion'];     
            $barrio_denunciado = $row[barrio_denunciado];
            
            $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[nomb_denunciado]</td></tr>";
            $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[apellidos_denunciado]</td></tr>";
            $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_denunciado</td><td><strong>Discapacidad</strong></td><td>$discapacidad_denunciado</td></tr>";
                        
            $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$esc_denunciado</td></tr>";
            $html.="<tr><td><strong>Documento identificación</strong></td><td>$tipo_documento</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";
                        
            if ($row[cunidadmedidaedad]== 'a')
                $row[cunidadmedidaedad]= 'años';
            else
                if ($row[cunidadmedidaedad]== 'm')
                    $row[cunidadmedidaedad]= 'meses';
                else
                    if ($row[cunidadmedidaedad]== 'd')
                        $row[cunidadmedidaedad]= 'días';
                    else
                        $row[cunidadmedidaedad]= '';
                    
            $html.="<tr><td><strong>Sexo</strong></td><td>$sexo</td><td><strong>Edad</strong></td><td>$row[edad_denunciado] $row[cunidadmedidaedad]</td></tr>";
            $html.="<tr><td><strong>Nacionalidad</strong></td><td>$nac_denunciado</td><td><strong>Estado civil</strong></td><td>$estado_civil_denunciado</td></tr>";            
            
            $html.="<tr><td><strong>Profesión</strong></td><td>$prof_denunciado</td><td><strong>Oficio</strong></td><td>$ocupacion_denunciado</td></tr>";
            $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$depto_denunciado, $municipio_denunciado,  $aldea_denunciado,  $barrio_imputado</td></tr>";            
            $html.="<tr><td><strong></strong></td><td colspan=\"3\"></td>$row[direccion_imputado]</tr>";            
            
            $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
            $html.="</table><br>";
        
            $html.='</table><br>';
            $contaimputado++;
        }
	//fin datos denunciado     

        //narración de hechos, el dato se captura en el select inicial (ver inicio del programa)        
        $html.='<strong>Narración de hechos</strong><br>';
        $html.="<table align=\"left\" border=\"1\" id=\"hechos\">";
            $html.= "<tr><td>$hechos</td></tr>";
        $html.="</table><br>";      
        
            
        //delitos, relacion entre denunciados y delitos
//        $resultadoDelitos=$conexion->consultar("select tbl_pdf_denuncia.tdenunciaid, tbl_delito.ndelitoid, tbl_delito.cdescripcion from tbl_pdf_denuncia inner join tbl_pdf_imputado_delito on 
//        tbl_pdf_denuncia.tdenunciaid=tbl_pdf_imputado_delito.tdenunciaid inner join
//        tbl_delito on tbl_pdf_imputado_delito.ndelito=tbl_delito.ndelitoid where tbl_pdf_denuncia.tdenunciaid='$denuncia' and tbl_pdf_imputado_delito.tpersonaid= $personaid_imputado");            

        $resultadoDelitos=$conexion->consultar("SELECT 
                tbl_delito.cdescripcion, 
                tbl_imputado.cnombres, 
                tbl_imputado.capellidos, 
                tbl_imputado_delito.tdenunciaid, 
                tbl_imputado_delito.tpersonaid
              FROM 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_imputado
              WHERE 
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_imputado_delito.tpersonaid = tbl_imputado.tpersonaid AND
                tbl_imputado_delito.tdenunciaid = tbl_imputado.tdenunciaid  AND
                tbl_imputado.tdenunciaid = '$denuncia' order by tpersonaid");        

        $contaimputado= 1;
        $rowDelitos=pg_fetch_assoc($resultadoDelitos);
        $Registros= pg_num_rows($resultadoDelitos);        
        while($Registros > 0){
            $html.= '<table align="left" border="1">';
            $html.= "<tr><td><strong>Supuestos delitos cometidos por el denunciado, número $contaimputado:</strong><br>
                    <i>$rowDelitos[cnombres] $rowDelitos[capellidos]</i>
                    </td></tr>";
                                    
            $actual= $rowDelitos[tpersonaid];
            while ($actual == $rowDelitos[tpersonaid]){                
                $html.="<tr>
                                <td>   $rowDelitos[cdescripcion]</td>
                        </tr>";	
                $Registros--;
                $rowDelitos=pg_fetch_assoc($resultadoDelitos);
            }
            $contaimputado++;
            $html.='</table><br>';
        }   
        $html.= "<br><br><br><br>";
        
        $html.= '<table align="center" border="0">
                <tr><td><strong>Receptor</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td><strong>Denunciante</strong></td></tr>
                </table>';
}

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Denuncia '.$denuncia.' Completa.pdf', 'I');
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+