<?php 
ob_end_clean();     
require_once('tcpdf/tcpdf.php');
require_once('../clases/class_conexion_pg.php');
session_start();


class PDF extends TCPDF
{
//Cabecera de página
   function Header()
   {
       // Logo 
       $this->Image('mp_logo2.png' , 30,18,30,30,'PNG', '');
        
        // Set font
        $this->SetFont('helvetica','BI',20);       
        $this->Ln(10);
        $this->Cell(182,9,'MINISTERIO PUBLICO',0,0,'C'); 
        $this->SetFont('helvetica','B',15);  
        $this->Ln(5);
        $this->Cell(0,12,'Republica de Honduras',0,0,'C');
        $this->Ln(3);
        $this->SetFont('helvetica','B',15);  
        $this->Cell(0,18,'Reporte Remision de Denuncias',0,0,'C');
        
        $this->Ln(5);
        //resumen de usr
        $this->SetFont('helvetica', '', 9);  
        $desde = $_POST['txtInicio']; 
        $hasta = $_POST['txtFin']; 
        $this->SetX(85);
        $this->Cell(200,18,'Desde: '.$desde.' Hasta: '.$hasta);
        
        // Set font
//        $this->SetFont('helvetica', '', 9);  
        $this->Sety(44);
        $this->SetX(145);
        
        $usuario=$_SESSION['usuario'];
        $this->Cell(0, 0,'Usuario: '.$usuario, 0, 1, 'C', 0, '', 0, false, 'M', 'M');  
        $this->Sety(47);
        $this->SetX(163);
        $this->Cell(0, 0,'Fecha impresión: '.date("d/m/Y"), 0, 1, 'C', 0, '', 0, false, 'M', 'M'); 

        //Cabecera
        $this->Cell(0,10,'');
        $this->Ln(3);
        $this->SetFont('helvetica','B',10);
        $this->Cell(20,7,'#Orden',1,0,'C');
        $this->Cell(25,7,'#Denuncia',1,0,'C');
        $this->Cell(35,7,'Fiscalia Destino',1,0,'C');
        $this->Cell(35,7,'Recibe',1,0,'C');
        $this->Cell(35,7,'Firma',1,0,'C');
        $this->Cell(30,7,'Hora/Fecha',1,0,'C');
        
        $this->SetY(50);
      
   }
   
   //Pie de página
   function Footer()
   {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //helvetica italic 8
    $this->SetFont('helvetica','I',8);
    //Número de página
    $this->Cell(0,10,'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0,0,'C');
   }
   
   //Tabla simple

   function TablaSimple()
   {
        $conexion= new Conexion();
       
        $bandeja =  $_SESSION['bandeja'];
        $desde = $_POST['txtInicio']; 
        $hasta = $_POST['txtFin']; 
        $desde= substr($desde, 6, 4).substr($desde, 3, 2).substr($desde, 0, 2);
        $hasta= substr($hasta, 6, 4).substr($hasta, 3, 2).substr($hasta, 0, 2);   
        
        $query = "SELECT tdenunciaid, cdescripcion, ibandejaid, dfechadenuncia, basignadofiscal
            FROM mini_sedi.reporte_remision_de_denuncia 
            WHERE ibandejaid = $bandeja and
            dfechadenuncia between '$desde' and '$hasta' AND
            basignadofiscal = false
            ORDER BY cdescripcion,
            dfechadenuncia;";
        //exit($query);
        $resultado= $conexion->ejecutarProcedimiento($query);        

        $this->Ln();
        $orden= 1; 
        
        while ($fila = pg_fetch_array($resultado))
        {
           $this->Cell(20,9,"$orden",1);
           $this->Cell(25,9,$fila['tdenunciaid'],1);
           $this->Cell(35,9,$fila['cdescripcion'],1);
           $this->Cell(35,9,"",1);
           $this->Cell(35,9,"",1);
           $this->Cell(30,9,"",1);
           $orden = $orden+1;
           $this->Ln();
        }
    }
}
$pdf = new PDF('P','mm', 'Letter');
$pdf->SetMargins('20', '59', '5'); //margen izq, top y derecho
$pdf->SetHeaderMargin('9'); //configura el margen entre el encabezado y la pagina
$pdf->SetFooterMargin('5'); //configura el margen entre el pie de pag y fin de pag

$pdf->AddPage();
$pdf->TablaSimple();
$pdf->Output('Reporte de remisión de denuncias','I');
//============================================================+
// END OF FILE
//============================================================+
?>
