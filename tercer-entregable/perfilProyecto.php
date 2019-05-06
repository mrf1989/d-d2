<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

if (!isset($_GET["oid_proj"])) {
    Header("Location: proyectos.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionProyectos.php");
include_once("models/gestionActividades.php");
include_once("includes/functions.php");

$conexion = crearConexionBD();
// Obtención de la información del proyecto
$proyecto = getProyecto($conexion, $_GET["oid_proj"]);
// Obtención de las actividades del proyecto
$actividades = getActividades($conexion, $_GET["oid_proj"]);
cerrarConexionBD($conexion);

$page_title = "Proyecto: " . $proyecto["NOMBRE"];
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>     
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $proyecto["NOMBRE"] . " - " . $proyecto["UBICACION"]; ?></h1>
                        <form action="controllers/controlProyectos.php" method="POST">
                            <input type="hidden" name="oid_proj" value="<?php echo $proyecto["OID_PROJ"] ?>">
                            <a class="btn primary" href="formProyecto.php?edit=true&oid_proj=<?php echo $proyecto["OID_PROJ"]; ?>">Editar</a>
                            <button class="btn cancel" type="submit" name="submit" value="delete">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h2>Actividades</h2>
                        <a class="btn primary" href="formActividad.php?oid_proj=<?php echo $proyecto["OID_PROJ"]; ?>">Nueva actividad</a>
                    </div>
                <?php if (count($actividades) > 0) { ?>
                    <div class="content-tab">
                        <table class="tab horizontal">
                            <tr>
                                <th>Actividad</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Plazas</th>
                                <th>Coste total</th>
                                <th>Coste inscripción</th>
                                <th></th>
                            </tr>
                        <?php foreach ($actividades as $act) { ?>
                            <tr>
                                <form action="controllers/controlActividad.php" method="POST">
                                    <input type="hidden" name="oid_proj" value="<?php echo $proyecto["OID_PROJ"] ?>">
                                    <input type="hidden" name="oid_act" value="<?php echo $act["OID_ACT"] ?>">
                                    <td><a href="perfilActividad.php?oid_act=<?php echo $act["OID_ACT"] ?>"><?php echo $act["NOMBRE"] ?></a></td>
                                    <td><?php echo $act["FECHAINICIO"] ?></td>
                                    <td><?php echo $act["FECHAFIN"] ?></td>
                                    <td><?php echo $act["NUMEROPLAZAS"] ?></td>
                                    <td><?php echo $act["COSTETOTAL"] ?> €</td>
                                    <td><?php echo $act["COSTEINSCRIPCION"] ?> €</td>
                                    <td class="acciones">
                                        <a href="formActividad.php?edit=true&oid_act=<?php echo $act["OID_ACT"]; ?>" class="btn secondary">Editar</a>
                                        <button class="btn secondary" type="submit" name="submit" value="delete">Borrar</button>
                                    </td>
                                </form>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p>Aún no hay actividades registradas en el sistema para este proyecto.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>