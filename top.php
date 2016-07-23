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
		<title><?php echo $web['nombre']; ?> - TOP <?php echo $game['num_top']; ?></title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> TOP <?php echo $game['num_top']; ?> - <?php echo $web['nombre']; ?></div>
				  <div class="panel-body">
				  	<div class="row">
				  		<div class="col-md-4">
							<div class="panel panel-default">
							  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/coins.png"> TOP <?php echo $game['num_top']; ?> con más Oro</div>
							  <div class="panel-body">
								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Oro</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		$sql1 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='0' ORDER BY oro DESC LIMIT $game[num_top] ");
								  		$i = 0;
								  		while($row = mysqli_fetch_assoc($sql1)){
								  			$i++;
								  	?>

								    <tr>
								      <td><?php echo $i; ?></td>
								      <td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
								      <td><?php echo $row['oro']; ?></td>
								    </tr>

								  	<?php
								  		}
								  	?>
								  </tbody>
								</table>
							  </div>
							</div>

							<div class="panel panel-default">
							  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/rosette.png"> TOP <?php echo $game['num_top']; ?> con más Nivel</div>
							  <div class="panel-body">
								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Nivel</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		$sql2 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='0' ORDER BY nivel DESC LIMIT $game[num_top] ");
								  		$i = 0;
								  		while($row = mysqli_fetch_assoc($sql2)){
								  			$i++;
								  	?>

								    <tr>
								      <td><?php echo $i; ?></td>
								      <td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
								      <td><?php echo $row['nivel']; ?></td>
								    </tr>

								  	<?php
								  		}
								  	?>
								  </tbody>
								</table>
							  </div>
							</div>
				  		</div>
				  		<div class="col-md-4">
							<div class="panel panel-default">
							  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bullet_star.png"> TOP <?php echo $game['num_top']; ?> con más Reputación</div>
							  <div class="panel-body">
								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Reputación</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		$sql3 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='0' ORDER BY reputacion DESC LIMIT $game[num_top] ");
								  		$i = 0;
								  		while($row = mysqli_fetch_assoc($sql3)){
								  			$i++;
								  	?>

								    <tr>
								      <td><?php echo $i; ?></td>
								      <td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
								      <td><?php echo $row['reputacion']; ?></td>
								    </tr>

								  	<?php
								  		}
								  	?>
								  </tbody>
								</table>
							  </div>
							</div>
				  		</div>
				  		<div class="col-md-4">
							<div class="panel panel-default">
							  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/objetive.png"> TOP <?php echo $game['num_top']; ?> con más Bajas</div>
							  <div class="panel-body">
								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Bajas</th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		$sql4 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='0' ORDER BY bajas DESC LIMIT $game[num_top] ");
								  		$i = 0;
								  		while($row = mysqli_fetch_assoc($sql4)){
								  			$i++;
								  	?>

								    <tr>
								      <td><?php echo $i; ?></td>
								      <td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
								      <td><?php echo $row['bajas']; ?></td>
								    </tr>

								  	<?php
								  		}
								  	?>
								  </tbody>
								</table>
							  </div>
							</div>
				  		</div>
				  	</div>
				  </div>
				</div>

				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>