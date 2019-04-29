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
elseif ($_REQUEST["submit"]=="insert") {
	$nuevoVoluntario["nombre"] = $_REQUEST["nombre"];
    $nuevoVoluntario["apellidos"] = $_REQUEST["apellidos"];
    $nuevoVoluntario["dni"] = $_REQUEST["dni"];
    $nuevoVoluntario["fechaNacimiento"] = getFechaBD($_REQUEST["fechaNacimiento"]);
    $nuevoVoluntario["email"] = $_REQUEST["email"];
    $nuevoVoluntario["telefono"] = $_REQUEST["telefono"];
    $nuevoVoluntario["direccion"] = $_REQUEST["direccion"];
    $nuevoVoluntario["localidad"] = $_REQUEST["localidad"];
    $nuevoVoluntario["provincia"] = $_REQUEST["provincia"];
    $nuevoVoluntario["cp"] = $_REQUEST["cp"];

    $conexion = crearConexionBD();
    $errores = validarAltaVoluntario($nuevoVoluntario);
    if (count($errores) > 0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../nuevoVoluntario.php");
    } else {
        getInsertarVoluntario($conexion, $nuevoVoluntario);
        cerrarConexionBD($conexion);
        Header("Location: ../voluntarios.php");
    }
    
}
elseif ($_REQUEST["submit"]=="edit") {
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

    $conexion = crearConexionBD();
    $errores = validarAltaVoluntario($voluntario);
    if (count($errores) > 0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../nuevoVoluntario.php?edit=true&oid_vol=" . $_REQUEST["oid_vol"]);
    } else {
        getActualizarVoluntario($conexion, $voluntario);
        cerrarConexionBD($conexion);
        Header("Location: ../perfilVoluntario.php?oid_vol=" . $_REQUEST["oid_vol"]);
    }
}
?>