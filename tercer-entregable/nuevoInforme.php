<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nuevo informe médico";
include_once("includes/head.php");

?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content__module">
        <?php 
                    // Mostrar los erroes de validación (Si los hay)
                    if (isset($errores) && count($errores)>0) { ?>
                    <div id="div_errores" class="content__error">
                    <h4> Errores en el formulario:</h4>
                    <?php 
                    
                    foreach($errores as $error) echo $error; ?>
                    </div>
                <?php }
                unset($errores);
                ?>
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1>Nuevo informe médico</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form">
                    <fieldset>
                        <legend>Datos del informe</legend>
                        <form action="controllers/controlParticipantes.php" method="POST">
                            <div class="row">
                                <div class="col-12 col-tab-12">
                                    <textarea name="descripcion" id="" cols="30" rows="10" placeholder="Descripción completa del informe emitido por el profesional médico..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-tab-12 acciones">
                                    <input type="hidden" name="oid_part" value="<?php echo $_GET["oid_part"] ?>">
                                    <button type="reset" class="btn cancel">Cancelar</button>
                                    <button type="submit" class="btn primary" name="submit" value="informe" placeholder="submit">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>  
        </div>
    </main>
    <?php include_once("includes/footer.php"); ?>
</body>