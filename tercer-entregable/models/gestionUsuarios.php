<?php

function consultarCredenciales($conexion, $dni, $pass) {
    try {
		$consulta = "SELECT COUNT(*) FROM PERSONAS WHERE DNI=:dni AND PASS=:pass";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':dni', $dni);
		$stmt->bindParam(':pass', $pass);
		$stmt->execute();
		return $stmt->fetchColumn();
	} catch(PDOException $e) {
		return 0;
	}
}

function consultarPermisos($conexion, $dni) {
    try {
        $consulta = "SELECT COUNT(*) FROM COORDINADORES WHERE DNI=:dni";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function consultarUserTipoPart($conexion, $dni) {
    try {
        $consulta = "SELECT COUNT(*) FROM PARTICIPANTES WHERE DNI=:dni";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function getOidPart($conexion, $dni) {
    try {
        $consulta = "SELECT OID_PART FROM PARTICIPANTES WHERE DNI=:dni";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        return 0;
    }
}

function getOidVol($conexion, $dni) {
    try {
        $consulta = "SELECT OID_VOL FROM VOLUNTARIOS WHERE DNI=:dni";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        return 0;
    }
}

?>