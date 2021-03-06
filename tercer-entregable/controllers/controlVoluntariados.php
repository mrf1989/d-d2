<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionActividades.php");

if ($_REQUEST["submit"] == 'inscribir') {
    $colaboracion["dni"] = $_REQUEST["dni"];
    $colaboracion["oid_act"] = $_REQUEST["oid_act"];

    $conexion = crearConexionBD();
    $validaVol = validarVoluntariado($colaboracion, $conexion);
    if ($validaVol==1) {
        $errores[] = "<p>El voluntario seleccionado ya estaba inscrito</p>";
    }    
    if (count($errores)> 0) {
    	$_SESSION["errores"] = $errores;
    	Header("Location: ../formVoluntariado.php?oid_act=" . $colaboracion["oid_act"]);
    } else {
    	inscribirVoluntario($conexion, $colaboracion);
    	cerrarConexionBD($conexion);
        Header("Location: ../perfilActividad.php?oid_act=" . $colaboracion["oid_act"]);
    }
    
}


?>