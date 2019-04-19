<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionTutores.php");
include_once("../includes/functions.php");

if ($_REQUEST["submit"] == "insert") {
    $nuevoTutor["nombre"] = $_REQUEST["nombre"];
    $nuevoTutor["apellidos"] = $_REQUEST["apellidos"];
    $nuevoTutor["dni"] = $_REQUEST["dni"];
    $nuevoTutor["fechaNacimiento"] = getFechaBD($_REQUEST["fechaNacimiento"]);
    $nuevoTutor["email"] = $_REQUEST["email"];
    $nuevoTutor["telefono"] = $_REQUEST["telefono"];
    $nuevoTutor["direccion"] = $_REQUEST["direccion"];
    $nuevoTutor["localidad"] = $_REQUEST["localidad"];
    $nuevoTutor["provincia"] = $_REQUEST["provincia"];
    $nuevoTutor["cp"] = $_REQUEST["cp"];

    $conexion = crearConexionBD();
    insertarTutor($conexion, $nuevoTutor);
    cerrarConexionBD($conexion);
    Header("Location: ../tutores.php");
} else if ($_REQUEST["submit"] == 'delete') {
    $conexion = crearConexionBD();
    eliminarTutor($conexion, $_REQUEST["dni"]);
    cerrarConexionBD($conexion);
    Header("Location: ../tutores.php");
}

/*
$errores = validarAltaParticipante($nuevoTutor);

if (count($errores) > 0) {
    $_SESSION["errores"] = $errores;
    Header("Location: nuevoParticipante.php");
} else {
    // todo OK, accion de inserción
}
*/
?>