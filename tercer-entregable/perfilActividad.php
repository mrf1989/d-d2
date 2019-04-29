<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

if (!isset($_GET["oid_act"])) {
    Header("Location: proyectos.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionActividades.php");
include_once("includes/functions.php");

$conexion = crearConexionBD();
$actividad = getActividad($conexion, $_GET["oid_act"]);
$inscripciones = getInscripciones($conexion, $_GET["oid_act"]);
$voluntarios = getColaboraciones($conexion, $_GET["oid_act"]);
$patrocinios = getPatrocinios($conexion, $_GET["oid_act"]);
cerrarConexionBD($conexion);

$page_title = "Actividad: " . $actividad["NOMBRE"];
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>     
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $actividad["NOMBRE"] ?></h1>
                        <form action="controllers/controlActividad.php" method="POST">
                            <input type="hidden" name="oid_act" value="<?php echo $actividad["OID_ACT"] ?>">
                            <a class="btn primary" href="formActividad.php?edit=true&oid_act=<?php echo $actividad["OID_ACT"]; ?>">Editar</a>
                            <button class="btn cancel" type="submit" name="submit" value="delete">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end module-->

        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <table class="tab horizontal">
                        <tr>
                            <th>Tipo</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Plazas</th>
                            <th>Inscripción</th>
                            <th>Coste total</th>
                        </tr>
                        <tr>
                            <td><?php echo $actividad["TIPO"] ?></td>
                            <td><?php echo $actividad["FECHAINICIO"] ?></td>
                            <td><?php echo $actividad["FECHAFIN"] ?></td>
                            <td><?php echo $actividad["NUMEROPLAZAS"] ?></td>
                            <td><?php echo $actividad["COSTEINSCRIPCION"] ?> €</td>
                            <td><?php echo $actividad["COSTETOTAL"] ?> €</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <h2>Objetivos de la actividad</h2>
                    <p><?php echo $actividad["OBJETIVO"] ?></p>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Inscripciones</h2>
                        <a class="btn primary" href="formInscripcion.php?oid_act=<?php echo $actividad["OID_ACT"] ?>">Nueva inscripción</a>
                    </div>
                <?php if (count($inscripciones) > 0) { ?>
                    <table class="tab horizontal">
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                        </tr>
                    <?php foreach ($inscripciones as $ins) { ?>
                        <tr>
                            <td><?php echo $ins["DNI"] ?></td>
                            <td><a href="perfilParticipante.php?oid_part=<?php echo $ins["OID_PART"] ?>"><?php echo $ins["NOMBRE"] . " " . $ins["APELLIDOS"] ?></a></td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>Aún no hay inscritos en la actividad.</p>
                <?php } ?>
                </div>
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Voluntarios</h2>
                        <a class="btn primary" href="formVoluntariado.php?oid_act=<?php echo $actividad["OID_ACT"] ?>">Añadir voluntario</a>
                    </div>
                <?php if (count($voluntarios) > 0) { ?>
                    <table class="tab horizontal">
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                        </tr>
                    <?php foreach ($voluntarios as $vol) { ?>
                        <tr>
                            <td><?php echo $vol["DNI"] ?></td>
                            <td><a href="perfilVoluntario.php?oid_vol=<?php echo $vol["OID_VOL"] ?>"><?php echo $vol["NOMBRE"] . " " . $vol["APELLIDOS"] ?></a></td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>Aún no hay voluntarios para esta actividad.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h2>Patrocinios</h2>
                        <a class="btn primary" href="formPatrocinio.php?oid_act=<?php echo $actividad["OID_ACT"] ?>">Añadir patrocinio</a>
                    </div>
                <?php if (count($patrocinios) > 0) { ?>
                    <table class="tab horizontal">
                        <tr>
                            <th>CIF</th>
                            <th>Nombre</th>
                            <th>Patrocinio</th>
                        </tr>
                    <?php foreach ($patrocinios as $fin) { ?>
                        <tr>
                            <td><?php echo $fin["CIF"] ?></td>
                            <td><a href="perfilPatrocinador.php?cif=<?php echo $fin["CIF"] ?>"><?php echo $fin["NOMBRE"] ?></a></td>
                            <td><?php echo $fin["CANTIDAD"] ?> €</td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>Aún no hay patrocinios para esta actividad.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>
