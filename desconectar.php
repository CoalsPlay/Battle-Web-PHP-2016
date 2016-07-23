<?php
	session_start();
		
	require('conexion/conexion.php');
		
	mysqli_query($conexion, "UPDATE usuarios SET online = '0' WHERE id = '$dato_u[id]' ");
	session_destroy();
	header('location: '.$web['url'].'/');
?>
