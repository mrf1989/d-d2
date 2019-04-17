<?php
session_start();

if (isset($_SESSION["excepcion"])) {
    $excepcion = $_SESSION["excepcion"];
    unset($_SESSION["excepcion"]);
}

$page_title = "Excepción";
include_once("includes/head.php");
?>

<body>
    <div class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12 content__error">
                    <h1>Oh! Se ha producido un error...</h1>
                    <p>ERROR: <?php echo $excepcion ?></p>
                    <p>Se encuentra en un sitio seguro, puede volver al menú principal haciendo click <a href="/index.php">aquí</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
