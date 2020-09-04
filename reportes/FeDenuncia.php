<?php
session_start(); 
include('conexion/cls_conexion.php');
require_once('tcpdf/tcpdf.php');
$denuncia=$_SESSION['denunciaid'];

if (isset($_GET['denunciaprn'])){
    $denuncia= $_GET['denunciaprn'];
}

$conexion=new cls_conexion();
$conexion->conectar();
$resultado;

$consulta= "SELECT 
  tbl_denunciante.cnombres, 
  tbl_denunciante.capellidos, 
  tbl_denunciante.cdocumentoid, 
  tbl_nacionalidad.cdescripcion, 
  tbl_tipodocumento.cdescripcion
FROM 
  mini_sedi.tbl_denunciante, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_tipodocumento
WHERE 
  tbl_denunciante.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_denunciante.ntipodocumento = tbl_tipodocumento.ndocumentoid and 
  tbl_denunciante.tdenunciaid= $denuncia;";


//crear un encabezado y un pie de pagina
class mipdf extends TCPDF{
    //Page header
    public function Header() {       
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.png';
	$image_file = K_PATH_IMAGES.'mp_logo.png'; 
        $this->Image($image_file, 98, 10, 38, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', 'B', 15);        
        $this->Ln(33);
        $this->Cell(0, 0,'DENUNCIA COMPLETA', 0, false, 'C', 0, '', 0, false, 'M', 'M');        
        //resumen de usr
        // Set font
        $this->setPageUnit('mm');
        $this->SetFont('helvetica', '', 9);  
        $this->sety(44);
        $this->SetX(145);
        $usuario=$_SESSION['usuario'];
        $this->Cell(0, 0,'Usuario: '.$usuario, 0, 1, 'C', 0, '', 0, false, 'M', 'M');  
        $this->sety(47);
        $this->SetX(163);
        $this->Cell(0, 0,'Fecha impresión: '.date("d/m/Y"), 0, 1, 'C', 0, '', 0, false, 'M', 'M');                
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

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9.5));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
//$pdf->SetMargins('5', '50', '5'); //margen izq, top y derecho
$pdf->SetMargins('20', '50', '5'); //margen izq, top y derecho
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
	$html.='<strong>DOCUMENTO DE FE DE DENUNCIA</strong><br><br><br>';
        
        //nombre del denunciante
        $html.= "<span style='text-align:justify;'> Y0 ,mayor de edad, de este domicilio, ";
        $html.= "con número de identidad o pasaporte de nacionalidad , ";
        $html.= "con número de teléfono en representación de , doy fe que ";
        $html.= "la información sunnistrada en la denuncia es real y han sucedido en la "; 
        $html.= "narrada, así como que no se han variado la información proporcionanda, "; 
        $html.= "no se ha suplnatado a personas, ni se trata de desfigurar los hehos "; 
        $html.= "relatados en la denuncia, por lo consiguiente ne responsabilizo de forma";
        $html.= "directa de cualquier perjuicio causado en el caso que proporcionaa ";
        $htmk.= "información o dnuncia falsa"; 
}       

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->Output('Denuncia '.$denuncia.' Completa.pdf', 'I');
?>

