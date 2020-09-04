<?php
session_start();
include_once "php_funciones.php";

$_SESSION['usuario']= $_POST['txtUsr'];
$password= $_POST['txtPasswd'];
$usuario= $_SESSION['usuario'];

autenticar($usuario, $password);
?>
