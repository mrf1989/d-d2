<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionProyectos.php");
include_once("../includes/functions.php");

if ($_REQUEST["submit"] == "insert") {
    $nuevoProyecto["coordinador"] = $_SESSION["login"];
    $nuevoProyecto["nombre"] = $_REQUEST["nombre"];
    $nuevoProyecto["ubicacion"] = $_REQUEST["ubicacion"];
    if ($_REQUEST["tipoProj"] == "evento") {
        $nuevoProyecto["esevento"] = 1;
        $nuevoProyecto["esprogdep"] = 0;
    } else {
        $nuevoProyecto["esevento"] = 0;
        $nuevoProyecto["esprogdep"] = 1;
    }

    $conexion = crearConexionBD();
    $errores= validarAltaProyecto($nuevoProyecto);
    if (count($errores)>0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../formProyecto.php");
    }else{
        insertarProyecto($conexion, $nuevoProyecto);
        cerrarConexionBD($conexion);
        Header("Location: ../proyectos.php");
    }
} else if ($_REQUEST["submit"] == 'delete') {
    $conexion = crearConexionBD();
    eliminarProyecto($conexion, $_REQUEST["oid_proj"]);
    cerrarConexionBD($conexion);
    Header("Location: ../proyectos.php");
} else if ($_REQUEST["submit"] == 'edit') {
    $proyecto["oid_proj"] = $_REQUEST["oid_proj"];
    $proyecto["nombre"] = $_REQUEST["nombre"];
    $proyecto["ubicacion"] = $_REQUEST["ubicacion"];
    if ($_REQUEST["tipoProj"] == "evento") {
        $proyecto["esevento"] = 1;
        $proyecto["esprogdep"] = 0;
    } else {
        $proyecto["esevento"] = 0;
        $proyecto["esprogdep"] = 1;
    }

    $conexion = crearConexionBD();
    $errores= validarAltaProyecto($proyecto);
    if (count($errores)>0) {
        $_SESSION["errores"]=$errores;
        Header("Location: ../formProyecto.php?edit=true&oid_proj=" . $_REQUEST["oid_proj"]);
    }else{
        actualizarProyecto($conexion, $proyecto);
        cerrarConexionBD($conexion);
        Header("Location: ../perfilProyecto.php?oid_proj=" . $proyecto["oid_proj"]);
    }
    
}
