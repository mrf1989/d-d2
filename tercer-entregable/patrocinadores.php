<?php
session_start();

if (!$_SESSION["admin"]) {
    Header("Location: index.php");
}

include_once("models/gestionBD.php");
include_once("models/gestionPatrocinadores.php");
include_once("models/paginacion.php");
include_once("includes/functions.php");

if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];

$pag_seleccionada = isset($_GET["pag_num"]) ? (int) $_GET["pag_num"] :
    (isset($paginacion) ? (int) $paginacion["pag_num"] : 1);
$pag_size = isset($_GET["pag_size"]) ? (int) $_GET["pag_size"] :
    (isset($paginacion) ? (int) $paginacion["pag_size"] : 10);

if ($pag_seleccionada < 1) $pag_seleccionada = 1;
if ($pag_size < 1) $pag_size = 10;

unset($_SESSION["paginacion"]);

$conexion = crearConexionBD();

$query = getAllPatrocinadores();
$total_registros = sizeConsulta($conexion, $query);
$total_paginas = (int) ($total_registros / $pag_size);
if ($total_registros % $pag_size > 0) $total_paginas++; 
if ($pag_seleccionada > $total_paginas) $pag_seleccionada = 1;

$paginacion["pag_num"] = $pag_seleccionada;
$paginacion["pag_size"] = $pag_size;
$_SESSION["paginacion"] = $paginacion;

$patrocinadores = consultaPaginada($conexion, $query, $pag_seleccionada, $pag_size);
cerrarConexionBD($conexion);

$page_title = "Patrocinadores";
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <main class="content">
            <div class="content__module">
                <div class="module-title">
                    <h1>Patrocinadores</h1>
                    <a href="formPatrocinador.php" class="btn primary">Nuevo patrocinador</a>
                </div>
                <nav>
                    <div id="enlaces">
                <?php for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
                    if ($pagina == $pag_seleccionada) { ?>
                        <span class="current"><?php echo $pagina; ?></span>
                    <?php } else { ?>
                        <a href="<?php $_SERVER["PHP_SELF"] ?>?pag_num=<?php echo $pagina; ?>&pag_size=<?php echo $pag_size; ?>"><?php echo $pagina; ?></a>
                    <?php } ?>
                <?php } ?>
                    </div>
                    <form method="get">
                        <input type="hidden" id="pag_num" name="pag_num" value="<?php echo $pag_seleccionada; ?>" />
                        Mostrando
                        <input type="number" id="pag_size" name="pag_size" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_size; ?>" autofocus="autofocus" /> entradas de un total de <?php echo $total_registros ?>
                        <button type="submit" class="btn secondary">Actualizar</button>
                    </form>
                </nav>
                <div class="content-tab">
                    <table class="tab horizontal">
                        <tr>
                            <th>CIF</th>
                            <th>Patrocinador</th>
                            <th>Tipo</th>
                            <th></th>
                        </tr>
                    <?php foreach ($patrocinadores as $pat) { ?>
                        <tr>
                            <form action="controllers/controlPatrocinadores.php" method="POST">
                                <input type="hidden" name="cif" value="<?php echo $pat["CIF"] ?>">
                                <td><?php echo $pat["CIF"] ?></td>
                                <td><a href="perfilPatrocinador.php?cif=<?php echo $pat["CIF"]; ?>"><?php echo $pat["NOMBRE"] ?></a></td>
                                <td><?php echo $pat["TIPO"] ?></td>
                                <td class="acciones">
                                    <a href="formPatrocinador.php?edit=true&cif=<?php echo $pat["CIF"]; ?>" class="btn secondary">Editar</a>
                                    <button class="btn secondary" type="submit" name="submit" value="delete">Borrar</button>
                                </td>
                            </form>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>

