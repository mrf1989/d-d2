<?php
// retorna la fecha apta para usar en un input[type=date], 2001-02-01
function getFechaForm($fecha){
	$fechaNacimiento = date('Y-d-m', strtotime($fecha));
	return $fechaNacimiento;
}
// retorna la fecha pata para ser usada en Oracle SQL, 01/02/2001
function getFechaBD($fecha) {
	$fechaNacimiento = date('d/m/Y', strtotime($fecha));
	return $fechaNacimiento;
}

?>