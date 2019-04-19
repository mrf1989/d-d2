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