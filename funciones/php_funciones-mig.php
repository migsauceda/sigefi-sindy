<?php
session_start();
/*
includes: clase conexion
Relacion: funcion CargarLugarRecepcion
*/

include_once "../clases/class_conexion_pg.php";
include_once "../clases/Usuario.php";

//include "../clases/class_conexion_pg.php";
//include "../clases/Usuario.php";

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
                $_SESSION['CambiarTab']= 1;
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
    
    //para que no se pueda cambiar de tabulador sin grabar antes los
    //datos generales de la denuncia
    $_SESSION['CambiarTab']= 0;
    
    $objConexion= new Conexion();
    
    $Usr= $_SESSION['usuario']; 
    if (isset($_SESSION['denunciaid'])){
        $Denunciaid= $_SESSION['denunciaid'];
    }
    else{
        $Denunciaid= 0;
    }
    if ($Denunciaid == '') $Denunciaid= 0;

    $sql= "select controlestados_delete('".$Usr."',".$Denunciaid.");";

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
Funcion: Retornar cursor con los nombres de las empresas estatales tabla tbl_empresashn
Relacion: Formulario para generar reportes
Actualizacion: 20dic2013
*/
function CargarEmpresasHN(){
        //session_start();
	$objConexion=new Conexion(); 
	$sql= "select iempresaid, cdescripcion from tbl_empresashn order by cdescripcion;";
	$resEmpresashn=$objConexion->ejecutarComando($sql);		
	return $resEmpresashn;    
}

/*
Funcion: Retornar cursor con los delitos en la tabla tblDelitos
Relacion: Formulario para generar reportes
Actualizacion: 20sept2013
*/
function CargarDelitos(){
        //session_start();
	$objConexion=new Conexion(); 
	$sql= "select ndelitoid, cdescripcion from tbl_delito order by cdescripcion;";
	$resDelitos=$objConexion->ejecutarComando($sql);		
	return $resDelitos;    
}

/*
Funcion: Retornar cursor con las armas
Relacion: Formulario para generar reportes
Actualizacion: 27ago2015
*/
function CargarArmas(){
        //session_start();
	$objConexion=new Conexion(); 
	$sql= "select narmaid, cdescripcion from tbl_tipo_arma order by cdescripcion;";
	$resArmas=$objConexion->ejecutarComando($sql);		
	return $resArmas;    
}

/*
Funcion: Retornar cursor con los transportes
Relacion: Formulario para generar reportes
Actualizacion: 27ago2015
*/
function CargarTransporte(){
        //session_start();
	$objConexion=new Conexion(); 
        $sql= "select ntransporteid, cdescripcion from tbl_tipo_transporte order by cdescripcion;";
	$resTransporte=$objConexion->ejecutarComando($sql);		
	return $resTransporte;    
}

/*
Funcion: Retornar cursor con los moviles
Relacion: Formulario para generar reportes
Actualizacion: 02ago2015
*/
function CargarMovil(){
        //session_start();
	$objConexion=new Conexion(); 
        $sql= "select nmovilid, cdescripcion from tbl_tipo_movil order by cdescripcion;";
	$resMovil=$objConexion->ejecutarComando($sql);		
	return $resMovil;    
}

/*
Funcion: Retornar cursor con los moviles
Relacion: Formulario para generar reportes
Actualizacion: 02ago2015
*/
function CargarObjeto(){
        //session_start();
	$objConexion=new Conexion(); 
        $sql= "select nobjetoid, cdescripcion from tbl_tipo_objeto order by cdescripcion;";
	$resObjeto=$objConexion->ejecutarComando($sql);		
	return $resObjeto;    
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
	$sql= "SELECT ndocumentoid, cdescripcion FROM tbl_tipodocumento order by cdescripcion;";
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

/*
Funcion: Retorna cadena con fecha ANSI añomesdia ejm 20131224 ¡navidad!
Relacion: Cualquier archivo que ocupe convertir
Actualizacion: 20sept2013
*/
function TxtFechaANSI($Fecha){
    $mes= substr($Fecha, 3, 2);
    $dia= substr($Fecha, 0, 2);
    $anio= substr($Fecha, 6, 4);

    return $anio.$mes.$dia;
}


function FechaANSI($Fecha){
    $mes= substr($Fecha, 0, 2);
    $dia= substr($Fecha, 3, 2);
    $anio= substr($Fecha, 6, 4);

    return $mes.$dia.$anio;
}
//
//function aFechaANSI($Fecha){        
//    $anio= substr($Fecha, 6, 4);
//    $dia= substr($Fecha, 3, 2);
//    $mes= substr($Fecha, 0, 2);
//    
//    return $anio.$mes.$dia;
//}

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
	$sql= "SELECT nescolaridadid, cdescripcion FROM tbl_escolaridad order by cdescripcion;";
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
	$sql= "SELECT ibandejaid, cdescripcion FROM mini_sedi.tbl_bandejas "
                . "where esfiscalia= 1 order by cdescripcion;";
       
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
            ."from mini_sedi.tbl_imputado p, mini_sedi.tbl_imputado_denuncia id "
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
	$sql= "SELECT trim(tbl_usuarios.nombres) || ' ' || trim(tbl_usuarios.apellidos) as nombrecompleto, "
              ."tbl_usuarios.identidad, tbl_usuarios.ibandejaid "
              ."FROM mini_sedi.tbl_usuarios WHERE "
              ."tbl_usuarios.isubbandejaid = ".$fiscalia." and fiscal= true order by nombrecompleto;";
        
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
	$sql= "select f.ibandejaid as fiscaliaid, cdescripcion "
            . "from mini_sedi.tbl_imputado_fiscalia if, mini_sedi.tbl_subbandejas f "
             ."where if.nfiscaliaid= f.isubbandejaid and bactivo= 't' and "
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
        
        $sql= "select f.identidad as fiscalid, trim(nombres) || ' ' || trim(apellidos) as nombrecompleto 
            from mini_sedi.tbl_imputado_fiscal i, mini_sedi.tbl_usuarios f where i.cfiscal= f.identidad and i.bactivo= 't' 
            and tdenunciaid= '$denunciaid' and timputadoid= '$imputado';";
//                
//        $sql= "select f.cfiscalid as fiscalid, trim(cnombres) || ' ' || trim(capellidos) as nombrecompleto "
//                ."from mini_sedi.tbl_imputado_fiscal i, mini_sedi.tbl_fiscal f "
//                ."where i.cfiscal= f.cfiscalid and bactivo= 't' and "
//                ."tdenunciaid= '".$denunciaid."' and "
//                ."timputadoid= '".$imputado."';";        
        
	$resFiscaliaActual=$objConexion->ejecutarComando($sql);	

//        exit($sql);
//        exit($resFiscaliaActual);
        return $resFiscaliaActual;
}

/*
Funcion: Retorna un cursor con todos los fiscale sde una subbandeja
Relacion: Formulario para rotar carga fiscal,
Actualizacion: 23sep2017 ¡mi cumpleaños!
*/
function CargarFiscal($ibandejaid, $subbandejaid)
{
	$objConexion=new Conexion(); 
        
        $sql= "select identidad, nombres ||', ' || apellidos as nombre
            from mini_sedi.tbl_subbandejas as b, mini_sedi.tbl_usuarios as u
            where u.ibandejaid= b.ibandejaid and u.isubbandejaid= b.isubbandejaid and
            u.ibandejaid= $ibandejaid and u.isubbandejaid= $subbandejaid 
            order by nombre;";
   
        
	$resFiscal=$objConexion->ejecutarComando($sql);	

//        exit($sql);
//        exit($resFiscaliaActual);
        return $resFiscal;
}

/*
Funcion: Retorna un registro con la fiscalia en q esta asignado un imputado
Relacion: Formulario para asignar denuncia a fiscalia,
 * denunciante
Actualizacion: 30may2012
*/
function CargarCargaFiscal($fiscal)
{
	$objConexion=new Conexion(); 
        
        $sql= "select impf.tdenunciaid, cnombres || ', ' || capellidos as imputado, cdescripcion as delito, 
                impdel.ndelito as delitoid, impdel.tpersonaid
                from mini_sedi.tbl_imputado_fiscal as impf, 
                mini_sedi.tbl_imputado as imp, 
                mini_sedi.tbl_imputado_delito as impdel,
                mini_sedi.tbl_delito as del
                where impf.timputadoid= imp.tpersonaid and impf.timputadoid= impdel.tpersonaid and
                impdel.ndelito= del.ndelitoid and impf.bactivo= true and 
                cfiscal= '$fiscal' order by tdenunciaid, tpersonaid, delitoid;";
        
	$resCargaFiscal=$objConexion->ejecutarComando($sql);	

//        exit($sql);
//        exit($resFiscaliaActual);
        return $resCargaFiscal;
}

/*
Funcion: Retorna un registro con los imputados del expediente segun denuncia
Relacion: Formulario para asignar actividad fiscal. actividad.php
Actualizacion: 21nar2013
*/
function CargarImputados(){
	$objConexion=new Conexion(); 
	$imputados= $_SESSION["denunciaid"];
	$sql= "SELECT tpersonaid, cnombres || ' ' || capellidos as cnombrecompleto, "
            ."bmenorinfractor "
            ."FROM tbl_imputado where tdenunciaid= ".$imputados.";";
	$resImputado=$objConexion->ejecutarComando($sql);    
        return $resImputado;
}


/*
Funcion: Retorna un registro con las etapas de un expediente
Relacion: Formulario para asignar actividad fiscal. actividad.php
Actualizacion: 21nar2013
*/
function CargarEtapa(){
	$objConexion=new Conexion(); 
	$sql= "select netapaid, cdescripcion from tbl_etapa ";
	$resEtapa=$objConexion->ejecutarComando($sql);
        return $resEtapa;
}

/*
Funcion: Retorna un registro con las materias
Relacion: Formulario para asignar actividad fiscal. actividad.php
Actualizacion: 21nar2013
*/
function CargarMateria(){
	$objConexion=new Conexion(); 
	$sql= "SELECT nmateria, cdescripcion FROM tbl_materia;";
	$resMateria=$objConexion->ejecutarComando($sql);
        return $resMateria;
}

/*
Funcion: Retorna cursor con las lcases de lugar de hechos
Relacion: Formulario para datos generales fiscalias
Actualizacion: 22feb2015
*/
function CargarClaseLugar()
{
	$objConexion=new Conexion(); 
	$sql= "SELECT nlugarid, cdescripcion FROM mini_sedi.tbl_clase_lugar_hecho order by cdescripcion;";
       
	$resClaseLugar=$objConexion->ejecutarComando($sql);

        return $resClaseLugar;
}

/*
Funcion: Retorna cursor con sub bandejas
Relacion: Formulario para asignar fiscal
Actualizacion: 20sept2017
*/
function CargarSubBandejas($sub)
{
	$objConexion=new Conexion(); 
	$sql= "select isubbandejaid, cdescripcion
                from mini_sedi.tbl_subbandejas
                where ibandejaid= $sub
                order by cdescripcion";
       
	$resSubBandeja=$objConexion->ejecutarComando($sql);

        return $resSubBandeja;
}

    function getRealIP()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
 
    }
    
/*
Funcion: Retorna IP real
Relacion: Todos los ORM
Actualizacion: 05may2012
Nota: Tomado de http://www.eslomas.com/2005/04/obtencion-ip-real-php/
*/
//function getRealIP()
//{
// 
//   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
//   {
//      $client_ip =
//         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
//            $_SERVER['REMOTE_ADDR']
//            :
//            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
//               $_ENV['REMOTE_ADDR']
//               :
//               "unknown" );
// 
//      // los proxys van añadiendo al final de esta cabecera
//      // las direcciones ip que van "ocultando". Para localizar la ip real
//      // del usuario se comienza a mirar por el principio hasta encontrar 
//      // una dirección ip que no sea del rango privado. En caso de no 
//      // encontrarse ninguna se toma como valor el REMOTE_ADDR
// 
//      $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);
// 
//      reset($entries);
//      while (list(, $entry) = each($entries))
//      {
//         $entry = trim($entry);
//         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
//         {
//            // http://www.faqs.org/rfcs/rfc1918.html
//            $private_ip = array(
//                  '/^0\./',
//                  '/^127\.0\.0\.1/',
//                  '/^192\.168\..*/',
//                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
//                  '/^10\..*/');
// 
//            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
// 
//            if ($client_ip != $found_ip)
//            {
//               $client_ip = $found_ip;
//               break;
//            }
//         }
//      }
//   }
//   else
//   {
//      $client_ip =
//         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
//            $_SERVER['REMOTE_ADDR']
//            :
//            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
//               $_ENV['REMOTE_ADDR']
//               :
//               "unknown" );
//   }
// 
//   return $client_ip;
// 
//}

/*
Funcion: Validar que el usuario
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: 
*/
function autenticar($usuario, $password, $tipoacceso)
{
    session_start();
    $objConexion= new Conexion();    
    $objUsuairo= new Usuario($objConexion, $usuario, $password);
  
    if ($objUsuairo->getConectado()== 0){
        $_SESSION['valido']= 0;
        header("location:../index.php");     
    }
 
    $_SESSION["objUsuario"]= $objUsuairo;
    $_SESSION['estado']= 'Autenticar';   
    $_SESSION['tipoacceso']= $objUsuairo->getTipoUsuario();
    ProcesaIncompleta();    
}

/*
Funcion: Validar que el usuario
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: 
*/
function autenticar2($usuario, $password)
{
    session_start(); 
    $objConexion= new Conexion();     
    $objUsuairo= new Usuario($objConexion, $usuario, $password); 
  
    if ($objUsuairo->getConectado()== 0){
        $_SESSION['valido']= 0;
        return 0;  
    }
    else{
        $_SESSION['valido']= 1;
        $_SESSION["objUsuario"]= $objUsuairo;
        $_SESSION['estado']= 'Autenticar';   
        $_SESSION['tipoacceso']= $objUsuairo->getTipoUsuario();
        return 1;
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
                    //si por errores de conexion quedo un registro en la tabla
                    //controldeestados con todos true, no entra al if anterior
                    //pero provocará error al guardar
                    $sql= "delete from tbl_controlestados where usr= '".$Usr."';";
                    $reg= $oConeccion->ejecutarComando($sql);                    
                    
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
    $sql= "SELECT ndelitoid, cdescripcion FROM mini_sedi.tbl_delito where bactivo= 't' order by cdescripcion;";
    $resDelito=$objConexion->ejecutarComando($sql);	

    return $resDelito;        
}

/*Funcion: Cargar lista de bandejas
 * Relacion: Administracion de bandejas
 * Actualizacion: 21may2k16
 * Nota: lo usa el programa administrador para cargar bandeja principal o secundaria
 * 
 */
function CargarBandeja($Principal= NULL, $Secundaria= NULL)
{
    $objConexion= new Conexion();
    if (is_null($Principal)){
        $sql= "select ibandejaid, cdescripcion from mini_sedi.tbl_bandejas order by cdescripcion;";
    }
    else{
        $sql= "select s.ibandejaid, s.cdescripcion 
            from mini_sedi.tbl_bandejas as b, mini_sedi.tbl_subbandejas as s 
            where b.ibandejaid = s.ibandejaid and and s.ibandejaid= $Principal
            order by s.cdescripcion;";
    }
    $rsBandejas= $objConexion->ejecutarComando($sql);
    
    return $rsBandejas;
}        

/*
Funcion: Conocer si se puede cambiar de tabulador
Relacion: Tabuladores de pantalla captura de denucia, crer_denuncia.php
Actualizacion: 06jun2k12
Nota: se puede cambiar de tabulador solo si ya se han grabado los
 * datos generales de la denuncia
*/
//NOTA: Se deja de usar y se sustituye por una variable de session
function CambiarAtab($pDenunciante)
{           
//    session_start();        

    $pusr= $_SESSION['usuario'];
//         exit($pusr);
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
function ListarContenidoBandeja($bandeja, $limit, $offset)
{ 
    //session_start();
    $pusr= $_SESSION['usuario'];
    
    //conocer la bandeja asignada
    $sql= "select cexpedientesedi, tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
            from bandeja_listacontenido_pl($bandeja) order by dfechadenuncia desc
            limit $limit offset $offset";
//    exit($sql);
    $objConexion= new Conexion();
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}

/*
Funcion: contar denuncias segun badeja asignada a usr
Relacion: frms para crear denuncia
Actualizacion: 11feb2k14
Nota: 
*/
function ContarListarContenidoBandeja($bandeja)
{
    //session_start();
    $pusr= $_SESSION['usuario'];
    
    //conocer la bandeja asignada
    $sql= "select tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
            from bandeja_listacontenido_pl($bandeja) order by tdenunciaid";
                
    $objConexion= new Conexion();
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return pg_num_rows($rsCursor);
}

/*
Funcion: Listar denuncias asignadas a esa fiscalia
Relacion: frms para asignar denuncia a fiscal. La denuncia ya esta pasada a la fiscalia
Actualizacion: 03dic2k12
Nota: 
*/
//function ListarPendientesFiscal($fiscalia)
//{
//    //session_start();
//    $pusr= $_SESSION['usuario'];
//    
//    //conocer la bandeja asignada
//    $sql= "select tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
//            from bandeja_fiscalia_pl($fiscalia)";
//    
////    exit($sql);
//    $objConexion= new Conexion();
//    $rsCursor= $objConexion->ejecutarComando($sql);
//    
//    return $rsCursor;
//}

/*
Funcion: Listar denuncias asignadas a esa fiscalia
Relacion: frms para asignar denuncia a fiscal. La denuncia ya esta pasada a la fiscalia
Actualizacion: 03dic2k12
Nota: 
*/
function ListarPendientesFiscal($fiscalia, $asignada=TRUE)
{
    //session_start();
//    $pusr= $_SESSION['usuario'];    
   
    //conocer la bandeja asignada
    //false= no asignada a fiscal; true= ya asignada

    if ($asignada== 'asignada'){
        $asignada= 'true';
    }
    else
    {
        if ($asignada== 'noasignada'){
            $asignada= 'false';
        }
        else{
            $asignada= 'false';
        }
    }
    
    $sql= "select tdenunciaid, cdescripcion, dfechadenuncia, cnarracionhecho
            from mini_sedi.bandeja_fiscalia_pl($fiscalia, $asignada) order by dfechadenuncia desc";
    
//    exit($sql);
    $objConexion= new Conexion();
    $rsCursor= $objConexion->ejecutarComando($sql);

    return $rsCursor;
}

/*
Funcion: Generar rpt busqueda global
Relacion: frms buscar
Actualizacion: 14feb2014
Nota: 
*/
function BusquedaGlobal($Buscar, $Nombre, $Apellido, $limit, $offset)
{ 
    if ($Buscar== 'denunciado'){
    $sql="SELECT 
            tbl_imputado.tdenunciaid,
            tbl_denuncia.cexpedientesedi,
            tbl_imputado.cnombres || ', ' ||
            tbl_imputado.capellidos as nombrecompleto, 
            tbl_delito.cdescripcion as delito, 
            tbl_denuncia.dfechadenuncia, 
            case when tbl_denuncia.basignadafiscal= 'f' then 'Sin asignar'
            else 'Asignada'
            end as asignada, 
            tbl_bandejas.cdescripcion
          FROM 
            mini_sedi.tbl_denuncia, 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_bandejas
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado.cnombres like '%$Nombre%' and
            tbl_imputado.capellidos like '%$Apellido%' and
            tbl_denuncia.cestadodenuncia = 'A' and 
            tbl_imputado.nconocido = 1
          ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
          "; 
    }
    
    if ($Buscar== 'denunciante'){
        $sql="SELECT 
                tbl_denunciante.tdenunciaid,
                tbl_denuncia.cexpedientesedi,
                tbl_denunciante.cnombres || ', ' ||
                tbl_denunciante.capellidos as nombrecompleto, 
                tbl_delito.cdescripcion as delito, 
                tbl_denuncia.dfechadenuncia, 
                case when tbl_denuncia.basignadafiscal= 'f' then 'Sin asignar'
                else 'Asignada'
                end as asignada, 
                tbl_bandejas.cdescripcion
              FROM 
                mini_sedi.tbl_denuncia, 
                mini_sedi.tbl_denunciante, 
                mini_sedi.tbl_imputado, 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_bandejas
              WHERE 
                tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
                tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
                tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
                tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
                tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_denunciante.cnombres like '%$Nombre%' and
                tbl_denunciante.capellidos like '%$Apellido%' and
                tbl_denunciante.nconocido = 1
              ORDER BY
                tbl_denunciante.cnombres ASC, 
                tbl_denunciante.capellidos ASC
                limit $limit offset $offset;
              "; 
    }    
    
    if ($Buscar== 'ofendido'){
        $sql="SELECT 
                tbl_ofendido.tdenunciaid,
                tbl_denuncia.cexpedientesedi,
                tbl_ofendido.cnombres || ', ' ||
                tbl_ofendido.capellidos as nombrecompleto, 
                tbl_delito.cdescripcion as delito, 
                tbl_denuncia.dfechadenuncia, 
                case when tbl_denuncia.basignadafiscal= 'f' then 'Sin fiscal'
                else 'Asignada'
                end as asignada, 
                tbl_bandejas.cdescripcion
              FROM 
                mini_sedi.tbl_denuncia, 
                mini_sedi.tbl_ofendido, 
                mini_sedi.tbl_imputado, 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_bandejas
              WHERE 
                tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
                tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
                tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
                tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
                tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_ofendido.cnombres like '%$Nombre%' and
                tbl_ofendido.capellidos like '%$Apellido%' and
                tbl_ofendido.nconocido = 1
              ORDER BY
                tbl_ofendido.cnombres ASC, 
                tbl_ofendido.capellidos ASC
                limit $limit offset $offset;
              "; 
    }     
//echo($sql);
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}

/*
Funcion: Generar rpt busqueda global
Relacion: frms buscar
Actualizacion: 14feb2014
Nota: 
*/
function ContarBusquedaGlobal($Buscar, $Nombre, $Apellido, $limit, $offset)
{ 
    if ($Buscar== 'denunciado'){
        $sql="SELECT 
                tbl_imputado.tdenunciaid,
                tbl_imputado.cnombres || ', ' ||
                tbl_imputado.capellidos as nombrecompleto, 
                tbl_delito.cdescripcion as delito, 
                tbl_denuncia.dfechadenuncia, 
                case when tbl_denuncia.basignadafiscal= 'f' then 'Sin asignar'
                else 'Asignada'
                end as asignada, 
                tbl_bandejas.cdescripcion
              FROM 
                mini_sedi.tbl_denuncia, 
                mini_sedi.tbl_imputado, 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_bandejas
              WHERE 
                tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
                tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
                tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
                tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_imputado.cnombres like '%$Nombre%' and
                tbl_imputado.capellidos like '%$Apellido%' and 
                tbl_denuncia.cestadodenuncia = 'A' and 
                tbl_imputado.nconocido = 1
              ORDER BY
                tbl_imputado.cnombres ASC, 
                tbl_imputado.capellidos ASC
                limit $limit offset $offset;
              "; 
    }

    if ($Buscar== 'denunciante'){
        $sql="SELECT 
                tbl_denunciante.tdenunciaid,
                tbl_denunciante.cnombres || ', ' ||
                tbl_denunciante.capellidos as nombrecompleto, 
                tbl_delito.cdescripcion as delito, 
                tbl_denuncia.dfechadenuncia, 
                case when tbl_denuncia.basignadafiscal= 'f' then 'Sin asignar'
                else 'Asignada'
                end as asignada, 
                tbl_bandejas.cdescripcion
              FROM 
                mini_sedi.tbl_denuncia, 
                mini_sedi.tbl_denunciante, 
                mini_sedi.tbl_imputado, 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_bandejas
              WHERE 
                tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
                tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
                tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
                tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
                tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_denunciante.cnombres like '%$Nombre%' and
                tbl_denunciante.capellidos like '%$Apellido%' and
                tbl_denunciante.nconocido = 1
              ORDER BY
                tbl_denunciante.cnombres ASC, 
                tbl_denunciante.capellidos ASC
                limit $limit offset $offset;
              "; 
    }
    
    if ($Buscar== 'ofendido'){
        $sql="SELECT 
                tbl_ofendido.tdenunciaid,
                tbl_ofendido.cnombres || ', ' ||
                tbl_ofendido.capellidos as nombrecompleto, 
                tbl_delito.cdescripcion as delito, 
                tbl_denuncia.dfechadenuncia, 
                case when tbl_denuncia.basignadafiscal= 'f' then 'Sin fiscal'
                else 'Asignada'
                end as asignada, 
                tbl_bandejas.cdescripcion
              FROM 
                mini_sedi.tbl_denuncia, 
                mini_sedi.tbl_ofendido, 
                mini_sedi.tbl_imputado, 
                mini_sedi.tbl_imputado_delito, 
                mini_sedi.tbl_delito, 
                mini_sedi.tbl_bandejas
              WHERE 
                tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
                tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
                tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND
                tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
                tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
                tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
                tbl_ofendido.cnombres like '%$Nombre%' and
                tbl_ofendido.capellidos like '%$Apellido%' and
                tbl_ofendido.nconocido = 1
              ORDER BY
                tbl_ofendido.cnombres ASC, 
                tbl_ofendido.capellidos ASC
                limit $limit offset $offset;
              "; 
    } 
    
//    exit($sql);
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return pg_num_rows($rsCursor);
}
//--


/*
Funcion: Generar rpt busqueda global
Relacion: frms buscar
Actualizacion: 14feb2014
Nota: 
*/
function BusquedaFiscalia($Buscar, $Nombre, $Apellido, $limit, $offset)        
{ 
    if ($Buscar== 'denuncia'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and
            tbl_imputado.tdenunciaid = '$Nombre' 
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";  
    }
    
    if ($Buscar== 'denunciado'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_imputado.cnombres like '%$Nombre%' and
            tbl_imputado.capellidos like '%$Apellido%'
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";
    }
    
    if ($Buscar== 'denunciante'){
    $sql= "SELECT 
            tbl_denunciante.tdenunciaid as denuncia,
            tbl_denunciante.cnombres || ', ' || tbl_denunciante.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_denunciante,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_denunciante.cnombres like '%$Nombre%' and
            tbl_denunciante.capellidos like '%$Apellido%'
            ORDER BY
            tbl_denunciante.cnombres ASC, 
            tbl_denunciante.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
    
    if ($Buscar== 'ofendido'){
    $sql= "SELECT 
            tbl_ofendido.tdenunciaid as denuncia,
            tbl_ofendido.cnombres || ', ' || tbl_ofendido.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_ofendido,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_ofendido.cnombres like '%$Nombre%' and
            tbl_ofendido.capellidos like '%$Apellido%'
            ORDER BY
            tbl_ofendido.cnombres ASC, 
            tbl_ofendido.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
    
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}

/*
Funcion: Generar rpt busqueda global
Relacion: frms buscar
Actualizacion: 14feb2014
Nota: 
*/
function ContarBusquedaFiscalia($Buscar, $Nombre, $Apellido, $limit, $offset)
{ 
    if ($Buscar== 'denunciado'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_imputado.cnombres like '%$Nombre%' and
            tbl_imputado.capellidos like '%$Apellido%'
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";
    }

    if ($Buscar== 'denunciante'){
    $sql= "SELECT 
            tbl_denunciante.tdenunciaid as denuncia,
            tbl_denunciante.cnombres || ', ' || tbl_denunciante.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_denunciante,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_denunciante.cnombres like '%$Nombre%' and
            tbl_denunciante.capellidos like '%$Apellido%'
            ORDER BY
            tbl_denunciante.cnombres ASC, 
            tbl_denunciante.capellidos ASC
            limit $limit offset $offset;
            ";        
    }    
    
    if ($Buscar== 'ofendido'){
    $sql= "SELECT 
            tbl_ofendido.tdenunciaid as denuncia,
            tbl_ofendido.cnombres || ', ' || tbl_ofendido.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_fiscalia.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_ofendido,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_fiscalia, 
            mini_sedi.tbl_imputado_fiscalia
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_fiscalia.nfiscaliaid and 
            tbl_ofendido.cnombres like '%$Nombre%' and
            tbl_ofendido.capellidos like '%$Apellido%'
            ORDER BY
            tbl_ofendido.cnombres ASC, 
            tbl_ofendido.capellidos ASC
            limit $limit offset $offset;
            ";        
    }    
      
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return pg_num_rows($rsCursor);
}

/*
Funcion: Generar rpt busqueda mostrando fiscal por fiscalia login
Relacion: frms buscar
Actualizacion: 17ago2016
Nota: 
*/
function BusquedaFiscal($Buscar, $Nombre, $Apellido, $limit, $offset)
{ 
    if ($Buscar== 'denuncia'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and
            tbl_imputado.tdenunciaid = '$Nombre' 
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";  
    }
    
    if ($Buscar== 'denunciado'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and
            tbl_imputado.cnombres like '%$Nombre%' and
            tbl_imputado.capellidos like '%$Apellido%'
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";  
    }
    
    if ($Buscar== 'denunciante'){
    $sql= "SELECT 
            tbl_denunciante.tdenunciaid as denuncia,
            tbl_denunciante.cnombres || ', ' || tbl_denunciante.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo, 
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_denunciante,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and 
            tbl_denunciante.cnombres like '%$Nombre%' and
            tbl_denunciante.capellidos like '%$Apellido%'
            ORDER BY
            tbl_denunciante.cnombres ASC, 
            tbl_denunciante.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
    
    if ($Buscar== 'ofendido'){
    $sql= "SELECT 
            tbl_ofendido.tdenunciaid as denuncia,
            tbl_ofendido.cnombres || ', ' || tbl_ofendido.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_ofendido,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and 
            tbl_ofendido.cnombres like '%$Nombre%' and
            tbl_ofendido.capellidos like '%$Apellido%'
            ORDER BY
            tbl_ofendido.cnombres ASC, 
            tbl_ofendido.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
    
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
}

/*
Funcion: Generar rpt busqueda mostrando fiscal por fiscalia login
Relacion: frms buscar
Actualizacion: 17ago2016
Nota: 
*/
function ContarBusquedaFiscal($Buscar, $Nombre, $Apellido, $limit, $offset)
{ 
    if ($Buscar== 'denuncia'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and
            tbl_imputado.tdenunciaid = '$Nombre' 
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";  
    }
    
    if ($Buscar== 'denunciado'){
    $sql= "SELECT 
            tbl_imputado.tdenunciaid as denuncia,
            tbl_imputado.cnombres || ', ' || tbl_imputado.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and
            tbl_imputado.cnombres like '%$Nombre%' and
            tbl_imputado.capellidos like '%$Apellido%'
            ORDER BY
            tbl_imputado.cnombres ASC, 
            tbl_imputado.capellidos ASC
            limit $limit offset $offset;
            ";  
    }
    
    if ($Buscar== 'denunciante'){
    $sql= "SELECT 
            tbl_denunciante.tdenunciaid as denuncia,
            tbl_denunciante.cnombres || ', ' || tbl_denunciante.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo, 
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_denunciante,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and 
            tbl_denunciante.cnombres like '%$Nombre%' and
            tbl_denunciante.capellidos like '%$Apellido%'
            ORDER BY
            tbl_denunciante.cnombres ASC, 
            tbl_denunciante.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
    
    if ($Buscar== 'ofendido'){
    $sql= "SELECT 
            tbl_ofendido.tdenunciaid as denuncia,
            tbl_ofendido.cnombres || ', ' || tbl_ofendido.capellidos as nombre_imputado, 
            tbl_delito.cdescripcion as delito, 
            tbl_subbandejas.cdescripcion as fiscalia, 
            tbl_imputado_fiscalia.dfechaasignacion as fasignado, 
            case when tbl_imputado_fiscalia.bactivo= 't' then 'Activo'
            else 'Inactivo'
            end as activo,
            tbl_usuarios.nombres || ' ' || tbl_usuarios.apellidos as fiscal
          FROM 
            mini_sedi.tbl_denuncia,
            mini_sedi.tbl_imputado, 
            mini_sedi.tbl_ofendido,
            mini_sedi.tbl_imputado_delito, 
            mini_sedi.tbl_delito, 
            mini_sedi.tbl_subbandejas, 
            mini_sedi.tbl_imputado_fiscalia,
            mini_sedi.tbl_imputado_fiscal,
            mini_sedi.tbl_usuarios
          WHERE 
            tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
            tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
            tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
            tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
            tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
            tbl_imputado_delito.tpersonaid = tbl_imputado_fiscalia.timputadoid AND
            tbl_imputado_delito.tdenunciaid = tbl_imputado_fiscalia.tdenunciaid AND
            tbl_imputado_fiscalia.nfiscaliaid = tbl_subbandejas.isubbandejaid and 
            tbl_imputado_fiscal.tdenunciaid = tbl_imputado.tdenunciaid and 
            tbl_usuarios.identidad = tbl_imputado_fiscal.cfiscal and 
            tbl_ofendido.cnombres like '%$Nombre%' and
            tbl_ofendido.capellidos like '%$Apellido%'
            ORDER BY
            tbl_ofendido.cnombres ASC, 
            tbl_ofendido.capellidos ASC
            limit $limit offset $offset;
            ";        
    }
//    exit($sql);
    $objConexion= new Conexion(); 
    $rsCursor= $objConexion->ejecutarComando($sql);
    
    return $rsCursor;
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
