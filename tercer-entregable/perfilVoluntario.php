<?php
session_start();

require_once("models/gestionVoluntarios.php");
require_once("models/gestionBD.php");

if(!$_SESSION["admin"]){
	header("Location: index.php");
}
if (!isset($_GET["oid_vol"])) {
	header("Location:voluntario.php");
}
$conexion= crearConexionBD();
//para llegar al perfil del voluntario hemos pasado el oid como parámetro en la petición 
//Obtención de la información personal de los voluntarios
$voluntario= getVoluntario($conexion, $_GET["oid_vol"]);
//Obtención de la información del historial de colaboración, actividades en las que ha participado
$actividades= getHistorialColaboracion($conexion, $voluntario["OID_VOL"]);
cerrarConexionBD($conexion);

$page_title= "Voluntarios". $voluntario["NOMBRE"]. " " . $voluntario["APELLIDOS"];
include_once("includes/head.php");
?>
<body>
	<?php include_once("includes/header.php");?>
	<main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1><?php echo $voluntario["NOMBRE"] . " " . $voluntario["APELLIDOS"]; ?></h1>
                        <form>
                            <input type="hidden" name="dni" value="<?php echo $voluntario["DNI"] ?>">
                            <a class="btn primary" href="nuevoVoluntario.php?edit=true&oid_vol=<?php echo $voluntario["OID_VOL"]; ?>">Editar</a>
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
                    <table class="tab vertical">
                        <tr>
                            <th>DNI</th>
                            <td><?php echo $voluntario["DNI"]; ?></td>
                        </tr>
                        <tr>
                            <th>Fecha nacimiento</th>
                            <td><?php echo $voluntario["FECHANACIMIENTO"] ?></td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td><?php echo $voluntario["DIRECCION"]; ?></td>
                        </tr>
                        <tr>
                            <th>Código postal</th>
                            <td><?php echo $voluntario["CODIGOPOSTAL"]; ?></td>
                        </tr>
                        <tr>
                            <th>Localidad</th>
                            <td><?php echo $voluntario["LOCALIDAD"]; ?></td>
                        </tr>
                        <tr>
                            <th>Provincia</th>
                            <td><?php echo $voluntario["PROVINCIA"]; ?></td>
                        </tr>
                        <tr>
                            <th>Teléfono</th>
                            <td><?php echo $voluntario["TELEFONO"]; ?></td>
                        </tr>
                    <?php if (isset($voluntario["EMAIL"])) { ?>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $voluntario["EMAIL"]; ?></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
                <div class="col-6 col-tab-12">
                	<div class="module-title">
                		<h2>Historial de colaboración</h2>
                	</div>
                	<?php if (count($actividades) > 0) { ?>
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
                                <td><a href="#"><?php echo $act["ACT_NOMBRE"] ?></a></td>
                                <td><?php echo $act["PROJ_LUGAR"] ?></td>
                                <td><?php echo $act["ACT_FECHAINICIO"] ?></td>
                            </form>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <p><?php echo $voluntario["NOMBRE"]; ?> no ha participado aún en actividades.</p>
                <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>