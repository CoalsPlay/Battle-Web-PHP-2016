<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - 404 Error</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/posts.gif"> Noticias de Shadow Of Destiny</div>
				  <div class="panel-body">
				  	<center><img src="<?php echo $web['url']; ?>/img/iconos/error.png"> <h1>Error <b>404</b></h1><br/> <h3>La página que ha solicitado no existe o no tiene los permisos requeridos para acceder a ella.<br/><br/>
						<a href="javascript:history.back(1)">Volver atrás</a></center>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>