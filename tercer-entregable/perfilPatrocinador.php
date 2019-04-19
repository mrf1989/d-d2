<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

if (!isset($_GET["cif"])) {
    Header("Location: patrocinadores.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionPatrocinadores.php");
include_once("includes/functions.php");

$conexion = crearConexionBD();
// Obtención de la información del patrocinador
$patrocinador = getPatrocinador($conexion, $_GET["cif"]);
cerrarConexionBD($conexion);


$page_title = "Patrocinador: " . $patrocinador["NOMBRE"];
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>     
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $patrocinador["NOMBRE"]; ?></h1>
                        <form action="controllers/controlPatrocinadores.php" method="POST">
                            <input type="hidden" name="cif" value="<?php echo $patrocinador["CIF"] ?>">
                            <a class="btn primary" href="nuevoPatrocinador.php?edit=true&cif=<?php echo $patrocinador["CIF"]; ?>">Editar</a>
                            <button class="btn cancel" type="submit" name="submit" value="delete">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-tab-12">
                    <div class="module-title">
                        <h2>Datos del patrocinador</h2>
                    </div>
                    <table class="tab vertical">
                        <tr>
                            <th>CIF</th>
                            <td><?php echo $patrocinador["CIF"]; ?></td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <td><?php echo $patrocinador["TIPO"]; ?></td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td><?php echo $patrocinador["DIRECCION"]; ?></td>
                        </tr>
                        <tr>
                            <th>Código postal</th>
                            <td><?php echo $patrocinador["CODIGOPOSTAL"]; ?></td>
                        </tr>
                        <tr>
                            <th>Localidad</th>
                            <td><?php echo $patrocinador["LOCALIDAD"]; ?></td>
                        </tr>
                        <tr>
                            <th>Provincia</th>
                            <td><?php echo $patrocinador["PROVINCIA"]; ?></td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td><?php echo $patrocinador["TELEFONO"]; ?></td>
                        </tr>
                    <?php if (isset($patrocinador["EMAIL"])) { ?>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $patrocinador["EMAIL"]; ?></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </div> <!--end module-->
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>