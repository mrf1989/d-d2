<?php
session_start();

require_once("models/gestionBD.php");
require_once("models/gestionVoluntarios.php");
require_once("models/paginacion.php");

if(!$_SESSION["admin"]){
	header("Location: index.php");
}
if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];

$pag_selected = isset($_GET["pag_num"]) ? (int) $_GET["pag_num"] :
    (isset($paginacion) ? (int) $paginacion["pag_num"] : 1);
$pag_size = isset($_GET["pag_size"]) ? (int) $_GET["pag_size"] :
    (isset($paginacion) ? (int) $paginacion["pag_size"] : 10);

if ($pag_selected < 1) $pag_selected = 1;
if ($pag_size < 1) $pag_size = 10;

unset($_SESSION["paginacion"]);

$conexion = crearConexionBD();

$query = getAllVoluntarios();
$total_registros = sizeConsulta($conexion, $query);
$total_paginas = (int) ($total_registros / $pag_size);
if ($total_registros % $pag_size > 0) $total_paginas++; 
if ($pag_selected > $total_paginas) $pag_selected = 1;

$paginacion["pag_num"] = $pag_selected;
$paginacion["pag_size"] = $pag_size;
$_SESSION["paginacion"] = $paginacion;

$voluntarios = consultaPaginada($conexion, $query, $pag_selected, $pag_size);
cerrarConexionBD($conexion);

$page_title= "Voluntarios";
include_once("includes/head.php");
?>

<body>
	<?php include_once("includes/header.php"); ?>
	<div class="container">
        <main class="content">
            <div class="content__module">
                <div class="module-title">
                    <h1>Voluntarios</h1>
                    <a href="formVoluntario.php" class="btn primary">Nuevo voluntario</a>
                </div>
                <nav>
                    <div id="enlaces">
                <?php for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
                    if ($pagina == $pag_selected) { ?>
                        <span class="current"><?php echo $pagina; ?></span>
                    <?php } else { ?>
                        <a href="<?php $_SERVER["PHP_SELF"] ?>?pag_num=<?php echo $pagina; ?>&pag_size=<?php echo $pag_size; ?>"><?php echo $pagina; ?></a>
                    <?php } ?>
                <?php } ?>
                    </div>
                    <form method="get">
                        <input type="hidden" id="pag_num" name="pag_num" value="<?php echo $pag_selected; ?>" />
                        Mostrando
                        <input type="number" id="pag_size" name="pag_size" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_size; ?>" autofocus="autofocus" /> entradas de un total de <?php echo $total_registros ?>
                        <button type="submit" class="btn secondary">Actualizar</button>
                    </form>
                </nav>
                <div class="content-tab">
                    <table class="tab horizontal">
                        <tr>
                            <th>DNI</th>
                            <th>Voluntario</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    <?php foreach ($voluntarios as $vol) { ?>
                        <tr>
                            <form action="controllers/controlVoluntarios.php" method="POST">
                                <input type="hidden" name="dni" value="<?php echo $vol["DNI"] ?>">
                                <td><?php echo $vol["DNI"] ?></td>
                                <!-- Puesto que el nombre es un enlace al perfil del voluntario, mandamos en su url el oid del voluntario y por lo tanto el método sería GET, ese oid lo utilizamos para conseguir los datos del voluntario exacto -->
                                <td><a href="perfilVoluntario.php?oid_vol=<?php echo $vol["OID_VOL"]; ?>"><?php echo $vol["NOMBRE"] . " " . $vol["APELLIDOS"] ?></a></td>
                                <td><?php echo $vol["EMAIL"] ?></td>
                                <td class="acciones">
                                    <a href="formVoluntario.php?edit=true&oid_vol=<?php echo $vol["OID_VOL"]; ?>" class="btn secondary">Editar</a>
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