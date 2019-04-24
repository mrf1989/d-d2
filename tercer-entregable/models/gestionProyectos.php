<?php

function getAllProyectos() {
    $query = "SELECT DISTINCT OID_PROJ, P_NOMBRE, UBICACION, ESEVENTO, ESPROGDEP FROM (SELECT P.NOMBRE AS P_NOMBRE, A.NOMBRE AS A_NOMBRE, A.FECHAINICIO, P.OID_PROJ, P.UBICACION, P.ESEVENTO, P.ESPROGDEP FROM PROYECTOS P LEFT JOIN ACTIVIDADES A ON P.OID_Proj=A.OID_Proj ORDER BY A.fechainicio ASC)";
    return $query;
}

function getProyecto($conexion, $oid_proj) {
    try {
        $consulta = "SELECT * FROM PROYECTOS WHERE OID_PROJ =:oid_proj";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_proj', $oid_proj);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getActividades($conexion, $oid_proj) {
    try {
        $consulta = "SELECT * FROM ACTIVIDADES WHERE OID_PROJ =:oid_proj ORDER BY fechainicio ASC";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_proj', $oid_proj);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOExcepction $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function insertarProyecto($conexion, $nuevoProyecto) {
    try {
        $stmt = $conexion->prepare("CALL REGISTRAR_PROYECTO(:dni, :nombre, :ubicacion, :esevento, :esprogdep)");
        $stmt->bindParam(':dni', $nuevoProyecto["coordinador"]);
        $stmt->bindParam(':nombre', $nuevoProyecto["nombre"]);
        $stmt->bindParam(':ubicacion', $nuevoProyecto["ubicacion"]);
        $stmt->bindParam(':esevento', $nuevoProyecto["esevento"]);
        $stmt->bindParam(':esprogdep', $nuevoProyecto["esprogdep"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function eliminarProyecto($conexion, $oid_proj) {
    try {
        $stmt = $conexion->prepare("CALL ELIMINAR_PROYECTO(:oid_proj)");
        $stmt->bindParam(':oid_proj', $oid_proj);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function actualizarProyecto($conexion, $proyecto) {
    try {
        $stmt = $conexion->prepare("CALL ACT_PROYECTO(:oid_proj, :nombre, :ubicacion, :esevento, :esprogdep)");
        $stmt->bindParam(':oid_proj', $proyecto["oid_proj"]);
        $stmt->bindParam(':nombre', $proyecto["nombre"]);
        $stmt->bindParam(':ubicacion', $proyecto["ubicacion"]);
        $stmt->bindParam(':esevento', $proyecto["esevento"]);
        $stmt->bindParam(':esprogdep', $proyecto["esprogdep"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function insertarActividad($conexion, $nuevaActividad) {
    try {
        $stmt = $conexion->prepare("CALL ADD_ACTIVIDAD(:nombre, :objetivo, :fechainicio, :fechafin, :numeroplazas, :tipo, :costetotal, :oid_proj)");
        $stmt->bindParam(':nombre', $nuevaActividad["nombre"]);
        $stmt->bindParam(':objetivo', $nuevaActividad["objetivo"]);
        $stmt->bindParam(':fechainicio', $nuevaActividad["fechainicio"]);
        $stmt->bindParam(':fechafin', $nuevaActividad["fechafin"]);
        $stmt->bindParam(':numeroplazas', $nuevaActividad["numeroplazas"]);
        $stmt->bindParam(':tipo', $nuevaActividad["tipo"]);
        $stmt->bindParam(':costetotal', $nuevaActividad["costetotal"]);
        $stmt->bindParam(':oid_proj', $nuevaActividad["oid_proj"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function eliminarActividad($conexion, $oid_act) {
    try {
        $query = "DELETE FROM ACTIVIDADES WHERE OID_ACT =:oid_act";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function actualizarActividad($conexion, $actividad) {
    try {
        $stmt = $conexion->prepare("CALL ACT_ACTIVIDAD(:oid_act, :nombre, :objetivo, :fechainicio, :fechafin, :numeroplazas, :tipo, :costetotal)");
        $stmt->bindParam(':oid_act', $actividad["oid_act"]);
        $stmt->bindParam(':nombre', $actividad["nombre"]);
        $stmt->bindParam(':objetivo', $actividad["objetivo"]);
        $stmt->bindParam(':fechainicio', $actividad["fechainicio"]);
        $stmt->bindParam(':fechafin', $actividad["fechafin"]);
        $stmt->bindParam(':numeroplazas', $actividad["numeroplazas"]);
        $stmt->bindParam(':tipo', $actividad["tipo"]);
        $stmt->bindParam(':costetotal', $actividad["costetotal"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

?>