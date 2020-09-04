<?php
session_start(); 
ob_start();
//include('conexion/cls_conexion.php');
include_once "../clases/class_conexion_pg.php";
require_once('tcpdf/tcpdf.php');
$denuncia=$_SESSION['denunciaid']; 
//$usuario=$_SESSION['usr'];
$usuario=$_SESSION['usuario'];
$impresion;

if (isset($_GET['denunciaprn'])){
    $denuncia= $_GET['denunciaprn'];
}

$archivo="impresiones_denuncia/denuncia$denuncia".".txt";

//$conexion=new cls_conexion();
$conexion=new Conexion();

$sqlDenuncia= "select * from mini_sedi.vw_denuncia where tdenunciaid = '$denuncia'"; 

$sqlDenunciante= "select * from mini_sedi.vw_denunciante where tdenunciaid = '$denuncia'"; 

$sqlDenunciado= "select * from mini_sedi.vw_denunciado where tdenunciaid = '$denuncia'"; 

$sqlOfendido= "select * from mini_sedi.vw_ofendido where tdenunciaid = '$denuncia'"; 

$sqlDelitos= "select * from mini_sedi.vw_delitos where tdenunciaid = '$denuncia' order by tpersonaid"; 

$resultado=$conexion->ejecutarComando($sqlDenuncia);	 //generales de la denuncia
$resultado1=$conexion->ejecutarComando($sqlDenunciante); //deunciante
$resultado2=$conexion->ejecutarComando($sqlOfendido); //ofendido
$resultado3=$conexion->ejecutarComando($sqlDenunciado); //denunciado
$resultado4=$conexion->ejecutarComando($sqlDelitos); //denunciado

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
        $this->Cell(0, 0,'DENUNCIA COMPLETA pdf', 0, false, 'C', 0, '', 0, false, 'M', 'M');        
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

//generar la denuncia para imprimir
if (pg_num_rows($resultado)>0){    
	$i=0;
	$row=pg_fetch_assoc($resultado);
        $fdenuncia= substr($row[dfechadenuncia],8,2)."/".
                                substr($row[dfechadenuncia],5,2)."/".substr($row[dfechadenuncia],0,4);
        $fdenuncia.= " $row[thoradenuncia]";
        
        if (substr($row[dfechahecho],0,4) > 1900){
            $fhecho= substr($row[dfechahecho],8,2)."/".
                                substr($row[dfechahecho],5,2)."/".substr($row[dfechahecho],0,4);
            $fhecho.= " $row[thorahecho]";
        }
        else
            $fhecho= '';
        
        //inicia datos generales de la denuncia        
	$html.='<strong>Datos Generales de la Denuncia</strong><br>';
        $html.='<table align="center" border="1">';
        $html.= "<tr><td><strong>Fecha de la denuncia:</strong> $fdenuncia</td>"
                . "<td><strong>Fecha del hecho:</strong> $fhecho</td></tr></table><br>";
	$html.= '<table align="center" border="1" id="denuncia">			
				<tr>
                                    <td colspan="6"><strong>Números de</strong></td>
                                </tr>
                                <tr>                                    
                                    <td><strong>MP</strong></td>
                                    <td><strong>SEDI</strong></td>
                                    <td><strong>Policial</strong></td>
                                    <td><strong>Judicial</strong></td>
                                    <td><strong>Levatamiento</strong></td>
                                    <td><strong>Reporte Tránsito</strong></td>                                    
				</tr>';
        $html.= "               <tr>
                                    <td>$row[tdenunciaid]</td>
                                    <td>$row[cexpedientesedi]</td>
                                    <td>$row[cexpedientepolicial]</td>
                                    <td>$row[cexpedientejudicial]</td>

                                    <td>$row[clevantamiento]</td>
                                    <td>$row[ctransito]</td>                        
                                </tr>";
        $html.= "</table><br><br>";

        $html.='<table align="left" border="1" id="lugardenuncia">';
        
        $depto= $row[deptodenuncia];
        
        $muni= $row[munidenuncia];
        
        $lugar= $row[subbandeja];
        
        $html.='<tr><td><strong>Denuncia tomada en</strong></td></tr><tr><td>';
        $html.="$lugar, Departamento de $depto municipio $muni"."</td></tr> </table><br>";
        
        $html.='<table align="left" border="1" id="lugarhecho">';
        
	$rowTemp4=$row[deptohecho];
              
	$rowTemp3=$row[munihecho];
        
	$rowTemp2=$row[aldeaciudadhecho];
        
	$rowTemp1=$row[barriocoloniahecho];        

        $html.='<tr><td><strong>Lugar de los hechos</strong></td></tr><tr><td>';
        $html.="$rowTemp1 $rowTemp2 $rowTemp3 $rowTemp4</td></tr>";
        $html.="<tr><td>$row[cdetalledireccionhecho]</td></tr>";
        $html.='</table><br>';
        
        //narracion de hechos
        $hechos= $row[cnarracionhecho];
       
        //**************************************fin datos generales de la denuncia *************************
        
        //inicio datos del denunciante    
	$resultado= $resultado1;
	while ($row=pg_fetch_assoc($resultado)){ 
            if ($row['bpersonanatural']== 'f'){
                $html.= '<strong>Datos Generales del denunciante</strong><br>';
                $html.='<table align="left" border="1" id="denunciante">';  
                
                //datos de empresa y apoderado
                $html.="<tr><td><strong>Empresa o institución: </strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Nacionalidad: </strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Registro tributario: </strong></td><td colspan=\"3\">$row[crtn]</td></tr>";                
                $html.="<tr><td><strong>Representante: </strong></td><td colspan=\"3\">$row[capoderadolegal]</td></tr>";
                $html.="<tr><td><strong>$row[cdescripcion]: </strong></td><td colspan=\"3\">$row[cdocumentoid]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  "
                        . "$row[aldeaciudad],  $row[barriocolonia] <br>"
                        . "$row[cdetalle] <br>"
                        . "$row[ctelefono]</td></tr>";
                
                $html.="</table><br>";
            }
            else{
                $html.='<strong>Datos Generales del denunciante</strong><br>';
                $html.='<table align="left" border="1" id="denunciante">';  

                //sexo
                if ($row['cgenero']=="m"){
                    $sexo= 'Masculino';
                }
                if ($row['cgenero']=="f"){
                    $sexo= 'Femenino';
                }
                if ($row['cgenero|1']=="x"){
                    $sexo= 'No consignado';
                }                  

                $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_denunciante</td><td><strong>Discapacidad</strong></td><td>$discapacidad_denunciante</td></tr>";

                $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$row[escolaridad]</td></tr>";
                $html.="<tr><td><strong>Documento identificación</strong></td><td>$row[tipodoc]</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";

                $edad_denunciante= $row[iedad];
                if ($edad_denunciante == 0 || $edad_denunciante == 'x'){
                    $edad_denunciante= 'Desconocida';
                }
                $ValorRangoEdad= $row[crangoedad];
                if($ValorRangoEdad== 'ni'){
                        $RangoEdad= "Infante";
                }

                if($ValorRangoEdad== 'na'){
                        $RangoEdad= "Adelescente";
                }

                if($ValorRangoEdad== 'nm'){
                        $RangoEdad= "Menor adulto";
                }

                if($ValorRangoEdad== 'a'){
                        $RangoEdad= "Adulto";
                }

                if($ValorRangoEdad== 'am'){
                        $RangoEdad= "Adulto Mayor";
                }

                if($ValorRangoEdad== 'x'){
                        $RangoEdad= "No consignado";                
                }                
                
                if ($row[cunidadmedidaedad]== 'a'){
                    $row[cunidadmedidaedad]= 'años';
                }
                else{
                    if ($row[cunidadmedidaedad]== 'm'){
                        $row[cunidadmedidaedad]= 'meses';
                    }
                    else
                    {
                        if ($row[cunidadmedidaedad]== 'd'){
                            $row[cunidadmedidaedad]= 'días';
                        }
                        else{
                            $row[cunidadmedidaedad]= '';
                        }
                    }
                }

                $html.="<tr><td><strong>Genero</strong></td><td>$row[cgenero]</td><td><strong>Edad</strong></td><td>$row[iedad] $row[cunidadmedidaedad] $RangoEdad</td></tr>";
                $html.="<tr><td><strong>Nacionalidad</strong></td><td>$row[nacionalidad]</td><td><strong>Estado civil</strong></td><td>$row[estadocivil]</td></tr>";            

                $html.="<tr><td><strong>Profesión</strong></td><td>$row[profesion]</td><td><strong>Oficio</strong></td><td>$row[oficio]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  $row[aldeaciudad],  $row[barriocolonia]</td></tr>";
                $html.="<tr><td><strong></strong></td><td colspan=\"3\">$row[cdetalle]</td></tr>";            

                $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
                $html.="</table><br>";
            }
	//fin datos denunciante
        }
        
        //inicio datos del ofendido    
	$resultado=$resultado2;
        
	while ($row=pg_fetch_assoc($resultado)){
            if ($row['bpersonanatural']== 'f'){
                $html.= '<strong>Datos Generales del ofendido</strong><br>';
                $html.='<table align="left" border="1" id="denunciante">';  
                
                //datos de empresa y apoderado
                $html.="<tr><td><strong>Empresa o institución: </strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Nacionalidad: </strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Registro tributario: </strong></td><td colspan=\"3\">$row[crtn]</td></tr>";                
                $html.="<tr><td><strong>Representante: </strong></td><td colspan=\"3\">$row[capoderadolegal]</td></tr>";
                $html.="<tr><td><strong>$row[cdescripcion]: </strong></td><td colspan=\"3\">$row[cdocumentoid]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  "
                        . "$row[aldeaciudad],  $row[barriocolonia] <br>"
                        . "$row[cdetalle] <br>"
                        . "$row[ctelefono]</td></tr>";
                
                $html.="</table><br>";
            }
            else{
                $html.='<strong>Datos Generales del ofendido</strong><br>';
                $html.='<table align="left" border="1" id="denunciante">';  

                //sexo
                if ($row[cgenero]=="m"){
                    $sexo= 'Masculino';
                }
                if ($row[cgenero]=="f"){
                    $sexo= 'Femenino';
                }
                if ($row[cgenero]=="x"){
                    $sexo= 'No consignado';
                }                  

                $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_denunciante</td><td><strong>Discapacidad</strong></td><td>$discapacidad_denunciante</td></tr>";

                $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$row[escolaridad]</td></tr>";
                $html.="<tr><td><strong>Documento identificación</strong></td><td>$row[tipodoc]</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";

                $edad_denunciante= $row[iedad];
                if ($edad_denunciante == 0 || $edad_denunciante == 'x'){
                    $edad_denunciante= 'Desconocida';
                }
                $ValorRangoEdad= $row[crangoedad];
                if($ValorRangoEdad== 'ni'){
                        $RangoEdad= "Infante";
                }

                if($ValorRangoEdad== 'na'){
                        $RangoEdad= "Adelescente";
                }

                if($ValorRangoEdad== 'nm'){
                        $RangoEdad= "Menor adulto";
                }

                if($ValorRangoEdad== 'a'){
                        $RangoEdad= "Adulto";
                }

                if($ValorRangoEdad== 'am'){
                        $RangoEdad= "Adulto Mayor";
                }

                if($ValorRangoEdad== 'x'){
                        $RangoEdad= "No consignado";                
                }                
                
                if ($row[cunidadmedidaedad]== 'a'){
                    $row[cunidadmedidaedad]= 'años';
                }
                else{
                    if ($row[cunidadmedidaedad]== 'm'){
                        $row[cunidadmedidaedad]= 'meses';
                    }
                    else
                    {
                        if ($row[cunidadmedidaedad]== 'd'){
                            $row[cunidadmedidaedad]= 'días';
                        }
                        else{
                            $row[cunidadmedidaedad]= '';
                        }
                    }
                }

                $html.="<tr><td><strong>Genero</strong></td><td>$row[cgenero]</td><td><strong>Edad</strong></td><td>$row[iedad] $row[cunidadmedidaedad] $RangoEdad</td></tr>";
                $html.="<tr><td><strong>Nacionalidad</strong></td><td>$row[nacionalidad]</td><td><strong>Estado civil</strong></td><td>$row[estadocivil]</td></tr>";            

                $html.="<tr><td><strong>Profesión</strong></td><td>$row[profesion]</td><td><strong>Oficio</strong></td><td>$row[oficio]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  $row[aldeaciudad],  $row[barriocolonia]</td></tr>";
                $html.="<tr><td><strong></strong></td><td colspan=\"3\">$row[cdetalle]</td></tr>";            

                $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
                $html.="</table><br>";
            }
	//fin datos ofendido
        }

        
       
        //inicio datos del denunciado  
        $contaimputado= 1;
	$resultado=$resultado3;
	while ($row=pg_fetch_assoc($resultado)){
	if ($row['bpersonanatural']== 'f'){
                $html.="<strong>Datos Generales del denunciado número $contaimputado</strong><br>";
                $html.='<table align="left" border="1" id="denunciante">';  
                
                //datos de empresa y apoderado
                $html.="<tr><td><strong>Empresa o institución: </strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Nacionalidad: </strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Registro tributario: </strong></td><td colspan=\"3\">$row[crtn]</td></tr>";                
                $html.="<tr><td><strong>Representante: </strong></td><td colspan=\"3\">$row[capoderadolegal]</td></tr>";
                $html.="<tr><td><strong>$row[cdescripcion]: </strong></td><td colspan=\"3\">$row[cdocumentoid]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  "
                        . "$row[aldeaciudad],  $row[barriocolonia] <br>"
                        . "$row[cdetalle] <br>"
                        . "$row[ctelefono]</td></tr>";
                
                $html.="</table><br>";
            }
            else{
                $html.='<strong>Datos Generales del denunciado</strong><br>';
                $html.='<table align="left" border="1" id="denunciante">';  

                //sexo
                if ($row[cgenero]=="m"){
                    $sexo= 'Masculino';
                }
                if ($row[cgenero]=="f"){
                    $sexo= 'Femenino';
                }
                if ($row[cgenero]=="x"){
                    $sexo= 'No consignado';
                }                  

                $html.="<tr><td><strong>Nombres</strong></td><td colspan=\"3\">$row[cnombres]</td></tr>";
                $html.="<tr><td><strong>Apellidos</strong></td><td colspan=\"3\">$row[capellidos]</td></tr>";
                $html.="<tr><td><strong>Etnia</strong></td><td>$etnia_denunciante</td><td><strong>Discapacidad</strong></td><td>$discapacidad_denunciante</td></tr>";

                $html.="<tr><td><strong>Escolaridad</strong></td><td colspan=\"3\">$row[escolaridad]</td></tr>";
                $html.="<tr><td><strong>Documento identificación</strong></td><td>$row[tipodoc]</td><td><strong>Número documento</strong></td><td>$row[cdocumentoid]</td></tr>";

                $edad_denunciante= $row[iedad];
                if ($edad_denunciante == 0 || $edad_denunciante == 'x'){
                    $edad_denunciante= 'Desconocida';
                }
                $ValorRangoEdad= $row[crangoedad];
                if($ValorRangoEdad== 'ni'){
                        $RangoEdad= "Infante";
                }

                if($ValorRangoEdad== 'na'){
                        $RangoEdad= "Adelescente";
                }

                if($ValorRangoEdad== 'nm'){
                        $RangoEdad= "Menor adulto";
                }

                if($ValorRangoEdad== 'a'){
                        $RangoEdad= "Adulto";
                }

                if($ValorRangoEdad== 'am'){
                        $RangoEdad= "Adulto Mayor";
                }

                if($ValorRangoEdad== 'x'){
                        $RangoEdad= "No consignado";                
                }                
                
                if ($row[cunidadmedidaedad]== 'a'){
                    $row[cunidadmedidaedad]= 'años';
                }
                else{
                    if ($row[cunidadmedidaedad]== 'm'){
                        $row[cunidadmedidaedad]= 'meses';
                    }
                    else
                    {
                        if ($row[cunidadmedidaedad]== 'd'){
                            $row[cunidadmedidaedad]= 'días';
                        }
                        else{
                            $row[cunidadmedidaedad]= '';
                        }
                    }
                }

                $html.="<tr><td><strong>Genero</strong></td><td>$row[cgenero]</td><td><strong>Edad</strong></td><td>$row[iedad] $row[cunidadmedidaedad] $RangoEdad</td></tr>";
                $html.="<tr><td><strong>Nacionalidad</strong></td><td>$row[nacionalidad]</td><td><strong>Estado civil</strong></td><td>$row[estadocivil]</td></tr>";            

                $html.="<tr><td><strong>Profesión</strong></td><td>$row[profesion]</td><td><strong>Oficio</strong></td><td>$row[oficio]</td></tr>";
                $html.="<tr><td><strong>Dirección</strong></td><td colspan=\"3\">$row[departamento], $row[municipio],  $row[aldeaciudad],  $row[barriocolonia]</td></tr>";
                $html.="<tr><td><strong></strong></td><td colspan=\"3\">$row[cdetalle]</td></tr>";            

                $html.="<tr><td><strong>telefono</strong></td><td colspan=\"3\">$row[ctelefono]</td></tr>";
                $html.="</table><br>";
            }
            $contaimputado++;
        }
	//fin datos denunciado     

        //narración de hechos, el dato se captura en el select inicial (ver inicio del programa)        
        $html.='<strong>Narración de hechos</strong><br>';
        $html.="<table align=\"left\" border=\"1\" id=\"hechos\">";
        $html.= "<tr><td>$hechos</td></tr>";
        $html.="</table><br>";        
        $contaimputado= 1;
        $rowDelitos=pg_fetch_assoc($resultado4);
        $Registros= pg_num_rows($resultado4);        
        
        while($Registros >=  $contaimputado){
//            if ($contaimputado == 1){
//                echo $Registros;
//                exit($rowDelitos[cnombres]." ". $rowDelitos[capellidos]);
//            }
            $html.= '<table align="left" border="1">';
            $html.= "<tr><td><strong>Supuestos delitos cometidos por el denunciado, número $contaimputado:</strong><br>
                    <i>$rowDelitos[cnombres] $rowDelitos[capellidos]</i>
                    </td></tr>";
                                    
            $actual= $rowDelitos[tpersonaid];
            while ($actual == $rowDelitos[tpersonaid]){                
                $clasificacion= $rowDelitos[cclasificacion];
                if ($clasificacion == 'x') {
                    $clasificacion= '';
                }
                else{
                    if ($clasificacion == 'c'){
                        $clasificacion= '  (Culposo)';
                    }
                    else {
                        $clasificacion= '  (Tentativa)';
                    }
                }
                $html.="<tr>
                                <td>   $rowDelitos[delito].$clasificacion</td>
                        </tr>";	
                $Registros--;
                
                echo ($rowDelitos[cnombres]." ". $rowDelitos[capellidos]);
                
                
                $rowDelitos=pg_fetch_assoc($resultado4);
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
ob_end_clean();
$pdf->Output('Denuncia '.$denuncia.' Completa.pdf', 'I'); 
//nombre: damos nombre al fichero, si no se indica lo llama por defecto doc.pdf
//destino: destino de envío en el documento. “I” envía el fichero al navegador con la opción de guardar como..., “D” envía el documento al navegador preparado para la descarga, “F” guarda el fichero en un archivo local, “S” devuelve el documento como una cadena.

//============================================================+
// END OF FILE
//============================================================+
