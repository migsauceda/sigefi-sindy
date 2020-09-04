<?php
/**
 * Description of DeptoMuniCiudad
 Retorna los deptos, municipios, ciudad
 */
//require_once '../clases/Usuario.php';
//include "class_conexion_pg.php";

class DeptoMuniCiudad {
    private $Departamentos;
    private $Municipios;
    private $Ciudades;
//    private $objConexion;
    
    
    function __construct(){        
        //conocer cantidad de parámetros y los parámetros en si
        $num= func_num_args();
        $par= func_get_args();
//        if (method_exists(this, $f= '__construct'.$num)){
//            call_user_func_array(array($this,$f), $par);
//        }
        switch ($num) {
            case 0:
                self::__construct0();
                break;            
            case 1:
                self::__construct1($par[0]);
                break;
            case 2:
                self::__construct2($par[0], $par[1]);
                break;          
            default:
                break;
        }
        
    }

    function __construct0(){
        //carga todos los departamentos
        $objConexion=new Conexion();
        $sql= "select cdepartamentoid, cdescripcion from mini_sedi.tbl_departamentopais";              
        $this->Departamentos=$objConexion->ejecutarComando($sql);
        $this->getDepartamentoLista();
    }
    
    function __construct1($depto){ 
        //carga lista de municipios dado el depto
        $objConexion=new Conexion();
        $sql= "select cmunicipioid, cdescripcion from mini_sedi.tbl_municipio
                where cdepartamentoid= '$depto' order by cdescripcion";    
        $this->Municipios= $objConexion->ejecutarComando($sql);
//        $this->getMunicipioLista();
    }
    function __construct2($depto, $muni){        
        //carga lista de ciudades dado el depto y el muni
        $objConexion=new Conexion();
        $sql= " select caldeaid, cdescripcion from mini_sedi.tbl_aldea
                where cdepartamentoid= '$depto' and cmunicipioid= '$muni'
                order by cdescripcion";        
        $this->Ciudades= $objConexion->ejecutarComando($sql);
        $this->getCiudadLista();
    }       
    
    public function getDepartamentoLista() {
        //retorna todos los deptos
        //$sql= "select cdepartamentoid, cdescripcion from mini_sedi.tbl_departamentopais";
        //return pg_fetch_array($this->Departamentos);
        return ($this->Departamentos);
    }
    public function getMunicipioLista() {
        //recibe departamento
        /*$sql= "select cmunicipioid, cdescripcion from mini_sedi.tbl_municipio
                where cdepartamentoid= '$depto' order by cdescripcion";
         */
        return ($this->Municipios);       
    }
    public function getCiudadLista() {
        //recibe depto, muni
        /*$sql= " select caldeaid, cdescripcion from mini_sedi.tbl_aldea
                where cdepartamentoid= '$depto' and cmunicipioid= '$muni'
                order by cdescripcion";
        */
        return ($this->Ciudades);
    }
    public function getDepartamentoNombre() {
        //retorna el nombre del depto ativo
        
    }
    public function getMunicipioNombre() {
        //retorna el nombre del municipio activo
        
    }
    public function getCiudadNombre($param) {
        //retorna el nombre de la ciudad con codigo
        
    }
}
