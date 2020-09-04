<?php session_start();
//funciones genericas
require_once('tcpdf/tcpdf.php');
include "../funciones/php_funciones.php";
//include "../clases/class_conexion_pg.php";

$pcboBarrio2= '%';  
$pcboAldea2= '%';      
$pcboMuni2= '%';    
$pcboDepto2= '%';

if (empty($_POST['cboDelitos'])){
    $pcboDelitos1= 0;
    $pcboDelitos2= 999;
    
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia";    
}
else{
    $pcboDelitos1= $_POST['cboDelitos'];
    $pcboDelitos2= $_POST['cboDelitos'];    
}

if (!empty($_POST['txtFechaFin'])){
    $ptxtFechaFin= TxtFechaANSI($_POST['txtFechaFin']);
}

if (!empty($_POST['txtFechaInicio'])){
    $ptxtFechaInicio= TxtFechaANSI($_POST['txtFechaInicio']);    
}    

if (!empty($_POST['cboBarrio2'])){
    $pcboBarrio2= $_POST['cboBarrio2'];  
//    $pcboAldea2= '%';      
//    $pcboMuni2= '%';    
//    $pcboDepto2= '%';    
    
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_departamentopais, 
            mini_sedi.tbl_municipio, 
            mini_sedi.tbl_aldea, 
            mini_sedi.tbl_barrio";
    
    $where= " tbl_departamentopais.cdepartamentoid = tbl_municipio.cdepartamentoid AND
    tbl_departamentopais.cdepartamentoid = tbl_aldea.cdepartamentoid AND
    tbl_departamentopais.cdepartamentoid = tbl_barrio.cdepartamentoid AND
    tbl_aldea.caldeaid = tbl_barrio.caldeaid AND
    tbl_municipio.cmunicipioid = tbl_aldea.cmunicipioid AND
    tbl_municipio.cmunicipioid = tbl_barrio.cmunicipioid AND
    tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
    tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
    tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
    tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
    tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
    tbl_imputado_delito.ndelito = tbl_delito.ndelitoid and 
    tbl_denuncia.dfechadenuncia >= '$ptxtFechaInicio' and tbl_denuncia.dfechadenuncia <= '$ptxtFechaFin' and 
    tbl_denuncia.cdeptodenuncia like '$pcboDepto2' and  tbl_denuncia.cmunicipiodenuncia like '$pcboMuni2' and 
    tbl_denuncia.caldeahecho like '$pcboAldea2' and tbl_denuncia.ccaseriohecho like '$pcboBarrio2' and
    tbl_imputado_delito.ndelito >= $pcboDelitos1 and tbl_imputado_delito.ndelito <= $pcboDelitos2 ";
        
//    echo 'barrio ';
}    
elseif (!empty($_POST['cboAldea2'])){
    $pcboBarrio2= $_POST['cboBarrio2'];  
    $pcboAldea2= $_POST['cboAldea2'];      
//    $pcboMuni2= '%';    
//    $pcboDepto2= '%';   
    
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_departamentopais, 
            mini_sedi.tbl_municipio, 
            mini_sedi.tbl_aldea, 
            mini_sedi.tbl_barrio"; 
    
    $where= " tbl_departamentopais.cdepartamentoid = tbl_municipio.cdepartamentoid AND
        tbl_departamentopais.cdepartamentoid = tbl_aldea.cdepartamentoid AND
        tbl_departamentopais.cdepartamentoid = tbl_barrio.cdepartamentoid AND
        tbl_aldea.caldeaid = tbl_barrio.caldeaid AND
        tbl_municipio.cmunicipioid = tbl_aldea.cmunicipioid AND
        tbl_municipio.cmunicipioid = tbl_barrio.cmunicipioid AND
        tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
        tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
        tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
        tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
        tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
        tbl_imputado_delito.ndelito = tbl_delito.ndelitoid and 
        tbl_denuncia.dfechadenuncia >= '$ptxtFechaInicio' and tbl_denuncia.dfechadenuncia <= '$ptxtFechaFin' and 
        tbl_denuncia.cdeptodenuncia like '$pcboDepto2' and  tbl_denuncia.cmunicipiodenuncia like '$pcboMuni2' and 
        tbl_denuncia.caldeahecho like '$pcboAldea2' and
        tbl_imputado_delito.ndelito >= $pcboDelitos1 and tbl_imputado_delito.ndelito <= $pcboDelitos2 ";  
         
//echo 'aldea ';    
}
elseif (!empty($_POST['cboMuni2'])){
    $pcboBarrio2= $_POST['cboBarrio2'];  
    $pcboAldea2= $_POST['cboAldea2'];     
    $pcboMuni2= $_POST['cboMuni2'];    
//    $pcboDepto2= '%'; 
    
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_departamentopais, 
            mini_sedi.tbl_municipio, 
            mini_sedi.tbl_aldea, 
            mini_sedi.tbl_barrio";
    
    $where= " tbl_departamentopais.cdepartamentoid = tbl_municipio.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_aldea.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_barrio.cdepartamentoid AND
            tbl_aldea.caldeaid = tbl_barrio.caldeaid AND
            tbl_municipio.cmunicipioid = tbl_aldea.cmunicipioid AND
            tbl_municipio.cmunicipioid = tbl_barrio.cmunicipioid AND
            tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
            tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
            tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
            tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid and 
            tbl_denuncia.dfechadenuncia >= '$ptxtFechaInicio' and tbl_denuncia.dfechadenuncia <= '$ptxtFechaFin' and 
            tbl_denuncia.cdeptodenuncia like '$pcboDepto2' and  tbl_denuncia.cmunicipiodenuncia like '$pcboMuni2' and 
            tbl_imputado_delito.ndelito >= $pcboDelitos1 and tbl_imputado_delito.ndelito <= $pcboDelitos2 ";    
      
//    echo 'municipio ';
}    
elseif (!empty($_POST['cboDepto2'])){
    $pcboBarrio2= $_POST['cboBarrio2'];  
    $pcboAldea2= $_POST['cboAldea2'];     
    $pcboMuni2= $_POST['cboMuni2'];    
    $pcboDepto2= $_POST['cboDepto2'];
    
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_departamentopais, 
            mini_sedi.tbl_municipio, 
            mini_sedi.tbl_aldea, 
            mini_sedi.tbl_barrio";
    
    $where= " tbl_departamentopais.cdepartamentoid = tbl_municipio.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_aldea.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_barrio.cdepartamentoid AND
            tbl_aldea.caldeaid = tbl_barrio.caldeaid AND
            tbl_municipio.cmunicipioid = tbl_aldea.cmunicipioid AND
            tbl_municipio.cmunicipioid = tbl_barrio.cmunicipioid AND
            tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
            tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
            tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
            tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid and 
            tbl_denuncia.dfechadenuncia >= '$ptxtFechaInicio' and tbl_denuncia.dfechadenuncia <= '$ptxtFechaFin' and 
            tbl_denuncia.cdeptodenuncia like '$pcboDepto2' and  
            tbl_imputado_delito.ndelito >= $pcboDelitos1 and tbl_imputado_delito.ndelito <= $pcboDelitos2 ";            

//    echo 'depto ';
}  
else { //OJO pidio toda la info... puede tardar un pijo
    $from= "mini_sedi.tbl_delito, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_departamentopais, 
            mini_sedi.tbl_municipio, 
            mini_sedi.tbl_aldea, 
            mini_sedi.tbl_barrio";
    
    $where= " tbl_departamentopais.cdepartamentoid = tbl_municipio.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_aldea.cdepartamentoid AND
            tbl_departamentopais.cdepartamentoid = tbl_barrio.cdepartamentoid AND
            tbl_aldea.caldeaid = tbl_barrio.caldeaid AND
            tbl_municipio.cmunicipioid = tbl_aldea.cmunicipioid AND
            tbl_municipio.cmunicipioid = tbl_barrio.cmunicipioid AND
            tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
            tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
            tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
            tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid and 
            tbl_denuncia.dfechadenuncia >= '$ptxtFechaInicio' and tbl_denuncia.dfechadenuncia <= '$ptxtFechaFin' and 
            tbl_imputado_delito.ndelito >= $pcboDelitos1 and tbl_imputado_delito.ndelito <= $pcboDelitos2 ";       
}
    
//if popcion= 1 then --a detalle de barrio
$sql= "SELECT 
        count(tbl_delito.cdescripcion) as frecuencia,
        tbl_delito.cdescripcion as delito,
        tbl_departamentopais.cdescripcion as departamento, 
        tbl_municipio.cdescripcion as municipio, 
        tbl_aldea.cdescripcion as ciudad,
        tbl_barrio.cdescripcion as barrio
        FROM ".$from.		  
        " WHERE ".$where.
	"group by
        tbl_delito.cdescripcion,
        tbl_departamentopais.cdescripcion, 
        tbl_municipio.cdescripcion, 
        tbl_aldea.cdescripcion,
        tbl_barrio.cdescripcion
	order by frecuencia desc;";
//exit($sql);
//crear un encabezado y un pie de pagina
class mipdf extends TCPDF{
    //Page header
    public function Header() {       
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.png';
	$image_file = K_PATH_IMAGES.'mp_logo.png';
        $this->Image($image_file, 90, 10, 30, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', 'B', 15);        
        $this->Ln(30);
        $this->Cell(0, 0,'FRECUENCIA DE DELITOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');        
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
        $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }    
}

// create new PDF document
$pdf = new mipdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

$fecha=date("d-m-Y");
$hora=date("H:i:s");

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

// contador de frecuencias
$Frecuencia= 0;

//hacer le reporte en si
$conexion= new Conexion();
$resultado=$conexion->ejecutarComando($sql);

$html.= "<br>";
$html.= "<table border= \"1\"> ";
$html.= "<thead>";
$html.= "<tr> ";
    $html.= "<th>Frecuencia</th>";
    $html.= "<th>Delito</th>";
    $html.= "<th>Departamento</th>";
    $html.= "<th>Municipio</th>";
    $html.= "<th>Ciudad/Aldea</th>";
    $html.= "<th>Barrio/Colonia</th>";
$html.= "</tr>";
$html.= "</thead>";
$html.= "<tbody>";
while($fila = pg_fetch_array($resultado)){    
    $html.= "<tr> ";
        $html.= "<td>$fila[frecuencia]</td>";
        $html.= "<td>$fila[delito]</td>";
        $html.= "<td>$fila[departamento]</td>";
        $html.= "<td>$fila[municipio]</td>";
        $html.= "<td>$fila[ciudad]</td>";
        $html.= "<td>$fila[barrio]</td>";
    $html.= "</tr>";
    $Frecuencia += $fila[frecuencia];
}
$html.= "<tr><td colspan='6'><br><b>Total frecuencia: </b> $Frecuencia </td></tr>";
$html.= "</tbody>";
$html.= '</table>';

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->Output('Denuncia '.$denuncia.' Completa.pdf', 'I');


echo $sql;
?>
