<?php
session_start();

include_once("models/gestionBD.php");
include_once("models/gestionUsuarios.php");
include_once("models/gestionActividades.php");
include_once("models/gestionParticipantes.php");
include_once("models/gestionVoluntarios.php");
include_once("models/gestionIntereses.php");

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
} else {
    $conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
        $actividades = getInteresesPart($conexion, $_SESSION["oid_part"]);
    } else {
        $actividades = getInteresesVol($conexion, $_SESSION["oid_vol"]);
    }
    cerrarConexionBD($conexion);
}

$page_title = "Próximas actividades";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="content__module">
                        <div class="module-title">
                            <h2>Próximas actividades</h2>
                        </div>
                    <?php if (isset($_SESSION["success"])) { ?>
                        <p><?php echo $_SESSION["success"] ?></p>
                    <?php unset($_SESSION["success"]); } ?>
                    </div>
                    <!-- tabla -->
                    <div class="content-tab">
                    <?php if (count($actividades) > 0) { ?>
                        <table class="tab horizontal">
                            <tr>
                                <th>Actividad</th>
                                <th>Localización</th>
                                <th>Fecha</th>
                                <th>Me interesa</th>
                            </tr>
                        <?php foreach ($actividades as $act) { ?>
                            <tr>
                                <td><?php echo $act["NOMBRE"] ?></td>
                                <td><?php echo $act["UBICACION"] ?></td>
                                <td><?php echo $act["FECHAINICIO"] ?></td>
                                <td>
                                    <form action="controllers/controlIntereses.php" method="get" id="<?php echo $act["OID_ACT"] ?>">
                                        <input type="hidden" name="oid_act" value="<?php echo $act["OID_ACT"] ?>">
                                        <input type="hidden" name="estado_hidden" value="0" <?php echo ($act["ESTADO"] == 0) ? "disabled" : "" ?>>
                                        <input type="checkbox" onchange="$('#<?php echo $act['OID_ACT'] ?>').submit()" name="estado" value="<?php echo ($act["ESTADO"] == 1) ? 0 : 1 ?>" <?php echo ($act["ESTADO"] == 1) ? "checked" : "" ?>>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    <?php } else { ?>
                        <p>No hay actividades próximamente para mostrar.</p>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>