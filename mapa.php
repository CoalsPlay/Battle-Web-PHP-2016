<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
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
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/map.png"> Mapa</div>
				  <div class="panel-body">
					<?php
						$sql_comp = mysqli_query($conexion, "SELECT * FROM mobs");
					  	if(mysqli_num_rows($sql_comp) == 0){
					  		echo "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
									No hay ningún Mob implementado por lo que no podrá combatir actualmente.</div>";
					  	}
					?>
					<ul class="nav nav-tabs">
					  <li class="active"><a href="#mundo1" data-toggle="tab" aria-expanded="true"><img src="<?php echo $web['url']; ?>/img/iconos/lock_open.png"> Mundo 1</a></li>
					  <li class="disabled"><a><img src="<?php echo $web['url']; ?>/img/iconos/lock.png"> Próximamente</a></li>
					  <li class="disabled"><a><img src="<?php echo $web['url']; ?>/img/iconos/lock.png"> Próximamente</a></li>
					  <li class="disabled"><a><img src="<?php echo $web['url']; ?>/img/iconos/lock.png"> Próximamente</a></li>
					  <li class="disabled"><a><img src="<?php echo $web['url']; ?>/img/iconos/lock.png"> Próximamente</a></li>
					  <li class="disabled"><a><img src="<?php echo $web['url']; ?>/img/iconos/lock.png"> Próximamente</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
					  <div class="tab-pane fade active in" id="mundo1"><br/>
					   <div class="hidden-xs">
					   	<center><a href="<?php echo $web['url']; ?>/accion"><img width="700" src="<?php echo $web['url']; ?>/img/map1.jpg"></a></center>
					   </div>
					   <div class="hidden-lg hidden-sm">
					   	<center><a href="<?php echo $web['url']; ?>/accion"><img width="300" src="<?php echo $web['url']; ?>/img/map1.jpg"></a></center>
					   </div>
					  </div>
					  <div class="tab-pane fade in" id="mundo2">

					  </div>
					  <div class="tab-pane fade in" id="mundo3">

					  </div>
					  <div class="tab-pane fade in" id="mundo4">

					  </div>
					  <div class="tab-pane fade in" id="mundo5">

					  </div>
					  <div class="tab-pane fade in" id="mundo6">

					  </div>
					</div>
				  </div>
				</div>
		
				<?php include('plantilla/box_onlines.php'); ?>

			</div>
			
		</div>

		<?php include('plantilla/footer.php'); ?>