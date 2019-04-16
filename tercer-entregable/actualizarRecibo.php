<?php
session_start();

if (!$_SESSION["admin"] && !isset($_GET["oid_rec"])) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionParticipantes.php");

$conexion = crearConexionBD();
$recibo = getRecibo($conexion, $_GET["oid_rec"]);
cerrarConexionBD($conexion);

$page_title = "Editar recibo nº " . $recibo["OID_REC"];
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content__module">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="module-title">
                        <h1>Recibo nº <?php echo $recibo["OID_REC"] ?></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form">
                    <fieldset>
                        <legend>Datos del recibo</legend>
                        <form action="controllers/controlParticipantes.php" method="POST">
                            <!-- inputs hidden con los datos que se deben pasar al controlador -->
                            <input type="hidden" name="oid_part" value="<?php echo $_GET["oid_part"] ?>">
                            <input type="hidden" name="oid_rec" value="<?php echo $recibo["OID_REC"]?>">
                            <input type="hidden" name="vencimiento" value="<?php echo $recibo["FECHAVENCIMIENTO"]?>">
                            <input type="hidden" name="importe" value="<?php echo $recibo["IMPORTE"]?>">
                            <input type="hidden" name="estado" value="<?php echo $recibo["ESTADO"]?>">
                            <div class="row">
                                <div class="col-8 col-tab-12">
                                    <!-- condición: si coincide el estado, input radio checked por defecto -->
                                    <label>Pagado <input type="radio" name="estado" value="pagado" <?php echo ($recibo["ESTADO"] == 'pagado') ? "checked" : "" ?>></label>
                                    <label>Pendiente <input type="radio" name="estado" value="pendiente" <?php echo ($recibo["ESTADO"] == 'pendiente') ? "checked" : "" ?>></label>
                                    <label>Anulado<input type="radio" name="estado" value="anulado" <?php echo ($recibo["ESTADO"] == 'anulado') ? "checked" : "" ?>></label>
                                </div>
                                <div class="col-4 col-tab-12 acciones">
                                    <button type="submit" class="btn primary" name="submit" value="recibo" placeholder="submit">Guardar</button>
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