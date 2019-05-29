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
                <?php 
                    // Mostrar los erroes de validación (Si los hay)
                    if (isset($errores) && count($errores)>0) { ?>
                    <div id="div_errores" class="content__error">
                    <h4> Errores en el formulario:</h4>
                    <?php foreach($errores as $error) echo $error; ?>
                    </div>
                <?php }
                ?>
				<div class="module-title">
					<h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> voluntario</h1>
				</div>
				<div class="form">
					<fieldset>
						<legend>Datos del voluntario</legend>
						<form action="controllers/controlVoluntarios.php" method="POST">
                            <input type="hidden" name="oid_vol" value="<?php echo $voluntario["OID_VOL"] ?>">
                            <div class="form-row">
                                <input id="nombre" type="text" name="nombre" value="<?php echo $voluntario["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" required />
                                <input id="apellidos" type="text" name="apellidos" value="<?php echo $voluntario["APELLIDOS"] ?>" placeholder="Apellidos" required />
                                <input id="dni" type="text" name="dni" value="<?php echo $voluntario["DNI"] ?>" placeholder="DNI" pattern="^[0-9]{8}[A-Z]" <?php if (isset($_GET["edit"])) echo "readonly" ?> required/>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha nacimiento:</div>
                                <input id="fechaNacimiento" type="date" name="fechaNacimiento" value="<?php if (isset($_GET["edit"])) echo getFechaForm($voluntario["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" required/>
                               <?php if ($voluntario["EMAIL"] != "") { ?>
                                    <input id="email" type="email" name="email" value="<?php echo $voluntario["EMAIL"] ?>" placeholder="Email" required/>
                                <?php } else { ?>
                                    <input id="email" type="email" name="email" placeholder="Email" required />
                                <?php } ?>
                                <input id="telefono" type="text" name="telefono" value="<?php echo $voluntario["TELEFONO"] ?>" placeholder="Teléfono" pattern="^[0-9]{9}" required/>
							</div>
							<div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $voluntario["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $voluntario["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $voluntario["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input id="cp" type="text" name="cp" value="<?php echo $voluntario["CODIGOPOSTAL"] ?>" placeholder="Código postal" pattern="^[0-9]{5}" />
                            </div>
                            <div class="form-row right">
                            <?php if (!isset($_GET["edit"])) { ?>
                                <button type="reset" class="btn cancel">Reiniciar</button>
                            <?php } ?>
                                <button id="guardar" type="submit" class="btn primary guardar" name="submit" value="<?php echo isset($_GET["edit"]) ? "edit" : "insert";?>" onclick="validarUsuario()">Guardar</button>
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