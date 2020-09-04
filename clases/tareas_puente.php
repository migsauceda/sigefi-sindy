<?php
session_start();
include("tareas_procesar.php");

function LlamarCrearTarea()
{
	$usr= $_SESSION['usuario'];
	
	CrearTareas();
}
?>