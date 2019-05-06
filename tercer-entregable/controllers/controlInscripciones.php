<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionActividades.php");


if ($_REQUEST["submit"] == 'inscribir') {
    $inscripcion["dni"] = $_REQUEST["dni"];
    $inscripcion["oid_act"] = $_REQUEST["oid_act"];

    $conexion = crearConexionBD();
    $validaIns = validarInscripcion($inscripcion, $conexion);
    if ($validaIns==1) {
        $errores[] = "<p>El participante seleccionado ya estaba inscrito</p>";
    } 
    if (count($errores)> 0) {
    	$_SESSION["errores"] = $errores;
    	Header("Location: ../formInscripcion.php?oid_act=" . $inscripcion["oid_act"]);
    } else {
    	inscribirParticipante($conexion, $inscripcion);
    	cerrarConexionBD($conexion);
        Header("Location: ../perfilActividad.php?oid_act=" . $inscripcion["oid_act"]);
    }
    
}

?>