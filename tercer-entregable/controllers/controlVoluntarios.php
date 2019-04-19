<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

require_once("../models/gestionBD.php");
require_once("../models/gestionVoluntarios.php");
require_once("../includes/functions.php");

if($_REQUEST["submit"]=="delete"){
	$conexion = crearConexionBD();
    getEliminarVoluntario($conexion, $_REQUEST["dni"]);
    cerrarConexionBD($conexion);
    Header("Location: ../voluntarios.php");
}
?>