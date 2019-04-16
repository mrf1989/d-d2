<?php
// TODO probar esta vista
session_start();

if (isset($_SESSION["excepcion"])) {
    $excepcion = $_SESSION["excepcion"];
    unset($_SESSION["excepcion"]);
}
$page_title = "Excepción";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12 content__error">
                    <?php echo $excepcion ?>
                </div>
            </div>
        </div>
    </div>
</body>
