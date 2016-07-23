<?php
	##############################################
	#/											/#
	#/		Desarrollado por CoalsPlay			/#
	#/		Todos los derechos reservados		/#
	#/		Sitio: www.coalsplay.com			/#
	#/											/#
	##############################################

	$mysql['host'] = 'localhost';
	$mysql['user'] = 'root';
	$mysql['pass'] = '';
	$mysql['db'] = 'sodbd';
		
	$conexion = mysqli_connect($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['db']);

	if (mysqli_connect_errno()){
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
	}

	## Extracción de datos ##
	if(isset($_SESSION['login'])){
		$result_u = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='".$_SESSION['login']."' ");
		$dato_u = mysqli_fetch_array($result_u);
	}

	$result_su = mysqli_query($conexion, "SELECT * FROM usuarios");
	$dato_su = mysqli_fetch_array($result_su);

	## Información de la web ##

	$cons_con = mysqli_query($conexion, "SELECT * FROM configuraciones");
	$config = mysqli_fetch_array($cons_con);
	
	$web['url'] = $config['url_web'];
	$web['nombre'] = $config['nombre_web'];
	$web['descripcion'] = $config['descripcion_web'];
	$web['mantenimiento'] = $config['mantenimiento'];

	## Configuración  del juego ##

	$game['max_lvl'] = $config['nivel_maximo'];
	$game['int_exp'] = $config['intervalo_exp'];
	$game['pts_atr_lvl'] = $config['pts_atributos_lvl'];
	$game['pre_cem'] = $config['precio_cementerio'];
	$game['num_top'] = $config['num_top'];
	$game['int_lvl'] = $config['int_lvl'];

?>