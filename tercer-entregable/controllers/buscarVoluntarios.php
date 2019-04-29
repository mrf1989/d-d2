<?php

include_once("../models/gestionBD.php");
include_once("../models/gestionVoluntarios.php");

if (isset($_GET["str"])) {
    $conexion = crearConexionBD();
    $voluntarios = searchVoluntarios($conexion, $_GET["str"]);
    if ($voluntarios != NULL) {
        foreach ($voluntarios as $vol) {
            echo "<label><input type='radio' name='dni' value='" . $vol["DNI"] . "' />";
            echo $vol["NOMBRE"] . " " . $vol["APELLIDOS"] . "</label><br>";
        }
    }
    cerrarConexionBD($conexion);
    unset($_GET["str"]);
}

?>