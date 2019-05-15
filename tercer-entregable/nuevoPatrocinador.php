<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionPatrocinadores.php");
include_once("includes/functions.php");

// si viene a la vista para editar datos de un patrocinador registrado
if (isset($_GET["edit"]) && isset($_GET["cif"])) {
    $conexion = crearConexionBD();
    $patrocinador = getpatrocinador($conexion, $_REQUEST["cif"]);
    cerrarConexionBD($conexion);
} else {
    $patrocinador["NOMBRE"] = "";
    $patrocinador["CIF"] = "";
    $patrocinador["EMAIL"] = "";
    $patrocinador["TELEFONO"] = "";
    $patrocinador["DIRECCION"] = "";
    $patrocinador["LOCALIDAD"] = "";
    $patrocinador["PROVINCIA"] = "";
    $patrocinador["CODIGOPOSTAL"] = "";
}

// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nuevo patrocinador";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
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
                    <!-- Si vista de edición, muestra Editar patrocinador, si no, Nuevo patrocinador -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> patrocinador</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos del patrocinador</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlPatrocinadores.php" method="POST">
                            <!-- input hidden para el cif que identifica al patrocinador a editar -->
                            <input id="cif" type="hidden" name="cif" value="<?php echo $patrocinador["CIF"] ?>">
                            <div class="form-row">
                                <input id="nombre" type="text" name="nombre" value="<?php echo $patrocinador["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" required/>
                                <input type="text" name="cif" value="<?php echo $patrocinador["CIF"] ?>" placeholder="CIF" <?php if (isset($_GET["edit"])) echo "readonly" ?> pattern="^[A-Z][0-9]{8}" required/>
                            </div>
                            <div class="form-row">
                                <?php if ($patrocinador["EMAIL"] != "") { ?>
                                    <input id="email" type="email" name="email" value="<?php echo $patrocinador["EMAIL"] ?>" placeholder="Email" required/>
                                <?php } else { ?>
                                    <input id="email" type="email" name="email" placeholder="Email" required />
                                <?php } ?>
                                <input id="telefono" type="text" name="telefono" value="<?php echo $patrocinador["TELEFONO"] ?>" placeholder="Teléfono" pattern="^[0-9]{9}" required />
                            </div>
                            <div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $patrocinador["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $patrocinador["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $patrocinador["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input id="cp" type="text" name="cp" value="<?php echo $patrocinador["CODIGOPOSTAL"] ?>" placeholder="Código postal" pattern="^[0-9]{5}" />
                            </div>
                            <div class="form-row right">
                            <?php if (!isset($_GET["edit"])) { ?>
                                <button type="reset" class="btn cancel">Reiniciar</button>
                            <?php } ?>
                                <button id="guardar" type="submit" class="btn primary guardar" name="submit" value="<?php echo isset($_GET["edit"]) ? "edit" : "insert";?>">Guardar</button>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>