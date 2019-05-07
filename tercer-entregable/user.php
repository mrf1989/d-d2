<?php
session_start();

include_once("models/gestionBD.php");
include_once("models/gestionUsuarios.php");
include_once("models/gestionActividades.php");
include_once("models/gestionParticipantes.php");
include_once("models/gestionVoluntarios.php");

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
} else {
    $conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
        $oid_part = getOidPart($conexion, $_SESSION["login"]);
        $_SESSION["oid_part"] = $oid_part["OID_PART"];
        $inscripciones = getProximasActPart($conexion, $oid_part["OID_PART"]);
    } else {
        $oid_vol = getOidVol($conexion, $_SESSION["login"]);
        $_SESSION["oid_vol"] = $oid_vol["OID_VOL"];
        $inscripciones = getProximasActVol($conexion, $oid_vol["OID_VOL"]);
    }
    cerrarConexionBD($conexion);
}

$page_title = "Página principal";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-6 col-tab-12">
                    <div class="content__module">
                        <div class="module-title">
                            <h2>Mis inscripciones</h2>
                        </div>
                        <div class="content-tab">
                        <?php if (count($inscripciones) > 0) { ?>
                            <table class="tab horizontal">
                                <tr>
                                    <th>Actividad</th>
                                    <th>Localización</th>
                                    <th>Fecha</th>
                                </tr>
                            <?php foreach ($inscripciones as $ins) { ?>
                                <tr>
                                    <td><?php echo $ins["NOMBRE"] ?></td>
                                    <td><?php echo $ins["UBICACION"] ?></td>
                                    <td><?php echo $ins["FECHAINICIO"] ?></td>
                                </tr>
                            <?php } ?>    
                            </table>
                        <?php } else { ?>
                            <p>El usuario no está inscrito en ninguna actividad próxima.</p>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-tab-12">
                    <div class="content__module">
                        <div class="module-title">    
                            <h2>Próximas actividades</h2>
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
                                echo "<td>" . $act["NOMBRE"] . "</td>";
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
        </div>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>