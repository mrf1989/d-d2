<?php
session_start();

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionIntereses.php");

if (isset($_GET["estado"])) {
    $interes["dni"] = $_SESSION["login"];
    $interes["oid_act"] = $_GET["oid_act"];
    $interes["estado"] = $_GET["estado"];
    $conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
        $resultado = actualizarInteresPart($conexion, $interes);
    } else {
        $resultado = actualizarInteresvOL($conexion, $interes);
    }
    unset($interes);
    cerrarConexionBD($conexion);
    if ($resultado) {
        $_SESSION["success"] = "Cambios guardados";
        unset($resultado);
        Header("Location: ../formIntereses.php");
    } else {
        $_SESSION["excepcion"] = "No se ha actualizado correctamente el estado de interés en la actividad.";
        Header("../excepcion.php");
    }
} else {
    Header("Location: ../index.php");
}