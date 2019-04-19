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

?>