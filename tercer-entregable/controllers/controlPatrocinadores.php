<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionPatrocinadores.php");
include_once("../includes/functions.php");

if ($_REQUEST["submit"] == "insert") {
    $nuevoPatrocinador["nombre"] = $_REQUEST["nombre"];
    $nuevoPatrocinador["cif"] = $_REQUEST["cif"];
    $nuevoPatrocinador["email"] = $_REQUEST["email"];
    $nuevoPatrocinador["telefono"] = $_REQUEST["telefono"];
    $nuevoPatrocinador["direccion"] = $_REQUEST["direccion"];
    $nuevoPatrocinador["localidad"] = $_REQUEST["localidad"];
    $nuevoPatrocinador["provincia"] = $_REQUEST["provincia"];
    $nuevoPatrocinador["cp"] = $_REQUEST["cp"];

    $conexion = crearConexionBD();
    $errores= validarAltaPatrocinador($nuevoPatrocinador);
    if (count($errores) > 0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../nuevoPatrocinador.php");
    }else{
        insertarPatrocinador($conexion, $nuevoPatrocinador);
        cerrarConexionBD($conexion);
        Header("Location: ../patrocinadores.php");
    }
} else if ($_REQUEST["submit"] == 'delete') {
    $conexion = crearConexionBD();
    eliminarPatrocinador($conexion, $_REQUEST["cif"]);
    cerrarConexionBD($conexion);
    Header("Location: ../patrocinadores.php");
} else if ($_REQUEST["submit"] == 'edit') {
    $patrocinador["nombre"] = $_REQUEST["nombre"];
    $patrocinador["cif"] = $_REQUEST["cif"];
    $patrocinador["email"] = $_REQUEST["email"];
    $patrocinador["telefono"] = $_REQUEST["telefono"];
    $patrocinador["direccion"] = $_REQUEST["direccion"];
    $patrocinador["localidad"] = $_REQUEST["localidad"];
    $patrocinador["provincia"] = $_REQUEST["provincia"];
    $patrocinador["cp"] = $_REQUEST["cp"];

    $conexion = crearConexionBD();
    $errores= validarAltaPatrocinador($patrocinador);
    if (count($errores) > 0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../nuevoPatrocinador.php");
    }else{
        actualizarPatrocinador($conexion, $patrocinador);
        cerrarConexionBD($conexion);
        Header("Location: ../perfilPatrocinador.php?cif=" . $_REQUEST["cif"]);
    }
}
?>