<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

if (!isset($_GET["oid_act"])) {
    Header("Location: proyectos.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionActividades.php");
include_once("models/gestionVoluntarios.php");
include_once("includes/functions.php");

$conexion = crearConexionBD();
$actividad = getActividad($conexion, $_GET["oid_act"]);

cerrarConexionBD($conexion);

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$page_title = "Nueva colaboración: " . $actividad["NOMBRE"];
include_once("includes/head.php");
?>
<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content__module">
            <?php 
                    // Mostrar los errores de validación (Si los hay)
                    if (isset($errores) && count($errores)>0) { ?>
                    <div id="div_errores" class="content__error">
                    <h4> Errores en el formulario:</h4>
                    <?php foreach($errores as $error) echo $error; ?>
                    </div>
                <?php }
                ?>
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1>Nueva colaboración</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form">
                    <fieldset>
                        <legend>Buscador de voluntarios</legend>
                        <form action="controllers/controlVoluntariados.php" method="get">
                            <div class="row">
                                <div class="col-6 col-tab-12">
                                    <div class="form-row">
                                        <input type="text" name="search" id="search" placeholder="Apellidos..." autofocus="autofocus" autocomplete="off">
                                        <input type="hidden" name="oid_act" value="<?php echo $_GET["oid_act"] ?>">
                                    </div>
                                    <div class="form-row">
                                        <button type="reset" class="btn cancel">Reiniciar</button>
                                        <button type="submit" name="submit" value="inscribir" class="btn primary">Guardar</button>
                                    </div>
                                </div>
                                <div class="col-6 col-tab-12">
                                    <div id="results"></div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("includes/footer.php"); ?>
    <script>
        $(document).ready(function () {
            $('#search').on("input", function () {
                var query = $('#search').val();
                if (query == "") {
                    $('#results').empty();
                } else {
                    $.get("controllers/buscarVoluntarios.php", 
                        {
                            str: query.toLowerCase()
                        },
                        function (data) {
                            $('#results').empty();
                            $('#results').append(data);
                    });
                }
            });
        });
    </script>
</body>