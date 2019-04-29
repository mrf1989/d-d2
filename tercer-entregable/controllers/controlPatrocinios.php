<?php
session_start();

if (!$_SESSION["admin"] && !isset($_SESSION["login"])) {
    Header("Location: index.php");
}

include_once("../models/gestionBD.php");
include_once("../models/gestionActividades.php");

if ($_REQUEST["submit"]) {
    $patrocinio["cif"] = $_REQUEST["cif"];
    $patrocinio["cantidad"] = $_REQUEST["cantidad"];
    $patrocinio["oid_act"] = $_REQUEST["oid_act"];

    $conexion = crearConexionBD();
    addPatrocinio($conexion, $patrocinio);
    cerrarConexionBD($conexion);
}

Header("Location: ../perfilActividad.php?oid_act=" . $patrocinio["oid_act"]);

?>