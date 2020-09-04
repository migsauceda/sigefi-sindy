<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author miguel
 */
class Usuario {
    private $Usuario;
    private $Nombres;
    private $Apellidos;
    private $Identidad;
    private $Oficina;
    private $OficinaId;
    private $Bandeja;
    private $BandejaId;
    private $SubBandeja;
    private $SubBandejaId;    
    private $RolId;
    private $Rol;
    private $TareaList;    
    private $Estado; // login, logout, sintareas, error
    private $Conectado; //1 si 0 no
    private $TipoUsuario; //"Fiscal" "Receptor"
    private $DeptoRecepcion; //depto del pais donde se recibe
    private $MuniRecepcion; //municipio donde se recibe
    private $DeptoRecepcionid;
    private $MuniRecepcionid;
    /**
     * 
     * @param type $objConexion: objeto con conexion valida a la bd
     * @param type $usr: usuario ingesado en la interfaz login
     * @param type $pass: clave ingrsada en la interfaz login
     */
    function __construct($objConexion, $usr, $password) {        
        $this->Conectado= 0;
        $this->Usuario= $usr;        
        $sql= "SELECT tbl_usuarios.contrasena, tbl_usuarios.usuario, 
            tbl_usuarios.nombres, tbl_usuarios.apellidos, 
            tbl_usuarios.identidad, tbl_usuarios.ibandejaid, 
            tbl_bandejas.cdescripcion as bandeja, 
            tbl_usuarios.isubbandejaid, 
            tbl_subbandejas.cdescripcion as subbandeja, tbl_usuarios.rol, 
            tbl_rol.descripcion as drol, tbl_usuarios.fiscal,
            tbl_subbandejas.cmunicipioid,
            (select cdescripcion from mini_sedi.tbl_municipio where cmunicipioid= tbl_bandejas.cmunicipio and
            cdepartamentoid= tbl_bandejas.cdeptopais) as cmunicipio, 
            tbl_subbandejas.cdeptopaisid,
            (select cdescripcion from mini_sedi.tbl_departamentopais where cdepartamentoid= tbl_bandejas.cdeptopais) as cdeptopais
            FROM mini_sedi.tbl_usuarios, mini_sedi.tbl_rol, 
            mini_sedi.tbl_subbandejas, mini_sedi.tbl_bandejas
            WHERE tbl_usuarios.rol = tbl_rol.rolid AND 
            tbl_usuarios.ibandejaid = tbl_bandejas.ibandejaid AND 
            tbl_usuarios.isubbandejaid = tbl_subbandejas.isubbandejaid AND 
            usuario= '$usr';";

        $resultado=$objConexion->ejecutarComando($sql);

        if(pg_num_rows($resultado)<= 0){                                       
            $this->Conectado= 0;
            $this->Estado= "error1";
        }
        else{            
            $registro= pg_fetch_array($resultado);
            $passcrypt= $registro["contrasena"];
            //verificar si es el password correcto. 
            //clave retorna true si coninciden
            if (!clave($password, $passcrypt)){  
                $this->Conectado= 0;
                $this->Estado= "error2";
            }   
            else{
                //Verificacion ultimo acceso de sesion del usuario
                $querySession=$objConexion->ejecutarComando("SELECT * FROM tbl_user_session WHERE usuario ='$usr'");

                //$query_session=$db::consulta($txtsql_user_session);
                $numExist=pg_num_rows($querySession);
                if($numExist == 0){
                    $queryInsert=$objConexion->ejecutarComando("INSERT INTO tbl_user_session(usuario,ip_address,last_access)
                                    VALUES('$usr','".$_SERVER['REMOTE_ADDR']."','now()')");
                }else{
//                        echo
//                        "<script>
//                            alert('Este usuario YA ha iniciado sesion en otra maquina');
//                            location.href='../index.php';
//                        </script>";
                }

                $queryInsert_log=$objConexion->ejecutarComando("INSERT INTO tbl_log_general(usuario,ip_address,time_date,descripcion)
                VALUES('$usr','".$_SERVER['REMOTE_ADDR']."',now(),'Ingreso al Sistema')");          
        
                $this->Usuario= $registro["usuario"];
                $this->Identidad= $registro["identidad"];
                $this->Nombres= $registro["nombres"];
                $this->Apellidos= $registro["apellidos"];
                
                $this->OficinaId= $registro["isubbandejaid"];
                $this->Oficina= $registro["subbandeja"];

                $this->BandejaId= $registro["ibandejaid"];
                $this->Bandeja= $registro["bandeja"];
                $this->SubBandejaId= $registro["isubbandejaid"];
                $this->SubBandeja= $registro["subbandeja"];
               
                $this->MuniRecepcion= $registro["cmunicipio"];
                $this->DeptoRecepcion= $registro["cdeptopais"];
                $this->DeptoRecepcionid= $registro["cdeptopaisid"];
                $this->MuniRecepcionid= $registro["cmunicipioid"];
                        
                $this->RolId= $registro["rol"];  
                $this->Rol= $registro["drol"];  
                
                if ($registro["fiscal"]== 'f'){
                    $this->TipoUsuario= 'Receptor'  ;
                }else{
                    $this->TipoUsuario= 'Fiscal'  ;
                }
                
                $this->Estado= "login";
                $this->Conectado= 1;
                $this->ConocerTareas($usr, $objConexion);         
//                exit($this->OficinaId);
            }            
        }        
    }

    public function getDeptoRecepcionId(){
        return $this->DeptoRecepcionid;
    }
    
    public function getMuniRecepcionId(){
        return $this->MuniRecepcionid;
    }
    
    public function getDeptoRecepcion(){
        return $this->DeptoRecepcion;
    }
    
    public function getMuniRecepcion(){
        return $this->MuniRecepcion;
    }
    
    public function getTipoUsuario(){
        return $this->TipoUsuario;
    }
    
    public function getConectado(){
        return $this->Conectado;
    }
    
    public function getEstado(){
        return $this->Estado;
    }

    public function getUsuario() {
        return $this->Usuario;
    }

    public function getNombres() {
        return $this->Nombres;
    }

    public function getApellidos() {
        return $this->Apellidos;
    }

    public function getIdentidad() {
        return $this->Identidad;
    }

    public function getOficina() {
        return $this->Oficina;
    }

    public function getOficinaId() {
        return $this->OficinaId;
    }

    public function getBandeja() {
        return $this->Bandeja;
    }

    public function getBandejaId() {
        return $this->BandejaId;
    }

    public function getSubBandeja() {
        return $this->SubBandeja;
    }

    public function getSubBandejaId() {
        return $this->SubBandejaId;
    }

    public function getRol() {
        return $this->Rol;
    }

    public function getTareaList() {
        return $this->TareaList;
    }

    public function setUsuario($Usuario) {
        $this->Usuario = $Usuario;
    }

    public function setNombres($Nombres) {
        $this->Nombres = $Nombres;
    }

    public function setApellidos($Apellidos) {
        $this->Apellidos = $Apellidos;
    }

    public function setIdentidad($Identidad) {
        $this->Identidad = $Identidad;
    }

    public function setOficina($Oficina) {
        $this->Oficina = $Oficina;
    }

    public function setOficinaId($OficinaId) {
        $this->OficinaId = $OficinaId;
    }

    public function setBandeja($Bandeja) {
        $this->Bandeja = $Bandeja;
    }

    public function setBandejaId($BandejaId) {
        $this->BandejaId = $BandejaId;
    }

    public function setSubBandeja($SubBandeja) {
        $this->SubBandeja = $SubBandeja;
    }

    public function setSubBandejaId($SubBandejaId) {
        $this->SubBandejaId = $SubBandejaId;
    }

    public function setRol($Rol) {
        $this->Rol = $Rol;
    }

    public function setTareaList($Tareas) {
//        $this->Tareas = $Tareas;
    }

    public function Login($param) {
        
    }
    
    public function getPermiso($Tarea){
        if (in_array($Tarea, $this->TareaList)){
            return '1';
        }
        else{
            return '0';
        }
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
Funcion: Conocer las tareas que puede hacer el usr, segun su rol, las guarda en una variable
    de session de tipo cadena y llamada $tarea, separada por guines "-"
Relacion: Inicio de sesion
Actualizacion: 25may2012
Nota: 
*/
function ConocerTareas($usuario, $objConexion)
{
	$sql= "select rolid from mini_sedi.tbl_usr_rol where usuario="."'".$usuario."';";
	$Cursor= $objConexion->ejecutarComando($sql);	

	$TareaList="";
	while($Rol= pg_fetch_array($Cursor))
	{
		$sql= "select tarea from mini_sedi.tbl_rol_tarea where rolid=".$Rol[rolid];
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
                $this->TareaList = explode("-",$TareaList);
	}
	else
	{
            $this->Estado= "SinTareas";
	}
	if ($error== 1)
	{
            $this->Estado= "Error";
	}
	else
	{           
            $objConexion->cerrarConexion();
	}
}    
}
