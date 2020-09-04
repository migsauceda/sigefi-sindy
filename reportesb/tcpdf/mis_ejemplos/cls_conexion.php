<?php

class cls_conexion{
    private $link;
	
    function __construct(){}
    public function conectar() {
		$String_conexion="host=localhost port=5432 password=123 user=admin dbname=prueba";
		
		//echo ">".$String_conexion."<";
        $this->link = pg_connect($String_conexion);
        if (!$this->link) {
            die('No pudo realizar la conexion con la base de datos');
        }else{
			//echo "conexion realizada";
		}
    }
    public function cerrar() {
        pg_close($this->link);
    }
    public function consultar($consulta) {
       $resultado=pg_exec($this->link,$consulta);
	   return $resultado;
    }
	public function insertar($consulta) {
       pg_exec($this->link,$consulta);
    }
}

?>
