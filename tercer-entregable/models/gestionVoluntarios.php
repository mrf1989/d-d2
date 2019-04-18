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