<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionProyectos.php");
include_once("../models/gestionActividades.php");
include_once("../includes/functions.php");

if ($_REQUEST["submit"] == "insert") {
    $nuevaActividad["nombre"] = $_REQUEST["nombre"];
    $nuevaActividad["objetivo"] = $_REQUEST["objetivo"];
    $nuevaActividad["fechainicio"] = getFechaBD($_REQUEST["fechainicio"]);
    $nuevaActividad["fechafin"] = getFechaBD($_REQUEST["fechafin"]);
    $nuevaActividad["numeroplazas"] = $_REQUEST["numeroplazas"];
    $nuevaActividad["tipo"] = $_REQUEST["tipo"];
    $nuevaActividad["costetotal"] = $_REQUEST["costetotal"];
    $nuevaActividad["oid_proj"] = $_REQUEST["oid_proj"];
    
    $conexion = crearConexionBD();
    $errores= validarAltaActividad($nuevaActividad);
    if (count($errores)>0) {
        $_SESSION["errores"] = $errores;
        Header("Location: ../formActividad.php?oid_proj=". $nuevaActividad["oid_proj"]);
    }else{
        insertarActividad($conexion, $nuevaActividad);
        cerrarConexionBD($conexion);
        Header("Location: ../perfilProyecto.php?oid_proj=" . $nuevaActividad["oid_proj"]);
    }

} else if ($_REQUEST["submit"] == 'delete') {
    $conexion = crearConexionBD();
    eliminarActividad($conexion, $_REQUEST["oid_act"]);
    cerrarConexionBD($conexion);
    Header("Location: ../perfilProyecto.php?oid_proj=" . $_REQUEST["oid_proj"]);

} else if ($_REQUEST["submit"] == 'edit') {
    $actividad["oid_act"] = $_REQUEST["oid_act"];
    $actividad["nombre"] = $_REQUEST["nombre"];
    $actividad["objetivo"] = $_REQUEST["objetivo"];
    $actividad["fechainicio"] = getFechaBD($_REQUEST["fechainicio"]);
    $actividad["fechafin"] = getFechaBD($_REQUEST["fechafin"]);
    $actividad["numeroplazas"] = $_REQUEST["numeroplazas"];
    $actividad["tipo"] = $_REQUEST["tipo"];
    $actividad["costetotal"] = $_REQUEST["costetotal"];

    $conexion = crearConexionBD();
    $errores= validarAltaActividad($actividad);
    if (count($errores)>0) {
        $_SESSION["errores"]=$errores;
        Header("Location: ../formActividad.php?edit=true&oid_act=" . $_REQUEST["oid_act"]);
    }else{
        $accionOK = actualizarActividad($conexion, $actividad);
    cerrarConexionBD($conexion);
    if ($accionOK) {
        Header("Location: ../perfilActividad.php?oid_act=" . $actividad["oid_act"]);
    } else {
        $_SESSION["excepcion"] = "No se ha podido actualizar correctamente.";
        Header("Location: ../excepcion.php");
        }
    }
}

?>