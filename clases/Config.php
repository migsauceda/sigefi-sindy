<?php
abstract class Config {
//    protected $servidor = "localhost";
//    protected $base_datos = "sigefi";
//    protected $usuario = "mini_sedi_login";
//    protected $contrasena = "(m1n1*cd1)"; //ojo la misma del rol mini_sedi_login
//    protected $puerto="5432";
//    protected $esquema= "mini_sedi";

    protected $servidor = "localhost";
    protected $base_datos = "probando";
    protected $usuario = "postgres";
    protected $contrasena = "ministerio"; //ojo la misma del rol mini_sedi_login
    protected $puerto="5432";
    protected $esquema= "mini_sedi";
    
    protected function getServidor() {
        return $this->servidor;
    }
    protected function getBaseDatos() {
        return $this->base_datos;
    }
    protected function getUsuario() {
        return $this->usuario;
    }
    protected function getContrasena() {
        return $this->contrasena;
    }
    protected function getPuerto() {
        return $this->puerto;
    }
    protected function getEsquema(){
        return $this->esquema;
    }
}
?>
