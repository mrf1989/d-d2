<?php
session_start();

if (!$_SESSION["admin"]) {
	header("Location: index.php");
}
require_once("models/gestionBD.php");
require_once("models/gestionVoluntarios.php");
require_once("includes/functions.php");

if (isset($_GET["edit"]) && isset($_GET["oid_vol"])) {
    $conexion = crearConexionBD();
    $voluntario = getVoluntario($conexion, $_REQUEST["oid_vol"]);
    cerrarConexionBD($conexion);
}else{
$voluntario["NOMBRE"]="";
$voluntario["APELLIDOS"]="";
$voluntario["DNI"]="";
$voluntario["FECHANACIMIENTO"]="";
$voluntario["EMAIL"]="";
$voluntario["TELEFONO"]="";
$voluntario["DIRECCION"]="";
$voluntario["LOCALIDAD"]="";
$voluntario["PROVINCIA"]="";
$voluntario["CODIGOPOSTAL"]="";
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title="Nuevo voluntario";
include_once("includes/head.php");
?>
<body>
	<?php include_once("includes/header.php")?>
	<main class="container">
		<div class="content">
			<div class="content__module">
				<div class="module-title">
					<h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> voluntario</h1>
				</div>
				<div class="form">
					<fieldset>
						<legend>Datos del voluntario</legend>
						<form action="controllers/controlVoluntarios.php" method="POST">
                            <input type="hidden" name="oid_vol" value="<?php echo $voluntario["OID_VOL"] ?>">
                            <div class="form-row">
                                <input type="text" name="nombre" value="<?php echo $voluntario["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" />
                                <input type="text" name="apellidos" value="<?php echo $voluntario["APELLIDOS"] ?>" placeholder="Apellidos" />
                                <input type="text" name="dni" value="<?php echo $voluntario["DNI"] ?>" placeholder="DNI" <?php if (isset($_GET["edit"])) echo "readonly" ?>>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha nacimiento:</div>
                                <input type="date" name="fechaNacimiento" value="<?php if (isset($_GET["edit"])) echo getFechaForm($voluntario["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" />
                                <?php if ($voluntario["EMAIL"] != "") { ?>
                                    <input type="email" name="email" value="<?php echo $voluntario["EMAIL"] ?>" placeholder="Email" />
                                <?php } else { ?>
                                    <input type="email" name="email" placeholder="Email" />
                                <?php } ?>
                                <input type="text" name="telefono" value="<?php echo $voluntario["TELEFONO"] ?>" placeholder="Teléfono" />
							</div>
							<div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $voluntario["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $voluntario["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $voluntario["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input type="text" name="cp" value="<?php echo $voluntario["CODIGOPOSTAL"] ?>" placeholder="Código postal" />
                            </div>
                            <div class="form-row right">
                            <?php if (!isset($_GET["edit"])) { ?>
                                <button type="reset" class="btn cancel">Reset</button>
                            <?php } ?>
                                <button type="submit" class="btn primary" name="submit" value="<?php echo isset($_GET["edit"]) ? "edit" : "insert";?>">Guardar</button>
                            </div>
						</form>
					</fieldset>
				</div>
			</div>
		</div>
	</main>
	<?php include_once("includes/footer.php"); ?>
</body>
</html>