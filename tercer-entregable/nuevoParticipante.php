<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionTutores.php");
include_once("models/gestionParticipantes.php");
include_once("includes/functions.php");

// si viene a la vista para editar datos de un participante registrado
if (isset($_GET["edit"]) && isset($_GET["oid_part"])) {
    $conexion = crearConexionBD();
    $participante = getParticipante($conexion, $_REQUEST["oid_part"]);
    cerrarConexionBD($conexion);
} else {
    $participante["NOMBRE"] = "";
    $participante["APELLIDOS"] = "";
    $participante["DNI"] = "";
    $participante["FECHANACIMIENTO"] = "";
    $participante["GRADODISCAPACIDAD"] = "";
    $participante["EMAIL"] = "";
    $participante["TELEFONO"] = "";
    $participante["DIRECCION"] = "";
    $participante["LOCALIDAD"] = "";
    $participante["PROVINCIA"] = "";
    $participante["CODIGOPOSTAL"] = "";
    $participante["TUTORLEGAL"] = "";
}

// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

// consulta tutores legales para mostrar en el formulario
$conexion = crearConexionBD();
$tutores = getTutores($conexion);
cerrarConexionBD($conexion);

$page_title = "Nuevo participante";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content">
            <div class="content__module">
                <div class="module-title">
                    <!-- Si vista de edición, muestra Editar participante, si no, Nuevo participante -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> participante</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos del participante</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlParticipantes.php" method="POST">
                            <!-- input hidden para le oid_part que identifica al participante a editar -->
                            <input type="hidden" name="oid_part" value="<?php echo $participante["OID_PART"] ?>">
                            <div class="form-row">
                                <input type="text" name="nombre" value="<?php echo $participante["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" />
                                <input type="text" name="apellidos" value="<?php echo $participante["APELLIDOS"] ?>" placeholder="Apellidos" />
                                <input type="text" name="dni" value="<?php echo $participante["DNI"] ?>" placeholder="DNI" <?php if (isset($_GET["edit"])) echo "readonly" ?>>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha nacimiento:</div>
                                <input type="date" name="fechaNacimiento" value="<?php if (isset($_GET["edit"])) echo getFechaForm($participante["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" />
                                <input type="text" name="discapacidad" value="<?php if (isset($_GET["edit"])) echo "0" . $participante["GRADODISCAPACIDAD"] ?>" placeholder="Grado discapacidad" <?php if (isset($_GET["edit"])) echo "readonly" ?>>
                            </div>
                            <div class="form-row">
                                <?php if ($participante["EMAIL"] != "") { ?>
                                    <input type="email" name="email" value="<?php echo $participante["EMAIL"] ?>" placeholder="Email" />
                                <?php } else { ?>
                                    <input type="email" name="email" placeholder="Email" />
                                <?php } ?>
                                <input type="text" name="telefono" value="<?php echo $participante["TELEFONO"] ?>" placeholder="Teléfono" />
                            </div>
                            <div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $participante["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $participante["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $participante["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input type="text" name="cp" value="<?php echo $participante["CODIGOPOSTAL"] ?>" placeholder="Código postal" />
                            </div>
                            <div class="form-row">
                                <select name="tutor" id="tutor" <?php if (isset($_GET["edit"])) echo "disabled" ?>>
                                    <option value="null">-- Seleccionar un tutor legal --</option>
                                <?php foreach ($tutores as $tut) { ?>
                                    <option value="<?php echo $tut["DNI"]; ?>" <?php echo isset($participante["OID_TUT"]) && ($tut["OID_TUT"] == $participante["OID_TUT"]) ? "selected=\"selected\"" : "" ?>><?php echo $tut["DNI"] . " - " . $tut["NOMBRE"] . " " . $tut["APELLIDOS"]; ?></option>
                                <?php } ?>
                                </select>
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