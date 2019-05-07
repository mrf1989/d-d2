<?php
session_start();

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
}
include_once("../models/gestionBD.php");
include_once("../models/gestionParticipantes.php");
include_once("../models/gestionTutores.php");
include_once("../models/gestionVoluntarios.php");
include_once("../models/gestionUsuarios.php");
include_once("../includes/functions.php");

if ($_SESSION["user"] == 2) {
	if ($_REQUEST["submit"] == 'edit') {
    	$participante["nombre"] = $_REQUEST["nombre"];
    	$participante["apellidos"] = $_REQUEST["apellidos"];
    	$participante["dni"] = $_REQUEST["dni"];
    	$participante["fechaNacimiento"] = getFechaBD($_REQUEST["fechaNacimiento"]);
    	$participante["email"] = $_REQUEST["email"];
    	$participante["telefono"] = $_REQUEST["telefono"];
    	$participante["direccion"] = $_REQUEST["direccion"];
    	$participante["localidad"] = $_REQUEST["localidad"];
    	$participante["provincia"] = $_REQUEST["provincia"];
    	$participante["cp"] = $_REQUEST["cp"];
    	$participante["oid_part"]= $_REQUEST["oid_part"];

    	$conexion = crearConexionBD();
		$errores = validarAltaParticipante($participante, $conexion);
        if (count($errores)>0) {
            $_SESSION["errores"]=$errores;
            Header("Location: ../formUsuario.php");
        }else{
            actualizarParticipante($conexion, $participante);
        	cerrarConexionBD($conexion);
        	Header("Location: ../perfilUsuario.php?oid_part=". $participante["oid_part"]);
        }
    }
}else {
	if ($_REQUEST["submit"]=="edit") {
		$voluntario["nombre"] = $_REQUEST["nombre"];
	    $voluntario["apellidos"] = $_REQUEST["apellidos"];
	    $voluntario["dni"] = $_REQUEST["dni"];
	    $voluntario["fechaNacimiento"] = getFechaBD($_REQUEST["fechaNacimiento"]);
	    $voluntario["email"] = $_REQUEST["email"];
	    $voluntario["telefono"] = $_REQUEST["telefono"];
	    $voluntario["direccion"] = $_REQUEST["direccion"];
	    $voluntario["localidad"] = $_REQUEST["localidad"];
	    $voluntario["provincia"] = $_REQUEST["provincia"];
	    $voluntario["cp"] = $_REQUEST["cp"];
		$voluntario["oid_vol"]= $_REQUEST["oid_vol"];

	    $conexion = crearConexionBD();
	   	if (count($errores) > 0) {
        	$_SESSION["errores"] = $errores;
        	Header("Location: ../formUsuario.php");
    	} else {
        	getActualizarVoluntario($conexion, $voluntario);
	    	cerrarConexionBD($conexion);
	    	Header("Location: ../perfilUsuario.php?oid_vol=". $voluntario["oid_vol"]);
    	}
	}
}
?>