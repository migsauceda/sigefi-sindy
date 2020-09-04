<?php
session_start();
/*
includes: clase conexion
Relacion: funcion CargarLugarRecepcion
*/

include_once '../clases/class_conexion_pg.php';

/*
Funcion: Llamar a la funcion autenticar
Relacion: Formulario para acceder al programa.- index.php
Actualizacion: 25mayo2012

if (isset($_POST["txtAutenticar"])){
	if ($_POST["txtAutenticar"]== "autenticar")
	{	
            unset($_POST["txtAutenticar"]);
            autenticar();
	}
}        
*/
/*
Funcion: Llamar a la funcion ValidarEstado
Relacion: Formulario para acceder al programa.-  denunciapendiente.php
Actualizacion: 13spt2012
*/
if(isset($_SESSION['estado'])){       
        if ($_SESSION['estado']== "Incompleta") {                 
            $_SESSION['accion']= $_POST['accionh'];
            $_SESSION['denunciaid']= $_POST['numeroh'];            
            ValidarEstado();
        }
}  

/*
Funcion: Llamar a la funcion cambiar variable de session validar_estado
Relacion: Menu colgante opción crear nueva denuncia
Actualizacion: 30mayo2012
*/ 
//function CambiarValidarEstado($op, $estado){
//    $_SESSION['validarestado']= $op;
//    $_SESSION['estado']= $estado;      
//}


/*
Funcion: Llamar a la funcion validar estado
Relacion: Menu colgante opción crear nueva denuncia
Actualizacion: 30mayo2012
*/    
function ValidarEstado(){   
//    session_start();
    
    if(isset($_SESSION['estado'])){   
        if ($_SESSION['estado']== 'Espera') {  
            $_SESSION['estado']= 'Completando';                   
        }
        elseif ($_SESSION['estado']== 'Incompleta'){            
            if ($_SESSION['accion']== 0){
                $_SESSION['estado']= 'Espera';
                PrepararCrearDenunciaNueva();

                //$_SESSION['denuncia']= 'f';
                $_SESSION['generales']= 'f';
                $_SESSION['denunciante']= 'f';
                $_SESSION['denunciado']= 'f';
                $_SESSION['ofendido']= 'f';  

                echo
                "<script>
                        location.href='../aplicacion.php';
                </script>";                    
            }
            else{                
                $_SESSION['estado']= 'Completando';
                echo
                "<script>
                        location.href='../aplicacion.php';  
                </script>";                                                
            }            
        }
        elseif ($_SESSION['estado']== 'Completando') {
            PrepararCrearDenunciaNueva();

            $_SESSION['estado']= 'Espera';

            //$_SESSION['denuncia']= 'f';
            $_SESSION['generales']= 'f';
            $_SESSION['denunciante']= 'f';
            $_SESSION['denunciado']= 'f';
            $_SESSION['ofendido']= 'f';                   
        }
    }
    else
    {
    
    }  
}

/*
Funcion: borra variables de sesion para iniciar el ingreso de otra denuncia
Relacion: Menu colgante opcion crear nueva denuncia
Actualizacion: 08ago2012
*/
function PrepararCrearDenunciaNueva(){
//    include_once '../clases/class_conexion_pg.php';
    
    $objConexion= new Conexion();
    
    $Usr= $_SESSION['usuario'];
    $sql= "select controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";

    $objConexion= new Conexion();
    $rsp= $objConexion->ejecutarProcedimiento($sql);      
    
    //session_start();
    unset($_SESSION['denunciaid']);
    unset($_SESSION['generales']);
    unset($_SESSION['denunciante']);
    unset($_SESSION['denunciado']);
    
    unset($_SESSION["oDenuncia"]);
    unset($_SESSION["oDenunciante"]);
    unset($_SESSION["oDenunciado"]);
    unset($_SESSION['oOfendido']);
    unset($_SESSION['ofendido']);
    
    unset($_SESSION['DenuncianteActual']);
    unset($_SESSION['DenunciadoActual']);          
}

/*
Funcion: saber si existe variables de sesion queindique denuncia en RAM
Relacion: Menu colgante opciones que si requieren de denuncia en RAM
Actualizacion: 04ene2012
*/
function ExisteDenunciaRAM(){
   
    //session_start();
    if (isset($_SESSION['denunciaid'])){
        return "true";
    }       
    else {
        return "false";
    }
}

/*
Funcion: borra variables de sesion para quitar denuncia de RAM
Relacion: Menu colgante opciones que no requieren de denuncia en RAM
Actualizacion: 04ene2012
*/
function BorrarDenunciaRAM(){
   
    //session_start();
    unset($_SESSION['denunciaid']);
    unset($_SESSION['generales']);
    unset($_SESSION['denunciante']);
    unset($_SESSION['denunciado']);
    
    unset($_SESSION["oDenuncia"]);
    unset($_SESSION["oDenunciante"]);
    unset($_SESSION["oDenunciado"]);
    unset($_SESSION['oOfendido']);
    unset($_SESSION['ofendido']);
    
    unset($_SESSION['DenuncianteActual']);
    unset($_SESSION['DenunciadoActual']);          
}

/* 
 * Funcion: Saber si se está ingresando denuncia, retorna verdadero
 * Relacion: frm de ingreso
 * Actualización: 10sep2k12
 */
function IngresandoDenuncia(){
    //session_start();
    
    $usr= $_SESSION['usuario'];
    $sql= "select incompleta_existe('".$usr."');";
    
    $objConexion= new Conexion();
    $rsp= $objConexion->ejecutarProcedimiento($sql);
    
    $valor= pg_fetch_array($rsp);
    if ($valor[0]== 'f')
        return false;
    else
        return true;
}

/*
Funcion: Retornar cursor con los lugares de recepcion en el MP
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 12abr2012
*/
function CargarDenunciante(){
        //session_start();
	$objConexion=new Conexion(); 
	$sql= "select tpersonaid, tdenunciaid from tbl_denunciante
                where tdenunciaid=".$_SESSION['denunciaid'].";";
	$resTipodoc=$objConexion->ejecutarComando($sql);		
	return $resTipodoc;    
}

/*
Funcion: Retornar cursor con los lugares de recepcion en el MP
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 12abr2012
*/
function CargarTipoDocumento(){
	$objConexion=new Conexion(); 
	$sql= "SELECT ndocumentoid, cdescripcion FROM tbl_tipodocumento;";
	$resTipodoc=$objConexion->ejecutarComando($sql);		
	return $resTipodoc;    
}

/*
Funcion: Retornar cursor con los lugares de recepcion en el MP
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 12abr2012
*/
function CargarLugarRecepcion()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nlugarid, cdescripcion FROM tbl_lugarrecepcion;";
	$resRecepcion=$objConexion->ejecutarComando($sql);		
	return $resRecepcion;
}


function FechaANSI($Fecha){
    $mes= substr($Fecha, 0, 2);
    $dia= substr($Fecha, 3, 2);
    $anio= substr($Fecha, 6, 4);

    return $mes.$dia.$anio;
}

/*
Funcion: Retorna cursor con los deptos del pais
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 12abr2012
*/
function CargarDepto()
{
	$objConexion=new Conexion();
	$resDepto=$objConexion->ejecutarComando("select cdepartamentoid, cdescripcion from tbl_departamentopais order by cdescripcion;");
	return $resDepto;
}

/*
Funcion: Retorna cursor con los municipios del pais por depto
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 30may2012
*/
function CargarMunicipio()
{
	$objConexion=new Conexion(); 
	$sql= "select cmunicipioid, cdescripcion from tbl_municipio
		where cdepartamentoid= '".$_POST[txtDeptoPHP]."';";
	$resMuni=$objConexion->ejecutarComando($sql);	
        
        return $resMuni;
}

/*
Funcion: Retorna cursor con las ciudades/aldeas del pais por muni, depto
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 30may2012
*/
function CargarAldea()
{
	$objConexion=new Conexion(); 
	$sql="select caldeaid, cdescripcion from tbl_aldea
	where cdepartamentoid= '".$_POST[txtDeptoPHP]."' and cmunicipioid= '"
            .$_POST[txtMuniPHP]."';";
	$resAldea=$objConexion->ejecutarComando($sql);
        
        return $resAldea;
}

/*
Funcion: Retorna cursor con las barrios/colonias del pais por ciudad, muni, depto
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 30may2012
*/
function CargarBarrio()
{
	$objConexion=new Conexion(); 
	$sql="select cbarrioid, cdescripcion from tbl_barrio
	where cdepartamentoid= '".$_POST[txtDeptoPHP]."' and cmunicipioid= '"
            .$_POST[txtMuniPHP]."' and caldeaid= '".$_POST[txtAldeaPHP]."' "
            ."order by cdescripcion;";
	$resBarrio=$objConexion->ejecutarComando($sql);		
        
        return $resBarrio;
}


/*
Funcion: Retorna cursor etnias
Relacion: Formulario para crear nueva denuncia y modificarla
Actualizacion: 30may2012
*/
function CargarEtnia()
{
	$objConexion=new Conexion(); 
	$sql="SELECT netniaid, cdescripcion FROM tbl_etnia order by cdescripcion;";
	$resEtnia=$objConexion->ejecutarComando($sql);	
        
        return $resEtnia;
}

/*
Funcion: Retorna cursor con discapacidad
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarDiscapacidad()
{
	$objConexion=new Conexion(); 
	$sql="SELECT ndiscapacidadid, cdescripcion FROM tbl_discapacidad order by cdescripcion;";
	$resDisca=$objConexion->ejecutarComando($sql);
        
        return $resDisca;
}

/*
Funcion: Retorna cursor con los deptos del pais
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarNacionalidad()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT cnacionalidadid, cdescripcion FROM tbl_nacionalidad;";
	$resNacion=$objConexion->ejecutarComando($sql);   
	return $resNacion;
}


/*
Funcion: Retorna cursor con los estados civiles
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarEstadoCivil()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT ncivil, cdescripcion FROM tbl_estadoscivil order by cdescripcion;";
	$resCivil=$objConexion->ejecutarComando($sql);	
        
        return $resCivil;
}

/*
Funcion: Retorna cursor con escolaridad
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarEscolaridad()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nescolaridadid, cdescripcion FROM tbl_escolaridad;";
	$resEscolar=$objConexion->ejecutarComando($sql);
        
        return $resEscolar;
}

/*
Funcion: Retorna cursor con profesion
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarProfesion()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nprofesionid, cdescripcion FROM tbl_profesion order by cdescripcion;";
	$resProfe=$objConexion->ejecutarComando($sql);

        return $resProfe;
}


/*
Funcion: Retorna cursor con fiscalias
Relacion: Formulario para asignar fiscalia a denuncia
Actualizacion: 30may2012
*/
function CargarFiscalia()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nfiscaliaid, cdescripcion FROM tbl_fiscalia order by cdescripcion;";
	$resFiscalia=$objConexion->ejecutarComando($sql);

        return $resFiscalia;
}

/*
Funcion: Retorna cursor con ocupacion
Relacion: Formulario para crear nueva denuncia y modificarla,
 * denunciante
Actualizacion: 30may2012
*/
function CargarOcupacion()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nocupacionid, cdescripcion FROM tbl_ocupacion order by cdescripcion;";
	$resOcupa=$objConexion->ejecutarComando($sql);	
        
        return $resOcupa;
}

/*
Funcion: Retorna cursor con imputados o denunciados en denuncia
Relacion: Formulario para asignar denuncia a fiscalia,
 * denunciante
Actualizacion: 30may2012
*/
function CargarDenunciados($denunciaid)
{
	$objConexion=new Conexion(); 
	$sql= "select p.tpersonaid as personaid, btrim(cnombres, ' ') || ' ' || btrim(capellidos, ' ') as nombrecompleto "
            ."from tbl_persona p, tbl_imputado_denuncia id "
            ."where p.tpersonaid= id.tpersonaid and id.tdenunciaid= '"
            .$denunciaid."';";
	$resDenunciados=$objConexion->ejecutarComando($sql);	
        
//        exit($sql);
//        echo $sql;
        
        return $resDenunciados;
}

/*
Funcion: Retorna cursor con lista fiscales por fiscalia
Relacion: Formulario para asignar denuncia a fiscal
Actualizacion: 18mar2012
*/
function CargarFiscalFiscalia($fiscalia)
{
	$objConexion=new Conexion(); 
	$sql= "SELECT trim(tbl_fiscal.cnombres) || ' ' || trim(tbl_fiscal.capellidos) as nombrecompleto, "
              ."tbl_fiscal.cfiscalid, tbl_fiscal.nfiscaliaid "
              ."FROM tbl_fiscal, tbl_fiscalia WHERE "
              ."tbl_fiscal.nfiscaliaid = tbl_fiscalia.nfiscaliaid and "
              ."tbl_fiscalia.nfiscaliaid = ".$fiscalia.";";
        
        $resFiscales=$objConexion->ejecutarComando($sql);	
        return $resFiscales;
}

/*
Funcion: Retorna un registro con la fiscalia en q esta asignado un imputado
Relacion: Formulario para asignar denuncia a fiscalia,
 * denunciante
Actualizacion: 30may2012
*/
function CargarFiscaliaActual($denunciaid, $imputado)
{
	$objConexion=new Conexion(); 
	$sql= "select f.nfiscaliaid as fiscaliaid, cdescripcion from tbl_imputado_fiscalia if, tbl_fiscalia f "
             ."where if.nfiscaliaid= f.nfiscaliaid and bactivo= 't' and "
             ."tdenunciaid= '".$denunciaid."' and "
             ."timputadoid= '".$imputado."';";
        
	$resFiscaliaActual=$objConexion->ejecutarComando($sql);	

//        echo $sql;
        
        return $resFiscaliaActual;
}

/*
Funcion: Retorna un registro con la fiscalia en q esta asignado un imputado
Relacion: Formulario para asignar denuncia a fiscalia,
 * denunciante
Actualizacion: 30may2012
*/
function CargarFiscalActual($denunciaid, $imputado)
{
	$objConexion=new Conexion(); 
        
        $sql= "select f.cfiscalid as fiscalid, trim(cnombres) || ' ' || trim(capellidos) as nombrecompleto "
                ."from tbl_imputado_fiscal i, tbl_fiscal f "
                ."where i.cfiscal= f.cfiscalid and bactivo= 't' and "
                ."tdenunciaid= '".$denunciaid."' and "
                ."timputadoid= '".$imputado."';";        
        
	$resFiscaliaActual=$objConexion->ejecutarComando($sql);	

//        echo $sql;
        
        return $resFiscaliaActual;
}

/*
Funcion: Retorna IP real
Relacion: Todos los ORM
Actualizacion: 05may2012
Nota: Tomado de http://www.eslomas.com/2005/04/obtencion-ip-real-php/
*/
function getRealIP()
{
 
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
 
      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar 
      // una dirección ip que no sea del rango privado. En caso de no 
      // encontrarse ninguna se toma como valor el REMOTE_ADDR
 
      $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);
 
      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
 
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
 
            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }
 
   return $client_ip;
 
}

/*
Funcion: Validar que el usuario
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: 
*/
function autenticar($usuario, $password, $tipoacceso)
{
    session_start();
		//include_once("clases/class_conexion_pg.php");
//                $_SESSION['usuario']= $_POST['txtUsr'];
//                $usuario= $_SESSION['usuario'];
//                $password= $_POST['txtPasswd'];
		$objConexion= new Conexion();
//                $objConexion->Conectar();
                
                if ($tipoacceso== 'Receptor'){
                    //entra comom receptor de denuncia
                    $sql= "SELECT tbl_usuarios.usuario, tbl_usuarios.contrasena, 
                        tbl_usuarios.ubicacion, tbl_usuarios.nombreapellido, 
                        tbl_lugarrecepcion.cdescripcion, ibandejaid, tbl_usuarios.ibandejaid, 
						tbl_usuarios.pedircambiopasswd
                        FROM tbl_lugarrecepcion, tbl_usuarios
                        WHERE tbl_lugarrecepcion.nlugarid = tbl_usuarios.ubicacion
                        and  usuario='$usuario'";                    
                }
                else{
                    //entra como fiscal
                    $sql=   "SELECT 
                            tbl_usuarios.usuario, 
                            tbl_usuarios.contrasena, 
                            tbl_usuarios.ubicacion, 
                            tbl_usuarios.nombreapellido, 
                            tbl_fiscalia.cdescripcion, 
                            tbl_usuarios.ibandejaid,
                            tbl_usuarios.identidad,
							tbl_usuarios.pedircambiopasswd
                            FROM 
                            tbl_fiscalia, 
                            tbl_usuarios
                            WHERE 
                            tbl_fiscalia.nfiscaliaid = tbl_usuarios.ubicacion
                            and usuario= '$usuario'";
                }

		$resultado=$objConexion->ejecutarComando($sql);      

                //en el caso que no exista el usuairo
                if(pg_num_rows($resultado)<= 0){                                       
                        $_SESSION['valido']= 0;
			header("location:../index.php");                    
                }
                                
                $registro= pg_fetch_array($resultado);
				
				if ($registro['pedircambiopasswd']==t){
					header("location: ../administracion/CambiarClave.php");
				}

                $passcrypt= $registro["contrasena"];
                $_SESSION['bandeja']=$registro["ibandejaid"];
                $_SESSION['ubicaciondesc']= $registro["cdescripcion"];
                $_SESSION['ubicacionid']= $registro["ubicacion"];
                $_SESSION['nombreusr']= $registro["nombreapellido"];
                $_SESSION['tipoacceso']= $tipoacceso;
                $_SESSION['usuario']= $usuario;
                $_SESSION['identidad']= $registro["identidad"];
                
                //exit($password."-".$passcrypt);
                //verificar si es el password correcto. 
                //clave retorna true si coninciden
                if (!clave($password, $passcrypt)){  
                        $_SESSION['valido']= 0;
			header("location:../index.php");     
                }
                else{
                    //Verificacion ultimo acceso de sesion del usuario
                    $querySession=$objConexion->ejecutarComando("SELECT * FROM tbl_user_session WHERE usuario ='$usuario'");
                    //$query_session=$db::consulta($txtsql_user_session);
                    $numExist=pg_num_rows($querySession);
                    if($numExist == 0){
                        $queryInsert=$objConexion->ejecutarComando("INSERT INTO tbl_user_session(usuario,ip_address,last_access)
                                        VALUES('$usuario','".$_SERVER['REMOTE_ADDR']."','now()')");
                    }else{
                        $queryUpdate=$objConexion->ejecutarComando("UPDATE tbl_user_session
                                            SET ip_address='".$_SERVER['REMOTE_ADDR']."',last_access=now()
                                            WHERE usuario= '$usuario'");
                    }

                    $queryInsert_log=$objConexion->ejecutarComando("INSERT INTO tbl_log_general(usuario,ip_address,time_date,descripcion)
                    VALUES('$usuario','".$_SERVER['REMOTE_ADDR']."',now(),'Ingreso al Sistema')");  

                    $registro= pg_fetch_array($resultado);
                    $_SESSION['ubicacion']=$registro["ubicacion"];                    

                    if (ConocerTareas($_SESSION['usuario'])== 1) //error
                    {
                        DestruirSesion();

                        echo
                        "<script>
                        location.href='../index.php';
                        </script>";                            
                    }

                    $_SESSION['estado']= 'Autenticar';  
                    
                    ProcesaIncompleta();
                }
}


/*
Funcion: Conocer las tareas que puede hacer el usr, segun su rol, las guarda en una variable
    de session de tipo cadena y llamada $tarea, separada por guines "-"
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: 
*/
function ConocerTareas($usuario)
{
	$objConexion= new Conexion();
	$sql= "select rolid from tbl_usr_rol where usuario="."'".$usuario."';";
	$Cursor= $objConexion->ejecutarComando($sql);	

	$TareaList="";
	while($Rol= pg_fetch_array($Cursor))
	{
		$sql= "select tarea from tbl_rol_tarea where rolid=".$Rol[rolid];
		$Cursor2= $objConexion->ejecutarComando($sql);

		while($Tarea= pg_fetch_array($Cursor2))
		{
			if ($TareaList== "")
			{
				$TareaList= $Tarea[tarea];
			}
			else
			{
				$TareaList= $TareaList."-".$Tarea[tarea];
			}                        
		}
		
	}
	$error= 0;        
	if ($TareaList!="")
	{
                $TareaArray = explode("-",$TareaList);
		$_SESSION['tarea']=$TareaArray;
                
//                $xyz= $_SESSION['tarea'];
//                exit($xyz[2]);
	}
	else
	{
		$error= 1;
	}
	if ($error== 1)
	{
		$objConexion->cerrarConexion();
                unset($objConexion);

		echo
		"<script>
		alert('Error al cargar las tareas permitidas al usuario.');
		</script>";		                
                
                return $error;
	}
	else
	{           
            $objConexion->cerrarConexion();
            unset($objConexion);      
            
            return $error;
	}
}

/*Funcion: Retornar verdadero si el usuario puede realizar dicha tarea
 * Relación: Todos los archivos php que realizan tareas
 * Actualizacion: 11ene2013
 */
function Ejecutar($archivo){
    $TareaArray = $_SESSION['tarea'];
//    print_r($TareaArray);

    $ok= false;
    for($i= 0; $i < count($TareaArray); $i++){
        if ($TareaArray[$i]== $archivo){
            $ok= true;
        }
    }
    
    return $ok;
}


/*
Funcion: Borrar denuncia actualmente incompleta
Relacion: Frms para ingreso de denuncia
Actualizacion: 03sept2012
Nota: 
*/
function BorrarPendiente(){
    //session_start();
	$oConeccion= new Conexion();
        $Usr= $_SESSION['usuario'];
        $sql= "select borrar_incompleta('".$Usr."');";
        $reg= $oConeccion->ejecutarComando($sql);    
}

/*
Funcion: Conocer si en el inicio de sesion hay denuncias incompletas
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: $Bandera: 1 cuando viene de iniciar sesion, 2 menu nueva denuncia,
 * 3 viene de frmDenuncia pendiente y puede tener $accion 0 no continuar
 * con la denuncia ó 1 continuar con denuncia completandola
*/
function ProcesaIncompleta()
{       
        session_start();
        
	$oConeccion= new Conexion();
	$Usr= $_SESSION['usuario'];

	//cuando se inicia el programa o cuando se clikea nuevo
	if ($_SESSION['estado']== 'Autenticar')
	{    
//		$sql= "select * from tbl_controlestados where usr= '".$Usr."' and "
//			."(not generales or not denunciante or not denunciado or not ofendido);";
                $sql= "select * from denunciaspendientes('".$Usr."');";
		$reg= $oConeccion->ejecutarComando($sql);
                $arr= pg_fetch_array($reg); 
		if (pg_num_rows($reg) > 0) //tiene denuncias incompletas
		{                    			
			$_SESSION['fecha']= $arr["fecha"];
			$_SESSION['denunciaid']= $arr["denuncia"];
			$_SESSION['generales']= $arr["generales"];
			$_SESSION['denunciante']= $arr["denunciante"];
			$_SESSION['denunciado']= $arr["denunciado"];
			$_SESSION['ofendido']= $arr["ofendido"];
		
                        //en denunciapendiente.php se cambia a estado incompleta
                        //y pide que hacer: borrarla o continuar ingresando
			echo
			"<script>
			location.href='../administracion/DenunciaPendiente.php';
			</script>";
		}
		else
		{                            
                    //cambia estado, modifica variables de estado
                    $_SESSION['estado']= 'Espera';
                    
                    //$_SESSION['denuncia']= 'f';
                    $_SESSION['generales']= 'f';
                    $_SESSION['denunciante']= 'f';
                    $_SESSION['denunciado']= 'f';
                    $_SESSION['ofendido']= 'f';                    
        
                    echo
                    "<script>
                            location.href='../aplicacion.php';
                    </script>";
		}
	}
}

/*
Funcion: Cargar listado de delitos y faltas
Relacion: Tabuladores de pantalla captura de denucia, imputado.php
Actualizacion: 17jul2k12
Nota: Estos se listan en las tablas dinamicas del formulario
*/
function CargarDelito()
{
    $objConexion=new Conexion(); 
    $sql= "SELECT ndelitoid, cdescripcion FROM tbl_delito order by cdescripcion;";
    $resDelito=$objConexion->ejecutarComando($sql);	

    return $resDelito;        
}


/*
Funcion: Conocer si se puede cambiar de tabulador
Relacion: Tabuladores de pantalla captura de denucia, crer_denuncia.php
Actualizacion: 06jun2k12
Nota: se puede cambiar de tabulador solo si ya se han grabado los
 * datos generales de la denuncia
*/
function CambiarAtab($pDenunciante)
{           
    //session_start();        

    $pusr= $_SESSION['usuario'];
         
    $sql= "select validar_cambiartab('$pusr','$pDenunciante');";

    $oConeccion= new Conexion();    
    $Retorno= $oConeccion->ejecutarComando($sql);
    $registro= pg_fetch_array($Retorno);

    unset($oConeccion);
    
    return $registro[0];
}   

/*
Funcion: Destruir una session
Relacion: Salir e iniciar programa
Actualizacion: 09jun2k12
Nota: se puede cambiar de tabulador solo si ya se han grabado los
 * datos generales de la denuncia
*/
function DestruirSesion(){
    //session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

/*
Funcion: Saber si existe un vlr en una lista enlazada de enteros
Relacion: frms para ingreso: denunciante, denunciado, ofendido
Actualizacion: 10jun2k12
Nota: se hace para poder recorrer una lista cn varios denunciados, etc
*/
function Existe($clave, $lista){
    //encontrar
    //$clave= 2;
    
    $lista->rewind();
    $existe= 0;
    while($lista->valid()){
        if ($clave== $lista->current()){
            $existe= 1;
            break;
        }
        $lista->next();
    }
    if ($existe== 1)
        return true;
    else
        return false;
}

function Borrar($borrar, $lista){
    $tmp= new SplDoublyLinkedList();
    $lista->rewind();
    //meter a $tmp lo que NO kiero borrar
    while($lista->valid()){
        if($lista->current()!=$borrar){
            $tmp->push($lista->current());
        }
        $lista->shift();
        $lista->next();           
    }
    $tmp->rewind();
    while($tmp->valid()){
        $lista->push($tmp->current());
        $tmp->next();
    }
    unset($tmp);        
}

/*
Funcion: Generar hash para password
Relacion: frms para autenticar
Actualizacion: 28jul2k12
Nota: tomado de la web php y modificado el salt
*/

function clave($info, $encdata = false) 
{     
  $strength = "08"; 

  //if encrypted data is passed, check it against input ($info) 
  if ($encdata) {          
    if (substr($encdata, 0, 60) == crypt($info, "$2a$".$strength."$".substr($encdata, 60))) { 
      return true; 
    } 
    else { 
      return false; 
    } 
  } 
  else { 
  //make a salt and hash it with input, and add salt to end 
  $salt = ""; 
  for ($i = 0; $i < 22; $i++) { 
    $salt .= substr("./ABCDEfghijkLMNOPQRSTUzyxwvabcdeFGHIJKlmnopqrstuvZYXW0193856742", mt_rand(0, 63), 1); 
  } 
  //return 82 char string (60 char hash & 22 char salt) 
  return crypt($info, "$2a$".$strength."$".$salt).$salt; 
} 
} 

/*
Funcion: Listar denuncias segun badeja asignada a usr
Relacion: frms para crear denuncia
Actualizacion: 29ago2k12
Nota: 
*/
function ListarContenidoBandeja($bandeja)
{
    //session_start();
    $pusr= $_SESSION['usuario'];
    
    //conocer la bandeja asignada
    $sql= "select tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
            from bandeja_listacontenido_pl($bandeja)";
    $objConexion= new Conexion();
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}

/*
Funcion: Listar denuncias asignadas a esa fiscalia
Relacion: frms para asignar denuncia a fiscal. La denuncia ya esta pasada a la fiscalia
Actualizacion: 03dic2k12
Nota: 
*/
function ListarPendientesFiscal($fiscalia)
{
    //session_start();
    $pusr= $_SESSION['usuario'];
    
    //conocer la bandeja asignada
    $sql= "select tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
            from bandeja_fiscalia_pl($fiscalia)";
    
//    exit($sql);
    $objConexion= new Conexion();
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}


/*
Funcion: Generar cadena aleatoria
Relacion: frms para crear cambiar password
Actualizacion: 28jul2k12
Nota: tomado http://phpes.wordpress.com/2007/06/12/generador-de-una-cadena-aleatoria/
*/
function CadenaRandom($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
{
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($n==1) $source .= '1234567890';
    if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
    if($length>0){
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++){
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
    }
    return $rstr;
}

/*
Funcion: Saber si el parametro tiene SQL Injection
Relacion: Todas las clases que reciben datos q se almacenaran en la BD
Actualizacion: 03mar2k13
Nota: Basado de http://www.php.net/manual/es/security.database.sql-injection.php
*/
function InjectionSQL($string)
{
    $value= strtoupper($string);
    
}
function is_phpkeyinject($value){
    
}
?>
