<?php session_start();
if (isset($_GET['opcion'])){
	$opcion=$_GET['opcion'];				
}

$i=0;
$posArreglo=0;
$existeTodas=False; //para fiscalias y sedes
$todosUsuario=False;
$todosFiscales=False;
$fechasIni=array();
$fechasFin=array();
$sedes=array();
$usuarios=array();
$fiscalias=array();
$fiscales=array();
$estados=array();
$condiciones=array();
$condicionesFecha=array();

if (($opcion==1) || ($opcion==6) || ($opcion==7)){
	$_SESSION['denuncia']=$_GET['denuncia'];
}else{
	if ($opcion==2){
		if (isset($_GET['numFiltros'])){
			$numFiltros=$_GET['numFiltros'];				
		}
		for ($i=1;$i<=$numFiltros;$i++){
			$fechasIni[$posArreglo]=$_GET['fechaIni'.$i];
			$fechasFin[$posArreglo]=$_GET['fechaFin'.$i];
			if ($_GET['sede'.$i]!="---"){
				$sedes[$posArreglo]=$_GET['sede'.$i];
			}
			if($sedes[$posArreglo]=="todas"){
				$existeTodas=True;
			}
			
			$posArreglo++;
		}//fin de for
		
		if ($existeTodas==True){
			$i=1;
			$posArreglo=0;
			for ($i=1;$i<=$numFiltros;$i++){
				if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="")){				
					$condiciones[$posArreglo]="tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]'";
				}
				
				$posArreglo++;
			}
			//echo $condiciones;
		}else{
			$i=1;
			$posArreglo=0;
			for ($i=1;$i<=$numFiltros;$i++){
				if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($sedes[$posArreglo]!="")){					
					$condiciones[$posArreglo]="tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]' and tbl_lugarrecepcion.nlugarid='$sedes[$posArreglo]'";
				}
				
				$posArreglo++;
			}
			//echo $condiciones;
		}//fin if existe todas
	//fin de opcion 2
	}else{
		if ($opcion==3){	
			if (isset($_GET['numFiltros'])){
				$numFiltros=$_GET['numFiltros'];				
			}
			for ($i=1;$i<=$numFiltros;$i++){
				$fechasIni[$posArreglo]=$_GET['fechaIni'.$i];
				$fechasFin[$posArreglo]=$_GET['fechaFin'.$i];
				if ($_GET['sede'.$i]!="---"){
					$sedes[$posArreglo]=$_GET['sede'.$i];
				}
				if($sedes[$posArreglo]=="todas"){
					$existeTodas=True;
				}
				
				if ($_GET['usuario'.$i]!="---"){
					$usuarios[$posArreglo]=$_GET['usuario'.$i];
				}
				if($usuarios[$posArreglo]=="todos"){
					$todosUsuario=True;
				}
				
				$posArreglo++;
			}//fin de for
			
			if ($existeTodas==True){ //todas las sedes
						$i=1;
						$posArreglo=0;
						for ($i=1;$i<=$numFiltros;$i++){
							if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($sedes[$posArreglo]!="") && ($usuarios[$posArreglo]!="")){
								if ($todosUsuario==True){//todos los usuarios
									$condiciones[$posArreglo]="mini_sedi.tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and mini_sedi.tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]'";
								}else{//un usuario en especifico
									$condiciones[$posArreglo]="mini_sedi.tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and mini_sedi.tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]' and mini_sedi.tbl_denuncia.ccreada='$usuarios[$posArreglo]'";
								}							
							}
							
							$posArreglo++;
						}
//						echo $condiciones[0];
//                                                exit;
					}else{//una sede en especifico
						$i=1;
						$posArreglo=0;
						for ($i=1;$i<=$numFiltros;$i++){
							if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($sedes[$posArreglo]!="") && ($usuarios[$posArreglo]!="")){	
								if ($todosUsuario==True){//todos los usuarios
									$condiciones[$posArreglo]="mini_sedi.tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and mini_sedi.tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]' and 
	mini_sedi.tbl_denuncia.nlugarrecepcion='$sedes[$posArreglo]'";
								}else{//un usuario en especifico de una sede
									$condiciones[$posArreglo]="mini_sedi.tbl_denuncia.dfechadenuncia>='$fechasIni[$posArreglo]' and mini_sedi.tbl_denuncia.dfechadenuncia<='$fechasFin[$posArreglo]' and 
	mini_sedi.tbl_denuncia.nlugarrecepcion='$sedes[$posArreglo]' and mini_sedi.tbl_denuncia.ccreada='$usuarios[$posArreglo]'";
								}
							}
							
							$posArreglo++;
						}
//						echo $condiciones[0];
//                                                exit;
					}//fin if existe todas			
		//fin de opcion 3
		}else{
			if ($opcion==4){
				if (isset($_GET['numFiltros'])){
					$numFiltros=$_GET['numFiltros'];				
				}
				for ($i=1;$i<=$numFiltros;$i++){
					$fechasIni[$posArreglo]=$_GET['fechaIni'.$i];
					$fechasFin[$posArreglo]=$_GET['fechaFin'.$i];
					if ($_GET['fiscalia'.$i]!="---"){
						$fiscalias[$posArreglo]=$_GET['fiscalia'.$i];
					}
					if($fiscalias[$posArreglo]=="todas"){
						$existeTodas=True;
					}
					
					if ($_GET['estado'.$i]!="---"){
						$estados[$posArreglo]=$_GET['estado'.$i];
					}
					
					$posArreglo++;
				}//fin de for
				
				if ($existeTodas==True){ 
					$i=1;
					$posArreglo=0;
					for ($i=1;$i<=$numFiltros;$i++){
						if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($estados[$posArreglo]!="")){				
							$condiciones[$posArreglo]="tbl_imputado_fiscalia.dfechaasignacion>='$fechasIni[$posArreglo]' and tbl_imputado_fiscalia.dfechaasignacion<='$fechasFin[$posArreglo]' and tbl_imputado_fiscalia.bactivo='$estados[$posArreglo]'";
						}
						
						$posArreglo++;
					}
					//echo $condiciones;
				}else{
					$i=1;
					$posArreglo=0;
					for ($i=1;$i<=$numFiltros;$i++){
						if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($fiscalias[$posArreglo]!="") && ($estados[$posArreglo]!="")){					
							$condiciones[$posArreglo]="tbl_imputado_fiscalia.dfechaasignacion>='$fechasIni[$posArreglo]' and tbl_imputado_fiscalia.dfechaasignacion<='$fechasFin[$posArreglo]' and tbl_imputado_fiscalia.nfiscaliaid='$fiscalias[$posArreglo]' and tbl_imputado_fiscalia.bactivo='$estados[$posArreglo]'";
						}
						
						$posArreglo++;
					}
					//echo $condiciones;
				}//fin if existe todas
			//fin opcion = 4	
			}else{
				if ($opcion==5){
					if (isset($_GET['numFiltros'])){
						$numFiltros=$_GET['numFiltros'];				
					}
					for ($i=1;$i<=$numFiltros;$i++){
						$fechasIni[$posArreglo]=$_GET['fechaIni'.$i];
						$fechasFin[$posArreglo]=$_GET['fechaFin'.$i];
						if ($_GET['fiscalia'.$i]!="---"){
							$fiscalias[$posArreglo]=$_GET['fiscalia'.$i];
						}
						if($fiscalias[$posArreglo]=="todas"){
							$existeTodas=True;
						}
						
						if ($_GET['fiscal'.$i]!="---"){
							$fiscales[$posArreglo]=$_GET['fiscal'.$i];
						}
						if($fiscales[$posArreglo]=="todos"){
							$todosFiscales=True;
						}
						
						if ($_GET['estado'.$i]!="---"){
							$estados[$posArreglo]=$_GET['estado'.$i];
						}
						
						$posArreglo++;
					}//fin de for
					
					if ($existeTodas==True){ //todas las fiscalias
						$i=1;
						$posArreglo=0;
						for ($i=1;$i<=$numFiltros;$i++){
							if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($estados[$posArreglo]!="") && ($fiscales[$posArreglo]!="") && ($fiscalias[$posArreglo]!="")){
								if ($todosFiscales==True){//todos los fiscales
									//condiciones para denunciados y denuncias
									$condiciones[$posArreglo]="tabla.bactivo='$estados[$posArreglo]'";
									$condicionesFecha[$posArreglo]="dfechaasignacion>='$fechasIni[$posArreglo]' and dfechaasignacion<='$fechasFin[$posArreglo]'";
								}else{//un fiscal en especifico
									//condiciones para denunciados y denuncias
									$condiciones[$posArreglo]="tbl_fiscal.cfiscalid='$fiscales[$posArreglo]' and tabla.bactivo='$estados[$posArreglo]'";
									$condicionesFecha[$posArreglo]="dfechaasignacion>='$fechasIni[$posArreglo]' and dfechaasignacion<='$fechasFin[$posArreglo]'";
								}							
							}
							
							$posArreglo++;
						}
						//echo $condiciones;
					}else{//una fiscalia en especifico
						$i=1;
						$posArreglo=0;
						for ($i=1;$i<=$numFiltros;$i++){
							if (($fechasIni[$posArreglo]!="") && ($fechasFin[$posArreglo]!="") && ($estados[$posArreglo]!="") && ($fiscales[$posArreglo]!="") && ($fiscalias[$posArreglo]!="")){	
								if ($todosFiscales==True){//todos los fiscales de una fiscalia
									$condiciones[$posArreglo]="tbl_fiscalia.nfiscaliaid='$fiscalias[$posArreglo]' and tabla.bactivo='$estados[$posArreglo]'";
									$condicionesFecha[$posArreglo]="dfechaasignacion>='$fechasIni[$posArreglo]' and dfechaasignacion<='$fechasFin[$posArreglo]'";
								}else{//un fiscal en especifico de una fiscalia
									$condiciones[$posArreglo]="tbl_fiscal.cfiscalid='$fiscales[$posArreglo]' and 
	tbl_fiscalia.nfiscaliaid='$fiscalias[$posArreglo]' and tabla.bactivo='$estados[$posArreglo]'";
									$condicionesFecha[$posArreglo]="dfechaasignacion>='$fechasIni[$posArreglo]' and dfechaasignacion<='$fechasFin[$posArreglo]'";
								}
							}
							
							$posArreglo++;
						}
						//echo $condiciones;
					}//fin if existe todas				
				//fin de opcion 5
				}		
			}
		}
	}//fin if opcion 2
}// fin de opciones

if (($opcion==2) || ($opcion==3) || ($opcion==4) || ($opcion==5)){
	$_SESSION['condiciones']=$condiciones;
	$_SESSION['condicionesFecha']=$condicionesFecha;
	$_SESSION['fechasIni']=$fechasIni;
	$_SESSION['fechasFin']=$fechasFin;
	$_SESSION['sedes']=$sedes;
	$_SESSION['fiscalias']=$fiscalias;
	$_SESSION['fiscales']=$fiscales;
	$_SESSION['estados']=$estados;
	$_SESSION['usuarios']=$usuarios;
}

$dir="../reportes/reporte".$opcion.".php";
echo "<iframe src='$dir' id='rpt' name='rpt' height='900' width='800' frameborder='1'>
</iframe>";
?>