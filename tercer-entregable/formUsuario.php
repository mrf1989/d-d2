<?php
session_start();

include_once("models/gestionBD.php");
include_once("models/gestionParticipantes.php");
include_once("models/gestionTutores.php");
include_once("models/gestionVoluntarios.php");
include_once("models/gestionUsuarios.php");
include_once("includes/functions.php");

if (!isset($_SESSION["user"])) {
    Header("Location: index.php");
}else{
	$conexion = crearConexionBD();
    if ($_SESSION["user"] == 2) {
    	$oid_part = getOidPart($conexion, $_SESSION["login"]);
        $participante = getParticipante($conexion, $oid_part["OID_PART"]);
    } else {
        $oid_vol = getOidVol($conexion, $_SESSION["login"]);
        $voluntario = getVoluntario($conexion, $oid_vol["OID_VOL"]);
	}
    cerrarConexionBD($conexion);
}
// TODO hay que recoger algo de vuelta de la validacion
if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

// consulta tutores legales para mostrar en el formulario
$conexion = crearConexionBD();
$tutores = getTutores($conexion);
cerrarConexionBD($conexion);

if (isset($oid_part)) {
	$page_title = "Editar usuario". $participante["NOMBRE"];
}else{
	$page_title = "Editar usuario". $voluntario["NOMBRE"];
}
include_once("includes/head.php");
?>

<body>
    <?php include_once("includes/header.php"); ?>
    <main class="container">
        <div class="content">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="content__module">
                        <div class="module-title">
                            <h2>Editar mi perfil</h2>
                        </div>
                        <?php 
                    		// Mostrar los erroes de validación (Si los hay)
		                    if (isset($errores) && count($errores)>0) { ?>
		                    <div id="div_errores" class="content__error">
		                    <h4> Errores en el formulario:</h4>
		                    <?php foreach($errores as $error) echo $error; ?>
		                    </div>
		                <?php }
		                ?>
                        <div class="form">
							<fieldset>
								<legend>Mis datos</legend>
								<form action="controllers/controlUsuarios.php" method="POST">
									<!--Campos ocultos para el oid_part y el oid_vol que identifica al usuario a editar-->
		                            <input type="hidden" name="oid_vol" value="<?php echo $voluntario["OID_VOL"] ?>">
		                            <input type="hidden" name="oid_part" value="<?php echo $participante["OID_PART"] ?>">
		                            <div class="form-row"> 
		                                <input id="nombre" type="text" name="nombre" value="<?php echo isset($oid_vol) ? $voluntario["NOMBRE"] : $participante["NOMBRE"] ?>" placeholder="Nombre" autofocus="autofocus" required />
		                                
		                                <input id="apellidos" type="text" name="apellidos" value="<?php echo isset($oid_vol) ? $voluntario["APELLIDOS"] : $participante["APELLIDOS"] ?>" placeholder="Apellidos" required />
		                                
		                                <input id="dni" type="text" name="dni" value="<?php echo isset($oid_vol) ? $voluntario["DNI"] : $participante["DNI"] ?>" placeholder="DNI" pattern="^[0-9]{8}[A-Z]" <?php echo "readonly" ?> required/>
		                            </div>
		                            <div class="form-row">
		                                <div class="form-label">Fecha nacimiento:</div>
		                                <input id="fechaNacimiento" type="date" name="fechaNacimiento" value="<?php echo isset($oid_vol) ? getFechaForm($voluntario["FECHANACIMIENTO"]) : getFechaForm($participante["FECHANACIMIENTO"]) ?>" placeholder="Fecha nacimiento" required/>

		                                <input id="email" type="email" name="email" value="<?php echo isset($oid_vol) ? $voluntario["EMAIL"] : $participante["EMAIL"]?>" placeholder="Email"/>

		                                <input id="telefono" type="text" name="telefono" value="<?php echo isset($oid_vol) ? $voluntario["TELEFONO"] : $participante["TELEFONO"] ?>" placeholder="Teléfono" pattern="^[0-9]{9}" required/>
									</div>
									<div class="form-row">
		                                <input type="text" name="direccion" value="<?php echo isset($oid_vol) ? $voluntario["DIRECCION"] : $participante["DIRECCION"] ?>" placeholder="Dirección" />

		                                <input type="text" name="localidad" value="<?php echo isset($oid_vol) ? $voluntario["LOCALIDAD"] : $participante["LOCALIDAD"]?>" placeholder="Localidad" />

		                                <input type="text" name="provincia" value="<?php echo isset($oid_vol) ? $voluntario["PROVINCIA"] : $participante["PROVINCIA"] ?>" placeholder="Provincia" />

		                                <input id="cp" type="text" name="cp" value="<?php echo isset($oid_vol) ? $voluntario["CODIGOPOSTAL"] : $participante["CODIGOPOSTAL"] ?>" placeholder="Código postal" pattern="^[0-9]{5}" />
		                            </div>
		                            <?php if (isset($oid_part)) { ?>
										<div class="form-row">
											<input id="discapacidad" type="text" name="discapacidad" value="<?php echo "0".$participante["GRADODISCAPACIDAD"] ?>" placeholder="Grado discapacidad"  <?php echo "readonly" ?> required/>

											<select name="tutor" id="tutor" disabled required>
			                                    <option value="" >-- Seleccionar un tutor legal --</option>
			                                	<?php foreach ($tutores as $tut) { ?>
			                                    <option value="<?php echo $tut["DNI"]; ?>" <?php echo isset($participante["OID_TUT"]) && ($tut["OID_TUT"] == $participante["OID_TUT"]) ? "selected=\"selected\"" : "" ?>><?php echo $tut["DNI"] . " - " . $tut["NOMBRE"] . " " . $tut["APELLIDOS"]; ?></option>
			                                	<?php } ?>
			                                </select>
                                		</div>										
		                            <?php } ?>
		                            <div class="form-row right">
		                                <button id="guardar" type="submit" class="btn primary guardar" name="submit" value="edit" onclick="validarUsuario()"> Guardar</button>
		                            </div>
		                        </form>
		                    </fieldset>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</main>
	<?php include_once("includes/footer.php"); ?>
</body>