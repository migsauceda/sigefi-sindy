<?php
//require_once '../denuncia/ORM_Denuncia.php';

 
//Una denuncia esta formada por al menos un denunciante, un ofendido, un imputado y una actividad procesal
class Relaciones {
    public function RecuperarOfendido($value)
    {
        $sql= "select tdenunciaid, nimputadoid, nofendidoid, nparentescoid 
            from mini_sedi.tbl_imputado_ofendido
            where tdenunciaid= ".$value." order by nofendidoid;";

        $objConexion= new Conexion();
	$Cursor= $objConexion->ejecutarComando($sql);
//exit($sql);
	return $Cursor;
    }
    
    public function RecuperarDenunciante($value)
    {
        $sql= "select tdenunciaid, nimputadoid, ndenuncianteid, nparentescoid 
            from mini_sedi.tbl_imputado_denunciante
            where tdenunciaid= ".$value." order by ndenuncianteid;";

        $objConexion= new Conexion();
	$Cursor= $objConexion->ejecutarComando($sql);

	return $Cursor;
    }    
}
?>