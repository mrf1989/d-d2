<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionActividades.php");
$page_title = "Página principal";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="content">
            <div class="content__module">
                <div class="module-title">    
                    <h1>Próximas actividades</h1>
                </div>
                <div class="content-tab">
                    <table class="tab horizontal">
                        <tr>
                            <th>Actividad</th>
                            <th>Localización</th>
                            <th>Fecha</th>
                        </tr>
                <?php
                // consulta las próximas actividades
                $conexion = crearConexionBD();
                $actividades = getProximasActividades($conexion);
                cerrarConexionBD($conexion);
                foreach ($actividades as $act) {
                    $oid_act = $act["OID_ACT"];
                    echo "<tr>";
                        echo "<td><a href=\"perfilActividad.php?oid_act=$oid_act\">" . $act["NOMBRE"] . "</a></td>";
                        echo "<td>" . $act["PROJ_LUGAR"] . "</td>";
                        echo "<td>" . $act["FECHAINICIO"] . "</td>";
                    echo "</tr>";
                }
                ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>