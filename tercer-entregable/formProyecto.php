<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionProyectos.php");
include_once("includes/functions.php");

// si viene a la vista para editar datos de un proyecto registrado
if (isset($_GET["edit"]) && isset($_GET["oid_proj"])) {
    $conexion = crearConexionBD();
    $proyecto = getProyecto($conexion, $_REQUEST["oid_proj"]);
    cerrarConexionBD($conexion);
} else {
    $proyecto["NOMBRE"] = "";
    $proyecto["UBICACION"] = "";
    $proyecto["ESEVENTO"] = "";
    $proyecto["ESPROGDEP"] = "";
}

// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nuevo proyecto";
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
                    <!-- Si vista de edición, muestra Editar proyecto, si no, Nuevo proyecto -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> proyecto</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos del proyecto</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlProyectos.php" method="POST">
                            <!-- input hidden para le oid_proj que identifica al proyecto a editar -->
                            <input type="hidden" name="oid_proj" value="<?php echo $proyecto["OID_PROJ"] ?>">
                            <div class="form-row">
                                <input type="text" name="nombre" value="<?php echo $proyecto["NOMBRE"] ?>" placeholder="Nombre del proyecto" autofocus="autofocus" required/>
                                <input type="text" name="ubicacion" value="<?php echo $proyecto["UBICACION"] ?>" placeholder="Localización" required/>
                            </div>
                            <p>Tipo:</p>
                            <div class="form-row">
                                <label><input type="radio" name="tipoProj" value="evento" <?php echo ($proyecto["ESEVENTO"]) ? "checked" : "" ?> required>Evento</label>
                                <label><input type="radio" name="tipoProj" value="progdep" <?php echo ($proyecto["ESPROGDEP"]) ? "checked" : "" ?>>Programa deportivo</label>
                            </div>
                            <div class="form-row right">
                            <?php if (!isset($_GET["edit"])) { ?>
                                <button type="reset" class="btn cancel">Cancelar</button>
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