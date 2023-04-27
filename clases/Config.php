<?php
abstract class Config {
    protected $servidor = "localhost";
    protected $base_datos = "sigefi";
    protected $usuario = "musuariologin";
    protected $contrasena = "(clave123)"; //ojo la misma del rol mini_sedi_login
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
