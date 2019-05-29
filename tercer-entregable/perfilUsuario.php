<?php
session_start();

require_once("models/gestionUsuarios.php");
require_once("models/gestionParticipantes.php");
require_once("models/gestionVoluntarios.php");
require_once("models/gestionBD.php");
require_once("includes/functions.php");

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
} else {
    $conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
        if (!isset($_GET["oid_part"])) {
            Header("Location: user.php");
        }
        $oid = $_GET["oid_part"];
        // Obtención de la información personal del participante
        $usuario = getParticipante($conexion, $oid);
        // Obtención de la información personal del tutor legal
        $tutor = getTutor($conexion, $usuario["OID_TUT"]);
        // Obtención del historial de participación del participante
        $actividades = getHistorialParticipacion($conexion, $oid);
        $page_title = "Participante: " . $usuario["NOMBRE"] . " " . $usuario["APELLIDOS"];
    } else {
        if (!isset($_GET["oid_vol"])) {
            Header("Location:user.php");
        }
        $oid = $_GET["oid_vol"];
        //Obtención de la información personal de los voluntarios
        $usuario= getVoluntario($conexion, $oid);
        //Obtención de la información del historial de colaboración, actividades en las que ha participado
        $actividades= getHistorialColaboracion($conexion, $oid);
        $page_title = "Voluntario: ". $usuario["NOMBRE"]. " " . $usuario["APELLIDOS"];
    }
    cerrarConexionBD($conexion);
}

include_once("includes/head.php");

?>


<body>
    <?php include_once("includes/header.php"); ?>     
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $usuario["NOMBRE"] . " " . $usuario["APELLIDOS"]; ?></h1>
                        <form action="controllers/<?php echo $_SESSION["user"] == 2 ? "controlParticipantes.php" : "controlVoluntarios.php" ?>" method="POST">
                            <input type="hidden" name="dni" value="<?php echo $usuario["DNI"] ?>">
                            <a class="btn primary" href="formUsuario.php">Editar</a>
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
                                <td><?php echo $usuario["DNI"]; ?></td>
                            </tr>
                            <tr>
                                <th>Fecha nacimiento</th>
                                <td><?php echo $usuario["FECHANACIMIENTO"] ?></td>
                            </tr>
                            <tr>
                                <th>Dirección</th>
                                <td><?php echo $usuario["DIRECCION"]; ?></td>
                            </tr>
                            <tr>
                                <th>Código postal</th>
                                <td><?php echo $usuario["CODIGOPOSTAL"]; ?></td>
                            </tr>
                            <tr>
                                <th>Localidad</th>
                                <td><?php echo $usuario["LOCALIDAD"]; ?></td>
                            </tr>
                            <tr>
                                <th>Provincia</th>
                                <td><?php echo $usuario["PROVINCIA"]; ?></td>
                            </tr>
                            <tr>
                                <th>Teléfono</th>
                                <td><?php echo $usuario["TELEFONO"]; ?></td>
                            </tr>
                        <?php if (isset($usuario["EMAIL"])) { ?>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $usuario["EMAIL"]; ?></td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Historial de <?php echo $_SESSION["user"] == 2 ? "participación" : "colaboración" ?></h2>
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
                                    <td><?php echo $act["ACT_NOMBRE"] ?></td>
                                    <td><?php echo $act["PROJ_LUGAR"] ?></td>
                                    <td><?php echo $act["ACT_FECHAINICIO"] ?></td>
                                </form>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p><?php echo $usuario["NOMBRE"]; ?> no ha participado aún en actividades.</p>
                <?php } ?>
                </div>
            </div>
        </div> <!--end module-->
    <?php if ($_SESSION["user"] == 2) { ?>
        <div class="content__module">
            <div class="row">
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
    <?php } ?>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>