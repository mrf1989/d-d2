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
                    <!-- Si vista de edición, muestra Editar tutor, si no, Nuevo tutor -->
                    <h1><?php echo isset($_GET["edit"]) ? "Editar" : "Nuevo" ?> tutor</h1>
                </div>
                <div class="form">
                    <fieldset>
                        <legend>Datos del tutor</legend>
                        <!-- TODO mostrar errores de validación -->
                        <form action="controllers/controlTutores.php" method="POST">
                            <!-- input hidden para el oid_tut que identifica al tutor a editar -->
                        <?php if (isset($_GET["edit"]) && isset($_GET["oid_tut"])){ ?>
                            <input type="hidden" name="oid_tut" value="<?php echo $tutor["OID_TUT"] ?>">
                        <?php } ?>
                            <div class="form-row">
                                <input id="nombre" type="text" name="nombre" value="<?php echo $tutor["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" required />
                                <input id="apellidos" type="text" name="apellidos" value="<?php echo $tutor["APELLIDOS"] ?>" placeholder="Apellidos" required/>
                                <input id="dni" type="text" name="dni" value="<?php echo $tutor["DNI"] ?>" placeholder="DNI" pattern="^[0-9]{8}[A-Z]" <?php if (isset($_GET["edit"])) echo "readonly" ?> required>
                            </div>
                            <div class="form-row">
                                <div class="form-label">Fecha nacimiento:</div>
                                <input id="fechaNacimiento" type="date" name="fechaNacimiento" value="<?php if (isset($_GET["edit"])) echo getFechaForm($tutor["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" required />
                                <?php if ($tutor["EMAIL"] != "") { ?>
                                    <input id="email" type="email" name="email" value="<?php echo $tutor["EMAIL"] ?>" placeholder="Email" required/>
                                <?php } else { ?>
                                    <input id="email" type="email" name="email" placeholder="Email" required/>
                                <?php } ?>
                                <input id="telefono" type="text" name="telefono" value="<?php echo $tutor["TELEFONO"] ?>" placeholder="Teléfono" pattern="^[0-9]{9}" required/>
                            </div>
                            <div class="form-row">
                                <input type="text" name="direccion" value="<?php echo $tutor["DIRECCION"] ?>" placeholder="Dirección" />
                                <input type="text" name="localidad" value="<?php echo $tutor["LOCALIDAD"] ?>" placeholder="Localidad" />
                                <input type="text" name="provincia" value="<?php echo $tutor["PROVINCIA"] ?>" placeholder="Provincia" />
                                <input id="cp" type="text" name="cp" value="<?php echo $tutor["CODIGOPOSTAL"] ?>" placeholder="Código postal" pattern="^[0-9]{5}"/>
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