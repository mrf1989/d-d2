<?php

function consultarUsuario($conexion, $dni, $pass) {
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

function consultarTipoUsuario($conexion, $dni) {
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

?>