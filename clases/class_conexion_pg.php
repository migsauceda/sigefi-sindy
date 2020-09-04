    <?php
/*Clase para conectarse con la base de datos*/
include 'Config.php'; 
class Conexion extends Config{

	private $conexionPostgreSQL;
        private $stringConexion;
        
        function __construct(){ 
            $this->stringConexion="host=".parent::getServidor()." port=".parent::getPuerto()." dbname=".parent::getBaseDatos()." user=". parent::getUsuario()." password=".parent::getContrasena();
//echo $this->stringConexion;
            if(!($this->conexionPostgreSQL=pg_connect($this->stringConexion))){
                    echo "Error al conectarse";
                    exit();
            }	
            
            $this->ejecutarComando("set search_path = mini_sedi");
//            $this->ejecutarComando("set schema 'mini_sedi'");
            
//            else
//                exit("conectado");

        }

        function Conexion(){
            return $this->conexionPostgreSQL;
        }
        
        function Insertar($sql){
            $resultado= pg_query($this->conexionPostgreSQL,$sql); 
            if ($resultado){
                return TRUE; //exito
            }else {
                return FALSE; //error
            }
        }
                
        function ejecutarComando($stringConsulta){
               $resultado = pg_query($this->conexionPostgreSQL,$stringConsulta);
               return $resultado;
        }

        function ejecutarProcedimiento($stringConsulta){ 
               $resultado = pg_query($this->conexionPostgreSQL,$stringConsulta); 
               return $resultado;
        }

        function cerrarConexion(){
            pg_close($this->conexionPostgreSQL);
            //mysql_close($this->conexionPostgreSQL);
        }

        function begintransaction() {
            $this->ejecutarComando('begin transaction');
        }
        
        function commit() {
           $this->ejecutarComando('commit transaction');
        }
        
        function rollback() {
           $this->ejecutarComando('rollback transaction');
        }
        
        function setsavepoint($savepointname){
           $this->ejecutarComando("savepoint $savepointname");
        }
        
        function rollbacktosavepoint($savepointname){
           $this->ejecutarComando("rollback to savepoint $savepointname");
        }
}
?>