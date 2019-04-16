<?php

function getProximasActividades($conexion) {
    try {
        $consulta = "SELECT P.nombre AS Proj_nombre, P.ubicacion AS Proj_lugar, A.* FROM PROYECTOS P LEFT JOIN ACTIVIDADES A ON P.OID_Proj=A.OID_Proj WHERE A.fechainicio >= (SYSDATE + 15) AND ROWNUM <= 5 ORDER BY A.fechainicio ASC";
        $stmt = $conexion->query($consulta);
        return $stmt;
    } catch (PDOException $e) {
        return 0;
    }
}

?>