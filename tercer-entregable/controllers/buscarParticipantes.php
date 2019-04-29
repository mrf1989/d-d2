<?php

include_once("../models/gestionBD.php");
include_once("../models/gestionParticipantes.php");

if (isset($_GET["str"])) {
    $conexion = crearConexionBD();
    $participantes = searchParticipantes($conexion, $_GET["str"]);
    if ($participantes != NULL) {
        foreach ($participantes as $part) {
            echo "<label><input type='radio' name='dni' value='" . $part["DNI"] . "' />";
            echo $part["NOMBRE"] . " " . $part["APELLIDOS"] . "</label><br>";
        }
    }
    cerrarConexionBD($conexion);
    unset($_GET["str"]);
}

?>