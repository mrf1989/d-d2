<?php

function getVoluntarios($conexion){
	try {
		$consulta= "SELECT * FROM VOLUNTARIOS VOL LEFT JOIN PERSONAS PER ON VOL.DNI = PER.DNI";
		$stmt = $conexion->query($consulta);
        return $stmt;
	} catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}

function searchVoluntarios($conexion, $str) {
    $voluntarios = getVoluntarios($conexion);
    $res = "";
    foreach ($voluntarios as $vol) {
        if (strpos(strtolower($vol["APELLIDOS"]), $str) !== false) {
            $res[] = $vol;
        }
    }
    return $res;
}

function getVoluntario($conexion, $oid_vol){
	try{
		$consulta= "SELECT * FROM VOLUNTARIOS VOL LEFT JOIN PERSONAS PER ON VOL.DNI = PER.DNI WHERE VOL.OID_VOL= :oid_vol";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':oid_vol', $oid_vol);
		$stmt->execute();		
		return $stmt->fetch();
	} catch (PDOException $e){
 		$_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}
function getHistorialColaboracion($conexion, $oid_vol){
	try{
		$consulta="SELECT P.ubicacion AS Proj_lugar, A.OID_Act AS OID_Act, A.nombre AS Act_nombre, A.fechaInicio AS Act_fechainicio FROM PERSONAS NATURAL JOIN VOLUNTARIOS NATURAL JOIN COLABORACIONES C LEFT JOIN ACTIVIDADES A ON A.OID_Act=C.OID_Act
        LEFT JOIN PROYECTOS P ON P.OID_Proj=A.OID_Proj
        WHERE OID_Vol=:oid_vol ORDER BY A.fechaInicio DESC";
        $stmt= $conexion->prepare($consulta);
        $stmt->bindParam(':oid_vol', $oid_vol);
        $stmt->execute();
        return $stmt->fetchAll();
	}catch(PDOException $e){
 		$_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}

function getProximasActVol($conexion, $oid_vol) {
    try {
        $consulta = "SELECT COLAB.*, ACT.*, PROJ.UBICACION FROM COLABORACIONES COLAB LEFT JOIN ACTIVIDADES ACT ON COLAB.OID_ACT=ACT.OID_ACT LEFT JOIN PROYECTOS PROJ ON ACT.OID_PROJ=PROJ.OID_PROJ WHERE COLAB.OID_VOL=:oid_vol AND ACT.FECHAINICIO >= (SYSDATE+5) ORDER BY ACT.FECHAINICIO ASC";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_vol', $oid_vol);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function getAllVoluntarios(){
	 $query = "SELECT * FROM VOLUNTARIOS VOL LEFT JOIN PERSONAS PER ON VOL.DNI = PER.DNI";
    return $query;
}
function getEliminarVoluntario($conexion, $dni){
	try{
		$consulta="CALL ELIMINAR_PERSONA(:dni)";
		$stmt= $conexion->prepare($consulta);
		$stmt->bindParam(':dni', $dni);
		$stmt->execute();
		return true;
	}catch (PDOException $e) {
 		$_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}
function getInsertarVoluntario($conexion, $vol){
	try{
		$consulta="CALL REGISTRAR_VOLUNTARIO(:dni, :nombre, :apellidos, :fechaNacimiento, :direccion, :localidad, :provincia, :cp, :email, :telefono, '123456')";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':dni',$vol["dni"]);
		$stmt->bindParam(':nombre',$vol["nombre"]);
		$stmt->bindParam(':apellidos',$vol["apellidos"]);
		$stmt->bindParam(':fechaNacimiento', $vol["fechaNacimiento"]);
		$stmt->bindParam(':direccion', $vol["direccion"]);
		$stmt->bindParam(':localidad', $vol["localidad"]);
		$stmt->bindParam(':provincia', $vol["provincia"]);
		$stmt->bindParam(':cp', $vol["cp"]);
		$stmt->bindParam(':email', $vol["email"]);
        $stmt->bindParam(':telefono', $vol["telefono"]);
        $stmt->execute();
        return true;
	} catch(PDOException $e){
 		$_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}
function getActualizarVoluntario($conexion, $vol){
	try{
		$consulta="CALL ACT_PERSONA(:dni, :nombre, :apellidos, :fechaNacimiento, :direccion, :localidad, :provincia, :cp, :email, :telefono, '123456')";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':dni',$vol["dni"]);
		$stmt->bindParam(':nombre',$vol["nombre"]);
		$stmt->bindParam(':apellidos',$vol["apellidos"]);
		$stmt->bindParam(':fechaNacimiento', $vol["fechaNacimiento"]);
		$stmt->bindParam(':direccion', $vol["direccion"]);
		$stmt->bindParam(':localidad', $vol["localidad"]);
		$stmt->bindParam(':provincia', $vol["provincia"]);
		$stmt->bindParam(':cp', $vol["cp"]);
		$stmt->bindParam(':email', $vol["email"]);
        $stmt->bindParam(':telefono', $vol["telefono"]);
        $stmt->execute();
        return true;
	} catch(PDOException $e){
 		$_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
	}
}
function validarAltaVoluntario($voluntario){
	//validación del dni
	if($voluntario["dni"]==""){
		$errores[] = "<p>El DNI debe completarse</p>";
	}else if(!preg_match("/^[0-9]{8}[A-Z]$/", $voluntario["dni"])){
		$errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $voluntario["dni"] . "</p>";
	}
	//validación del nombre
	if ($voluntario["nombre"]=="") {
		$errores[] = "<p>El nombre debe completarse</p>";
	}
	//validación de los apellidos
	if ($voluntario["apellidos"]=="") {
		$errores[] = "<p>Los apellidos deben completarse</p>";
	}
	//validación de la fecha de nacimiento
	$fechaMin = strtotime("now -18 year");
    $fechaNac = strtotime($voluntario["fechaNacimiento"]);
	if ($voluntario["fechaNacimiento"]=="") {
		$errores[] = "<p>La fecha de nacimiento debe completarse</p>";
	}elseif ($fechaNac > $fechaMin) {
        $errores[] = "<p>El voluntario debe tener al menos 18 años</p>";
    }
	//validación del email
	if($voluntario["email"]==""){ 
		$errores[] = "<p>El email debe completarse</p>";
	}else if(!filter_var($voluntario["email"], FILTER_VALIDATE_EMAIL)){
		$errores[] = "<p>El email es incorrecto: " . $voluntario["email"]. "</p>";
	}
	//validación del número de teléfono
	if ($voluntario["telefono"]=="") {
		$errores[] = "<p>El número de teléfono debe completarse</p>";
	}elseif (!preg_match("/^[0-9]{9}$/", $voluntario["telefono"])) {
		$errores[] = "<p>El telefono debe contener 9 números: ". $voluntario["telefono"] ."</p>";
	}
	 //validación del código postal
	if ($voluntario["cp"] != "") {
		if (!preg_match("/^[0-9]{5}$/", $voluntario["cp"])) {
        $errores[] = "<p>El código postal debe contener 5 números: ". $voluntario["cp"] ."</p>";
    	}
	}
    
	return $errores;
}
?>