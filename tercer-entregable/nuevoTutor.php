<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionTutores.php");
include_once("includes/functions.php");

if (isset($_GET["edit"]) && isset($_GET["oid_tut"])) {
    $conexion = crearConexionBD();
    $tutor = getTutor($conexion, $_REQUEST["oid_tut"]);
    cerrarConexionBD($conexion);
} else {
    $tutor["NOMBRE"] = "";
    $tutor["APELLIDOS"] = "";
    $tutor["DNI"] = "";
    $tutor["FECHANACIMIENTO"] = "";
    $tutor["EMAIL"] = "";
    $tutor["TELEFONO"] = "";
    $tutor["DIRECCION"] = "";
    $tutor["LOCALIDAD"] = "";
    $tutor["PROVINCIA"] = "";
    $tutor["CODIGOPOSTAL"] = "";
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nuevo participante";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content">
            <div class="content__module">
                <div class="module-title">
                    <!-- Si vista de edición, muestra Editar tutor, si no, Nuevo tutor -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> tutor</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos del tutor</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlTutores.php" method="POST">
                            <!-- input hidden para el oid_tut que identifica al tutor a editar -->
                            <input type="hidden" name="oid_tut" value="<?php echo $tutor["OID_TUT"] ?>">
                            <div class="form-row">
                                <input type="text" name="nombre" value="<?php echo $tutor["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" />
                                <input type="text" name="apellidos" value="<?php echo $tutor["APELLIDOS"] ?>" placeholder="Apellidos" />
                                <input type="text" name="dni" value="<?php echo $tutor["DNI"] ?>" placeholder="DNI" <?php if (isset($_GET["edit"])) echo "readonly" ?>>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha nacimiento:</div>
                                <input type="date" name="fechaNacimiento" value="<?php if (isset($_GET["edit"])) echo getFechaForm($tutor["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" />
                                <?php if ($tutor["EMAIL"] != "") { ?>
                                    <input type="email" name="email" value="<?php echo $tutor["EMAIL"] ?>" placeholder="Email" />
                                <?php } else { ?>
                                    <input type="email" name="email" placeholder="Email" />
                                <?php } ?>
                                <input type="text" name="telefono" value="<?php echo $tutor["TELEFONO"] ?>" placeholder="Teléfono" />
                            </div>
                            <div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $tutor["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $tutor["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $tutor["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input type="text" name="cp" value="<?php echo $tutor["CODIGOPOSTAL"] ?>" placeholder="Código postal" />
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