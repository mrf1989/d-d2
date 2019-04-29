<?php

include_once("../models/gestionBD.php");
include_once("../models/gestionPatrocinadores.php");

if (isset($_GET["str"])) {
    $conexion = crearConexionBD();
    $patrocinadores = searchPatrocinadores($conexion, $_GET["str"]);
    if ($patrocinadores != NULL) {
        foreach ($patrocinadores as $patr) {
            echo "<label><input type='radio' name='cif' value='" . $patr["CIF"] . "' />";
            echo $patr["NOMBRE"] . "</label><br>";
        }
    }
    cerrarConexionBD($conexion);
    unset($_GET["str"]);
}

?>