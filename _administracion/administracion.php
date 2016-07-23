<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Administración</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/posts.gif"> Administración - Inicio</div>
				  <div class="panel-body">
				  	<div class="col-md-4">
						<div class="panel panel-default">
						  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> Usuarios</div>
						  <div class="panel-body">
							<ul class="list-group">
							  <li class="list-group-item">
								Último usuario:
							  	<?php
							  		$query_u = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC");
							  		if(mysqli_num_rows($query_u) == 0){
							  			echo '<b¡>Sin usuarios.</b>';
							  		}else{
							  			if($llamar = mysqli_fetch_array($query_u)){
							  				echo '<b><a href="'.$web['url'].'/perfil/'.$llamar['usuario'].'">'.$llamar['usuario'].'</a></b>';
							  			}
							  		}
							  	?>
							 	 
							  </li>
							  <li class="list-group-item">
							    <span class="badge">
							    	<?php
							    		$query_cu = mysqli_query($conexion, "SELECT * FROM usuarios");
							    		if($num_u = mysqli_num_rows($query_cu)){
							    			echo $num_u;
							    		}
							    	?>
							    </span>
							    Número de registros
							  </li>
							  <li class="list-group-item">
							    <span class="badge">
							    	<?php
							    		$query_cu = mysqli_query($conexion, "SELECT * FROM usuarios WHERE online = '1' ");
							    		if($num_u = mysqli_num_rows($query_cu)){
							    			echo $num_u;
							    		}
							    	?>
							    </span>
							    Usuarios online
							  </li>
						  </div>
						</div>  		
					</div>

					<div class="col-md-4">
						<div class="panel panel-default">
						  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> Noticias</div>
						  <div class="panel-body">
							<ul class="list-group">
							  <li class="list-group-item">
							    <span class="badge">
							    	<?php
							    		$query_not = mysqli_query($conexion, "SELECT * FROM noticias");
							    		if($num_n = mysqli_num_rows($query_not)){
							    			echo $num_n;
							    		}
							    	?>
							    </span>
							    Nº de noticias
							  </li>
							  <li class="list-group-item">
							    <span class="badge">
							    	<?php
							    		$query_co = mysqli_query($conexion, "SELECT * FROM comentarios");
							    		if($num_co = mysqli_num_rows($query_co)){
							    			echo $num_co;
							    		}
							    	?>
							    </span>
							    Nº de comentarios
							  </li>
						  </div>
						</div>  		
					</div>

					<div class="col-md-4">
						<div class="panel panel-default">
						  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bomb.png"> Mobs</div>
						  <div class="panel-body">
							<ul class="list-group">
							  <li class="list-group-item">
							    <span class="badge">
							    	<?php
							    		$query_mob = mysqli_query($conexion, "SELECT * FROM mobs");
							    		if($num_mob = mysqli_num_rows($query_mob)){
							    			echo $num_mob;
							    		}
							    	?>
							    </span>
							    Nº de Mobs
							  </li>
							  <li class="list-group-item">
							    <span class="badge">
							    	0
							    </span>
							    Nº de Mobs asesinados
							  </li>
						  </div>
						</div>  		
					</div>

				  </div>
				</div>
				
			<?php include('../plantilla/box_changelog.php'); ?>				

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>