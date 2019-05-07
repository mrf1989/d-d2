<?php

function getInteresesPart($conexion, $oid_part) {
    try {
        $consulta = "SELECT ACT.*, EST.*, PROJ.UBICACION FROM ESTAINTERESADOEN EST LEFT JOIN ACTIVIDADES ACT ON EST.OID_ACT=ACT.OID_ACT LEFT JOIN PROYECTOS PROJ ON ACT.OID_PROJ=PROJ.OID_PROJ WHERE OID_PART=:oid_part AND ACT.FECHAINICIO >= (SYSDATE+15) ORDER BY ACT.FECHAINICIO ASC";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_part', $oid_part);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

function getInteresesVol($conexion, $oid_vol) {
    try {
        $consulta = "SELECT ACT.*, EST.*, PROJ.UBICACION FROM ESTAINTERESADOEN EST LEFT JOIN ACTIVIDADES ACT ON EST.OID_ACT=ACT.OID_ACT LEFT JOIN PROYECTOS PROJ ON ACT.OID_PROJ=PROJ.OID_PROJ WHERE OID_VOL=:oid_vol AND ACT.FECHAINICIO >= (SYSDATE+15) ORDER BY ACT.FECHAINICIO ASC";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_vol', $oid_vol);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

function actualizarInteresPart($conexion, $interes) {
    try {
        $stmt = $conexion->prepare("CALL ACT_INTERESPARTICIPANTE(:dni, :oid_act, :estado)");
        $stmt->bindParam(':dni', $interes["dni"]);
        $stmt->bindParam(':oid_act', $interes["oid_act"]);
        $stmt->bindParam(':estado', $interes["estado"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

function actualizarInteresVol($conexion, $interes) {
    try {
        $stmt = $conexion->prepare("CALL ACT_INTERESVOLUNTARIADO(:dni, :oid_act, :estado)");
        $stmt->bindParam(':dni', $interes["dni"]);
        $stmt->bindParam(':oid_act', $interes["oid_act"]);
        $stmt->bindParam(':estado', $interes["estado"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

?>