<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionActividades.php");

if ($_REQUEST["submit"]) {
    $inscripcion["dni"] = $_REQUEST["dni"];
    $inscripcion["oid_act"] = $_REQUEST["oid_act"];

    $conexion = crearConexionBD();
    inscribirParticipante($conexion, $inscripcion);
    cerrarConexionBD($conexion);
}

Header("Location: ../perfilActividad.php?oid_act=" . $inscripcion["oid_act"]);

?>