<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Inicio</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
				<?php include('plantilla/box_stats.php'); ?>
				
				<?php include('plantilla/box_social.php'); ?>

			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/error.png"> Mantenimiento</div>
				  <div class="panel-body">
				  	<center><h2>Mantenimiento</h2></center><br/>
				  	<center><h4>Actualmente estamos en mantenimiento para mejorar el sitio web, vuelva en un rato.<br/> Gracias por su paciencia.</h4></center>
				  	<center>Mientras tanto te ofrecemos algunos links de interés acerca del sitio.</center>
				  	<center><h3><a href="<?php echo $web['url']; ?>/faq">FAQ</a> - <a href="https://twitter.com/CoalsPlay">Nuestro Twitter @CoalsPlay</a></h3></center>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>