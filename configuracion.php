<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/registro"); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Opciones y configuraciones</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_confi.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<?php
					$sql_ext_datos = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$_SESSION[login]' ");
					$sql_datos = mysqli_fetch_array($sql_ext_datos);
				?>
				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Opciones y Configuraciones</div>
				  <div class="panel-body">
					<ul class="list-group">
					  <li class="list-group-item">
					    <span class="text-primary">Usuario:</span>&nbsp;&nbsp; <b><?php echo $dato_u['usuario']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Email:</span>&nbsp;&nbsp; <b><?php echo $sql_datos['email']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Fecha de registro:</span>&nbsp;&nbsp; <b><?php echo $sql_datos['fecha_registro']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">IP:</span>&nbsp;&nbsp; <b><?php echo $sql_datos['ip']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Rango:</span>&nbsp;&nbsp; 
							<?php 
								if($sql_datos['rango'] == 1){
									echo ' <span class="label label-danger">Administrador</span>'; 
								}elseif($sql_datos['rango'] == 2){
									echo ' <span class="label label-success">Moderador</span>';
								}elseif($sql_datos['rango'] == 3){
									echo ' <span class="label label-primary">Colaborador</span>';
								}elseif($sql_datos['rango'] == 0){
									echo ' <span class="label label-default">Normal</span>';
								} 
							?>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Estado de la cuenta:</span>&nbsp;&nbsp; <b><?php if($sql_datos['estado'] == 1){ echo '<span class="text-success">OK</span>'; } ?></b>
					  </li>
					</ul>
				  </div>
				</div>
		

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>