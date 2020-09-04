<?php
abstract class Config {
    protected $servidor = "localhost";
    protected $base_datos = "mini_sedi";
    protected $usuario = "postgres";
    protected $contrasena = "postgres";
	protected $puerto="5432";
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
}
?>