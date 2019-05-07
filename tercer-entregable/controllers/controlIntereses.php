<?php
session_start();

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionIntereses.php");

if (isset($_GET["oid_act"])) {
    $interes["dni"] = $_SESSION["login"];
    $interes["oid_act"] = $_GET["oid_act"];
    if (isset($_GET["estado"])) {
        $interes["estado"] = $_GET["estado"];
    } else {
        $interes["estado"] = $_GET["estado_hidden"];
    }
    

    $conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
        $resultado = actualizarInteresPart($conexion, $interes);
    } else {
        $resultado = actualizarInteresvOL($conexion, $interes);
    }
    cerrarConexionBD($conexion);
    if ($resultado) {
        Header("Location: ../formIntereses.php");
    } else {
        $_SESSION["excepcion"] = "No se ha actualizado correctamente el estado de interés a " . $_GET["estado"] . " en la actividad " . $_GET["oid_act"] ;
        Header("../excepcion.php");
    }
} else {
    Header("Location: ../index.php");
}