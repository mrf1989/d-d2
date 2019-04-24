<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionProyectos.php");
include_once("models/gestionActividades.php");
include_once("includes/functions.php");

// si viene a la vista para editar datos de una actividad registrada
if (isset($_GET["edit"]) && isset($_GET["oid_act"])) {
    $conexion = crearConexionBD();
    $actividad = getActividad($conexion, $_GET["oid_act"]);
    cerrarConexionBD($conexion);
} else {
    $actividad["NOMBRE"] = "";
    $actividad["NUMEROPLAZAS"] = "";
    $actividad["FECHAINICIO"] = "";
    $actividad["FECHAFIN"] = "";
    $actividad["COSTETOTAL"] = "";
    $actividad["OBJETIVO"] = "";
    $actividad["TIPO"] = "";
}

// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nueva actividad";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content">
            <div class="content__module">
                <div class="module-title">
                    <!-- Si vista de edición, muestra Editar actividad, si no, Nuevo actividad -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nueva" ?> actividad</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos de la actividad</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlActividad.php" method="POST">
                        <?php if (!$_GET["edit"]) { ?>
                            <input type="hidden" name="oid_proj" value="<?php echo $_REQUEST["oid_proj"] ?>">
                        <?php } ?>
                            <input type="hidden" name="oid_act" value="<?php echo $actividad["OID_ACT"] ?>">
                            <div class="form-row">
                                <input type="text" name="nombre" value="<?php echo $actividad["NOMBRE"] ?>" placeholder="Nombre de la actividad" autofocus="autofocus" />
                                Nº plazas:
                                <input type="number" name="numeroplazas" value="<?php echo $actividad["NUMEROPLAZAS"] ?>" placeholder="Nº plazas" />
                                <select name="tipo">
                                    <option value="">Tipo de actividad</option>
                                    <option value="deportiva">Deportiva</option>
                                    <option value="formativa">Formativa</option>
                                    <option value="social">Social</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha inicio:</div>
                                <input type="date" name="fechainicio" value="<?php if (isset($_GET["edit"])) echo getFechaForm($actividad["FECHAINICIO"]) ?>" placeholder="Fecha inicio" />
                                <div class="form-label">Fecha finalización:</div>
                                <input type="date" name="fechafin" value="<?php if (isset($_GET["edit"])) echo getFechaForm($actividad["FECHAFIN"]) ?>" placeholder="Fecha finalización" />
                                <input type="number" name="costetotal" value="<?php echo $actividad["COSTETOTAL"] ?>" placeholder="Coste total" />
                            </div>
                            <div class="form-row">
                                <p>Objetivos de la actividad:</p>
                                <textarea name="objetivo" id="" cols="30" rows="10"><?php echo $actividad["OBJETIVO"] ?></textarea>
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