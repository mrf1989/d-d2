<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

if (!isset($_GET["oid_part"])) {
    Header("Location: participantes.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionParticipantes.php");
include_once("models/gestionTutores.php");
include_once("includes/functions.php");

$conexion = crearConexionBD();
// Obtención de la información personal del participante
$participante = getParticipante($conexion, $_GET["oid_part"]);
// Obtención de la información personal del tutor legal
$tutor = getTutor($conexion, $participante["OID_TUT"]);
// Obtención de los informes médicos del participante
$informes = getInformesMedicos($conexion, $participante["OID_PART"]);
// Obtención del historial de participación del participante
$actividades = getHistorialParticipacion($conexion, $participante["OID_PART"]);
// Obtención de los recibos del participante
$recibos = getRecibos($conexion, $participante["OID_PART"]);
cerrarConexionBD($conexion);

$page_title = "Participante: " . $participante["NOMBRE"] . " " . $participante["APELLIDOS"];
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>     
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $participante["NOMBRE"] . " " . $participante["APELLIDOS"]; ?></h1>
                        <form action="controllers/controlParticipantes.php" method="POST">
                            <input type="hidden" name="dni" value="<?php echo $participante["DNI"] ?>">
                            <a class="btn primary" href="nuevoParticipante.php?edit=true&oid_part=<?php echo $participante["OID_PART"]; ?>">Editar</a>
                            <button class="btn cancel" type="submit" name="submit" value="delete">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Datos personales</h2>
                    </div>
                    <div class="content-tab">
                        <table class="tab vertical">
                            <tr>
                                <th>DNI</th>
                                <td><?php echo $participante["DNI"]; ?></td>
                            </tr>
                            <tr>
                                <th>Fecha nacimiento</th>
                                <td><?php echo $participante["FECHANACIMIENTO"] ?></td>
                            </tr>
                            <tr>
                                <th>Discapacidad</th>
                                <?php
                                $gDiscapacidad = (0 + str_replace(",", ".", $participante["GRADODISCAPACIDAD"]));
                                ?>
                                <td><?php echo ($gDiscapacidad * 100) . "%"; ?></td>
                            </tr>
                            <tr>
                                <th>Dirección</th>
                                <td><?php echo $participante["DIRECCION"]; ?></td>
                            </tr>
                            <tr>
                                <th>Código postal</th>
                                <td><?php echo $participante["CODIGOPOSTAL"]; ?></td>
                            </tr>
                            <tr>
                                <th>Localidad</th>
                                <td><?php echo $participante["LOCALIDAD"]; ?></td>
                            </tr>
                            <tr>
                                <th>Provincia</th>
                                <td><?php echo $participante["PROVINCIA"]; ?></td>
                            </tr>
                            <tr>
                                <th>Teléfono</th>
                                <td><?php echo $participante["TELEFONO"]; ?></td>
                            </tr>
                        <?php if (isset($participante["EMAIL"])) { ?>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $participante["EMAIL"]; ?></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Tutor legal</h2>
                    </div>
                    <div class="content-tab">
                        <table class="tab vertical">
                            <tr>
                                <th>DNI</th>
                                <td><?php echo $tutor["DNI"]; ?></td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td><?php echo $tutor["NOMBRE"] . " " . $tutor["APELLIDOS"]; ?></td>
                            </tr>
                            <tr>
                                <th>Teléfono</th>
                                <td><?php echo $tutor["TELEFONO"]; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $tutor["EMAIL"]; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h2>Informes médicos</h2>
                        <a class="btn primary" href="nuevoInforme.php?oid_part=<?php echo $participante["OID_PART"]; ?>">Nuevo informe</a>
                    </div>
                <?php if (count($informes) > 0) { ?>
                    <div class="content-tab">
                        <table class="tab horizontal">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                            </tr>
                        <?php foreach ($informes as $inf) { ?>
                            <tr>
                                <form>
                                    <td><?php echo $inf["OID_INF"] ?></td>
                                    <td><?php echo $inf["FECHA"] ?></td>
                                    <td><?php echo $inf["DESCRIPCION"] ?></td>
                                </form>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p>Aún no hay informes médicos registrados en el sistema.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h2>Historial de participación</h2>
                    </div>
                <?php if (count($actividades) > 0) { ?>
                    <div class="content-tab">
                        <table class="tab horizontal">
                            <tr>
                                <th>Actividad</th>
                                <th>Localización</th>
                                <th>Fecha</th>
                            </tr>
                        <?php
                        foreach ($actividades as $act) { ?>
                            <tr>
                                <form>
                                    <td><a href="perfilActividad.php?oid_act=<?php echo $act["OID_ACT"] ?>"><?php echo $act["ACT_NOMBRE"] ?></a></td>
                                    <td><?php echo $act["PROJ_LUGAR"] ?></td>
                                    <td><?php echo $act["ACT_FECHAINICIO"] ?></td>
                                </form>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p><?php echo $participante["NOMBRE"]; ?> no ha participado aún en actividades.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h2>Recibos</h2>
                    </div>
                <?php if (count($recibos) > 0) { ?>
                    <div class="content-tab">
                        <table class="tab horizontal">
                            <tr>
                                <th>Estado</th>
                                <th>Emisión</th>
                                <th>Vencimiento</th>
                                <th>Importe</th>
                                <th></th>
                            </tr>
                        <?php
                        foreach ($recibos as $rec) { ?>
                            <tr>
                                <td><?php echo $rec["ESTADO"] ?></td>
                                <td><?php echo $rec["FECHAEMISION"] ?></td>
                                <td><?php echo $rec["FECHAVENCIMIENTO"] ?></td>
                                <td><?php echo $rec["IMPORTE"] . "€"?></td>
                                <td class="acciones"><a href="actualizarRecibo.php?oid_part=<?php echo $_GET["oid_part"] ?>&oid_rec=<?php echo $rec["OID_REC"] ?>" class="btn secondary">Editar</a></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p>Aún no hay recibos registrados en el sistema.</p>
                <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>