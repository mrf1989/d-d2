<?php

function getProximasActividades($conexion) {
    try {
        $consulta = "SELECT NOMBRE, PROJ_LUGAR, FECHAINICIO, OID_ACT FROM (SELECT P.nombre AS Proj_nombre, P.ubicacion AS Proj_lugar, A.* FROM PROYECTOS P LEFT JOIN ACTIVIDADES A ON P.OID_Proj=A.OID_Proj WHERE A.fechainicio >= (SYSDATE + 5) ORDER BY A.fechainicio ASC) WHERE ROWNUM <= 5";
        $stmt = $conexion->query($consulta);
        return $stmt;
    } catch (PDOException $e) {
        return 0;
    }
}

function getActividad($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM ACTIVIDADES WHERE OID_ACT =:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getInscripciones($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM PERSONAS P JOIN PARTICIPANTES PART ON P.dni=PART.dni JOIN INSCRIPCIONES INS ON PART.OID_Part=INS.OID_Part WHERE INS.OID_Act=:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getColaboraciones($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM PERSONAS P JOIN VOLUNTARIOS VOL ON P.dni=VOL.dni JOIN COLABORACIONES COLAB ON VOL.OID_Vol=COLAB.OID_Vol WHERE COLAB.OID_Act=:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getPatrocinios($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM INSTITUCIONES INS JOIN PATROCINIOS FIN ON INS.cif=FIN.cif WHERE OID_Act=:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function inscribirParticipante($conexion, $inscripcion) {
    try {
        $stmt = $conexion->prepare("CALL INSCRIBIR_PARTICIPANTE(:dni, :oid_act)");
        $stmt->bindParam(':dni', $inscripcion["dni"]);
        $stmt->bindParam(':oid_act', $inscripcion["oid_act"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../execepion.php");
    }
}

function inscribirVoluntario($conexion, $inscripcion) {
    try {
        $stmt = $conexion->prepare("CALL INSCRIBIR_VOLUNTARIO(:dni, :oid_act)");
        $stmt->bindParam(':dni', $inscripcion["dni"]);
        $stmt->bindParam(':oid_act', $inscripcion["oid_act"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../execepion.php");
    }
}

?>