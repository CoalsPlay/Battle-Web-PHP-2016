<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Staff</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/icon_security.gif"> Staff de <?php echo $web['nombre']; ?></div>
				  <div class="panel-body">
				  	<div class="col-md-4">
						<div class="panel panel-danger">
						  <div class="panel-heading">
						    <h3 class="panel-title">Administradores</h3>
						  </div>
						  <div class="panel-body">
							<ul class="list-group">
								<?php 
									$comp_rango = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango = '1' ");

									if(mysqli_num_rows($comp_rango) == 0){
										echo '<li class="list-group-item text-center"><b>Sin administradores actualmente.</b></li>';
									}else{

										while($ext_rango = mysqli_fetch_array($comp_rango)){
									?> 
									<li class="list-group-item">
										<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_rango['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_rango['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_rango['usuario']; ?>"><?php echo $ext_rango['usuario']; ?></a>
									</li>
								<?php
										}
							  	  	}	
							   	?>
							</ul>
						  </div>
						</div>
				  	</div>
				  	<div class="col-md-4">
						<div class="panel panel-success">
						  <div class="panel-heading">
						    <h3 class="panel-title">Moderadores</h3>
						  </div>
						  <div class="panel-body">
							<ul class="list-group">
								<?php 

									$comp_rango = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango = 2");

									if(mysqli_num_rows($comp_rango) == 0){
										echo '<li class="list-group-item text-center"><b>Sin moderadores actualmente.</b></li>';
									}else{

										while($ext_rango = mysqli_fetch_array($comp_rango)){
									?> 
									<li class="list-group-item">
										<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_rango['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_rango['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_rango['usuario']; ?>"><?php echo $ext_rango['usuario']; ?></a>									</li>
									</li>
								<?php
										}
							  	  	}	
							   	?>
							</ul>
						  </div>
						</div>
				  	</div>
				  	<div class="col-md-4">
						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">Colaboradores</h3>
						  </div>
						  <div class="panel-body">
							<ul class="list-group">
								<?php 

									$comp_rango = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango=3");

									if(mysqli_num_rows($comp_rango) == 0){
										echo '<li class="list-group-item text-center"><b>Sin colaboradores actualmente.</b></li>';
									}else{

										while($ext_rango = mysqli_fetch_array($comp_rango)){
									?> 
									<li class="list-group-item">
										<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_rango['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_rango['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_rango['usuario']; ?>"><?php echo $ext_rango['usuario']; ?></a>									</li>
									</li>
								<?php
										}
							  	  	}	
							   	?>
							</ul>
						  </div>
						</div>
				  	</div>
				  </div>
				</div>

				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>