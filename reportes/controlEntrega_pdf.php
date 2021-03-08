<?php
session_start(); 
ob_start();
require('../fpdf/fpdf.php');
include_once "../clases/class_conexion_pg.php";
$conexion=new Conexion();
$usuario=$_SESSION['usuario'];
$bandeja= $_SESSION['bandeja'];
$oficina= $_SESSION['oficina'];
        

if (isset($_GET['var'])){
    $denuncia= $_GET['var'];
    
}


$sql= "SELECT DISTINCT td.tdenunciaid , td2.cnombres || ', ' || td2.capellidos as denunciante,
                     ti.cnombres || ', ' || ti.capellidos AS denunciado, td3.cdescripcion as delito 
                   FROM mini_sedi.tbl_denuncia td 
                   INNER JOIN mini_sedi.tbl_denunciante td2 ON td2.tdenunciaid= td.tdenunciaid
                   INNER JOIN mini_sedi.tbl_imputado ti on ti.tdenunciaid =td.tdenunciaid 
                   INNER JOIN mini_sedi.tbl_imputado_delito tid ON tid.tdenunciaid = ti.tdenunciaid 
                   INNER JOIN mini_sedi.tbl_delito td3 ON td3.ndelitoid = tid.ndelito 
                   INNER JOIN mini_sedi.tbl_bandejas tb ON tb.ibandejaid = td.ibandejaid 
                   INNER JOIN mini_sedi.tbl_imputado_fiscalia tif on tif.tdenunciaid = td.tdenunciaid 
                   WHERE td.tdenunciaid= '$denuncia'";

     $rspta= $conexion->ejecutarComando($sql);


class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../imagenes/logo_mp_transparente.png',70, 10,75, 45, 'PNG');
    // Arial bold 15
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(35, 25, utf8_decode('REPORTE DE CONTROL DE ENTREGA DE DENUNCIAS'), 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
}


 // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'B', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

    }


    //funcion para ajustar el texto en las celadas
    function myCell ($w,$h,$x,$t){
        $height =$h/3;
        $first = $height+2;
        $second = $height+$height+$height+$height+3;
        $len = strlen($t);
      
        if($len>20){ 
            $txt = str_split($t,20);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB','0','C','0');
        }else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB','0','C','0');
        }          
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$fecha_actual =  new dateTime();

//fecha = $fecha_actual->format('Y-m-d'); //H:i:s
$fecha = $fecha_actual->format("d-m-Y H:i:s");


        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(5);
        $pdf->Cell(50, 10, '' . $fecha . '', 0);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(80);
        $pdf->Cell(30, 8, utf8_decode('Oficina Que Recibe:  ').$oficina, 0, 0, 'C');
        $pdf->Ln();
        
        $pdf->Cell(80);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(30, 8, 'Usuario Que Recibe:  ' . $usuario   , 0, 0, 'C');
        $pdf->Ln(1);
        $pdf->Cell(0, 8, '', 'B', 0, 'L');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(25, 8, 'DENUNCIA', 1, 0, 'C', true);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(55, 8, 'DENUNCIANTE', 1, 0, 'C',true);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(55, 8, 'DENUNCIADO', 1, 0, 'C', true);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(55, 8, 'DELITO', 1, 0, 'C', true);
        $pdf->Ln(8);
        
        $pdf->SetFont('Times','',8);

        $w=30;
        $h=8;

       
        while($row=pg_fetch_assoc($rspta)){
          $pdf->Cell(25, 8, $row['tdenunciaid'], 1,0, 'C');
          $pdf->Cell(55, 8, utf8_decode($row['denunciante']), 1, 0, 'C');
          $pdf->Cell(55, 8, utf8_decode($row['denunciado']), 1, 0, 'C');
          $pdf->Cell(55, 8, utf8_decode($row['delito']), 1, 0, 'C');
          $pdf->Ln(8);
          
         }
         

$pdf->Output('REPORTE_ENTREGA.pdf', 'I');

?>