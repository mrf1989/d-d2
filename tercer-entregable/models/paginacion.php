<?php

function consultaPaginada($conexion, $query, $pag_num, $pag_size) {
	try {
		$primera = ($pag_num - 1) * $pag_size + 1;
		$ultima  = $pag_num * $pag_size;
		$consulta_paginada = 
			 "SELECT * FROM ( "
				."SELECT ROWNUM RNUM, AUX.* FROM ( $query ) AUX "
				."WHERE ROWNUM <= :ultima"
			.") "
			."WHERE RNUM >= :primera";

		$stmt = $conexion->prepare($consulta_paginada);
		$stmt->bindParam(':primera', $primera);
		$stmt->bindParam(':ultima', $ultima);
		$stmt->execute();
		return $stmt;
	}	
	catch (PDOException $e) {
		$_SESSION["excepcion"] = $e->GetMessage();
		Header("Location: ../excepcion.php");
	}
} 

function sizeConsulta($conexion, $query) {
	try {
		$total_consulta = "SELECT COUNT(*) AS TOTAL FROM ($query)";

		$stmt = $conexion->query($total_consulta);
		$result = $stmt->fetch();
		$total = $result["TOTAL"];
		return $total;
	}
	catch (PDOException $e) {
		$_SESSION["excepcion"] = $e->GetMessage();
		header("Location: ../excepcion.php");
	}
}

?>