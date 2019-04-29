<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionParticipantes.php");
include_once("../includes/functions.php");

if ($_REQUEST["submit"] == "insert") {
    $nuevoParticipante["nombre"] = $_REQUEST["nombre"];
    $nuevoParticipante["apellidos"] = $_REQUEST["apellidos"];
    $nuevoParticipante["dni"] = $_REQUEST["dni"];
    $nuevoParticipante["fechaNacimiento"] = getFechaBD($_REQUEST["fechaNacimiento"]);
    $nuevoParticipante["discapacidad"] = $_REQUEST["discapacidad"];
    $nuevoParticipante["email"] = $_REQUEST["email"];
    $nuevoParticipante["telefono"] = $_REQUEST["telefono"];
    $nuevoParticipante["direccion"] = $_REQUEST["direccion"];
    $nuevoParticipante["localidad"] = $_REQUEST["localidad"];
    $nuevoParticipante["provincia"] = $_REQUEST["provincia"];
    $nuevoParticipante["cp"] = $_REQUEST["cp"];
    $nuevoParticipante["tutor"] = $_REQUEST["tutor"];

    $conexion = crearConexionBD();
    $errores= validarAltaParticipante($nuevoParticipante);
    if (count($errores)>0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../nuevoParticipante.php");
    }else{
        insertarParticipante($conexion, $nuevoParticipante);
        cerrarConexionBD($conexion);
        Header("Location: ../participantes.php");
    }
} else if ($_REQUEST["submit"] == 'delete') {
    $conexion = crearConexionBD();
    eliminarParticipante($conexion, $_REQUEST["dni"]);
    cerrarConexionBD($conexion);
    Header("Location: ../participantes.php");
} else if ($_REQUEST["submit"] == 'edit') {
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

    $conexion = crearConexionBD();
    $errores= validarAltaParticipante($participante);
    if (count($errores)>0) {
        $_SESSION["errores"]=$errores;
        Header("Location: ../nuevoParticipante.php?edit=true&oid_part=" . $_REQUEST["oid_part"]);
    }else{
        actualizarParticipante($conexion, $participante);
        cerrarConexionBD($conexion);
        Header("Location: ../perfilParticipante.php?oid_part=" . $_REQUEST["oid_part"]);
    }
} else if ($_REQUEST["submit"] == 'informe') {
    $inf["oid_part"] = $_REQUEST["oid_part"];
    $inf["descripcion"] = $_REQUEST["descripcion"];

    $conexion = crearConexionBD();
    insertarInforme($conexion, $inf);
    cerrarConexionBD($conexion);
    Header("Location: ../perfilParticipante.php?oid_part=" . $inf["oid_part"]);
} else if ($_REQUEST["submit"] == 'recibo') {
    $rec["oid_rec"] = $_REQUEST["oid_rec"];
    $rec["vencimiento"] = $_REQUEST["vencimiento"];
    $rec["importe"] = $_REQUEST["importe"];
    $rec["estado"] = $_REQUEST["estado"];

    $conexion = crearConexionBD();
    actualizarRecibo($conexion, $rec);
    cerrarConexionBD($conexion);
    Header("Location: ../perfilParticipante.php?oid_part=" . $_REQUEST["oid_part"]);
}
   
/*
$errores = validarAltaParticipante($nuevoParticipante);

if (count($errores) > 0) {
    $_SESSION["errores"] = $errores;
    Header("Location: nuevoParticipante.php");
} else {
    // todo OK, accion de inserción
}
*/
?>