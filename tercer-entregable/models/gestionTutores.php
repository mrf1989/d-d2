<?php

function getTutores($conexion) {
    try {
        $consulta = "SELECT * FROM TUTORESLEGALES TUT LEFT JOIN PERSONAS PER ON TUT.DNI = PER.DNI ORDER BY PER.NOMBRE ASC";
        $stmt = $conexion->query($consulta);
        return $stmt;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function getAllTutores() {
    $query = "SELECT * FROM TUTORESLEGALES TUT LEFT JOIN PERSONAS PER ON TUT.DNI = PER.DNI";
    return $query;
}

function getTutor($conexion, $oid_tut) {
    try {
        $consulta = "SELECT * FROM TUTORESLEGALES TUT LEFT JOIN PERSONAS PER ON TUT.DNI = PER.DNI WHERE TUT.OID_TUT =:oid_tut";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_tut', $oid_tut);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function getPartTut($conexion, $oid_tut) {
    try {
        $consulta = "SELECT * FROM PARTICIPANTES PART LEFT JOIN PERSONAS PER ON PART.DNI = PER.DNI WHERE PART.OID_TUT =:oid_tut";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_tut', $oid_tut);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}
function consultarTutor($conexion, $dni){
    try {
        $consulta = "SELECT COUNT(*) FROM TUTORESLEGALES WHERE DNI=:dni";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function insertarTutor($conexion, $tut) {
    try {
        $stmt = $conexion->prepare("CALL REGISTRAR_TUTORLEGAL(:dni, :nombre, :apellidos, :fechaNacimiento, :direccion, :localidad, :provincia, :cp, :email, :telefono, '123456')");
        $stmt->bindParam(':dni', $tut["dni"]);
        $stmt->bindParam(':nombre', $tut["nombre"]);
        $stmt->bindParam(':apellidos', $tut["apellidos"]);
        $stmt->bindParam(':fechaNacimiento', $tut["fechaNacimiento"]);
        $stmt->bindParam(':direccion', $tut["direccion"]);
        $stmt->bindParam(':localidad', $tut["localidad"]);
        $stmt->bindParam(':provincia', $tut["provincia"]);
        $stmt->bindParam(':cp', $tut["cp"]);
        $stmt->bindParam(':email', $tut["email"]);
        $stmt->bindParam(':telefono', $tut["telefono"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function actualizarTutor($conexion, $tut) {
    try {
        $stmt = $conexion->prepare("CALL ACT_PERSONA(:dni, :nombre, :apellidos, :fechaNacimiento, :direccion, :localidad, :provincia, :cp, :email, :telefono, '123456')");
        $stmt->bindParam(':dni', $tut["dni"]);
        $stmt->bindParam(':nombre', $tut["nombre"]);
        $stmt->bindParam(':apellidos', $tut["apellidos"]);
        $stmt->bindParam(':fechaNacimiento', $tut["fechaNacimiento"]);
        $stmt->bindParam(':direccion', $tut["direccion"]);
        $stmt->bindParam(':localidad', $tut["localidad"]);
        $stmt->bindParam(':provincia', $tut["provincia"]);
        $stmt->bindParam(':cp', $tut["cp"]);
        $stmt->bindParam(':email', $tut["email"]);
        $stmt->bindParam(':telefono', $tut["telefono"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function eliminarTutor($conexion, $dni) {
    try {
        $consulta="CALL ELIMINAR_PERSONA(:dni)";
        $stmt= $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function validarAltaTutor($tutor){
    //validación del dni
    if($tutor["dni"]==""){
        $errores[] = "<p>El DNI debe completarse</p>";
    }else if(!preg_match("/^[0-9]{8}[A-Z]$/", $tutor["dni"])){
        $errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $tutor["dni"] . "</p>";
    }
    //validación del nombre
    if ($tutor["nombre"]=="") {
        $errores[] = "<p>El nombre debe completarse</p>";
    }
    //validación de apellidos
   if ($tutor["apellidos"]=="") {
        $errores[] = "<p>Los apellidos deben completarse</p>";
    }
    //validación de la fecha de nacimiento
    $fechaMin = date("Y/m/d", strtotime("now -18 year"));
    $fechaNac = formatFecha($tutor["fechaNacimiento"]);
	if ($tutor["fechaNacimiento"]=="") {
		$errores[] = "<p>La fecha de nacimiento debe completarse</p>";
	}elseif ($fechaNac > $fechaMin) {
        $errores[] = "<p>El tutor debe tener al menos 18 años</p>";
    }
    //validación del email
    if($tutor["email"]==""){ 
        $errores[] = "<p>El email debe completarse</p>";
    }else if(!filter_var($tutor["email"], FILTER_VALIDATE_EMAIL)){
        $tutor[] = "<p>El email es incorrecto: " . $tutor["email"]. "</p>";
    }
    //validación del número de teléfono
    if ($tutor["telefono"]=="") {
        $errores[] = "<p>El número de teléfono debe completarse</p>";
    }elseif (!preg_match("/^[0-9]{9}$/", $tutor["telefono"])) {
        $errores[] = "<p>El telefono debe contener 9 números: ". $tutor["telefono"] ."</p>";
    }
     //validación del código postal
    if (!preg_match("/^[0-9]{5}$/", $tutor["cp"])) {
        $errores[] = "<p>El código postal debe contener 5 números: ". $tutor["cp"] ."</p>";
    }
    return $errores;
}

?>