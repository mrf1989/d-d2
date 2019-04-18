<?php
session_start();

require_once("models/gestionBD.php");
require_once("models/gestionVoluntarios.php");

if(!$_SESSION["admin"]){
	header("Location: index.php");
}

$conexion=crearConexionBD();
$voluntarios= getVoluntarios($conexion);
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
                    <a href="nuevoVoluntario.php" class="btn primary">Nuevo voluntario</a>
                </div>
                <table class="tab horizontal">
                    <tr>
                        <th>DNI</th>
                        <th>Participante</th>
                        <th>Fecha nacimiento</th>
                        <th></th>
                    </tr>
                <?php foreach ($voluntarios as $vol) { ?>
                    <tr>
                        <form>
                            <!-- Mandamos este input oculto para obtener el dni del voluntario exacto que queremos consultar sus datos, eliminar o modificar los mismos-->
                            <input type="hidden" name="dni" value="<?php echo $vol["DNI"] ?>">
                            <td><?php echo $vol["DNI"] ?></td>
                            <!-- Puesto que el nombre es un enlace al perfil del voluntario, mandamos en su url el oid del voluntario y por lo tanto el método sería GET, ese oid lo utilizamos para conseguir los datos del voluntario exacto -->
                            <td><a href="perfilVoluntario.php?oid_vol=<?php echo $vol["OID_VOL"]; ?>"><?php echo $vol["NOMBRE"] . " " . $vol["APELLIDOS"] ?></a></td>
                            <td><?php echo $vol["FECHANACIMIENTO"] ?></td>
                            <td class="acciones">
                                <a href="nuevoVoluntario.php?edit=true&oid_vol=<?php echo $vol["OID_VOL"]; ?>" class="btn secondary">Editar</a>
                                <button class="btn secondary" type="submit" name="submit" value="delete">Borrar</button>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </main>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>