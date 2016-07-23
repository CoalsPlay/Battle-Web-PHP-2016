<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	$limite = 10;

	if(isset($_GET['mobs'])){
		$pag = $_GET['mobs'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

	if($dato_u['rango'] == 3){ header('location: '.$web['url'].'/_administracion/administracion'); }

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Administración - Gestor de Mobs</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bomb.png"> Administración - Gestor de Mobs</div>
				  <div class="panel-body">

				  	<?php
				  		$sql = mysqli_query($conexion, "SELECT * FROM mobs ORDER BY id_mob DESC LIMIT $inicio, $limite");

				  		if(mysqli_num_rows($sql) == 0){

				  			echo '<center><span class="text-default"><h2>No hay ningún mob agregado.</h2></span></center<br/><br/>';
				  		}else{

				  			while($row = mysqli_fetch_array($sql)){
				  	?>
					<div class="panel panel-default">
					  <div class="panel-body">
						<div class="media">
						  <div class="media-left">
						      <img class="media-object" width="80" src="<?php echo $web['url']; ?>/img/mobs/<?php echo $row['img_mob']; ?>" title="...">
						  </div>
						  <div class="media-body">
						    <h4 class="media-heading"><?php echo $row['nombre_mob']; ?></h4>
							<img src="<?php echo $web['url']; ?>/img/iconos/attack.png"> <b><?php echo $row['ataque_mob']; ?></b> - <!--<img src="<?php echo $web['url']; ?>/img/iconos/shield.png"> <b><?php echo $row['def_mob']; ?></b>--><img src="<?php echo $web['url']; ?>/img/iconos/heart.png"> <b><?php echo $row['max_salud_mob']; ?></b><br/>
							<img src="<?php echo $web['url']; ?>/img/iconos/book_open.png"> <span>Descripción: </span> <b><?php echo $row['descripcion_mob']; ?></b><br/>
							<!--<img src="<?php echo $web['url']; ?>/img/iconos/flag_blue.png"> <span>Frecuencia de aparición: </span> <b><?php echo $row['frecuencia_mob']; ?>%</b><br/><br/>-->
						  	<img src="<?php echo $web['url']; ?>/img/iconos/exp.png"> <span>Experiencia: </span> <b><?php echo $row['exp_mob']; ?></b><br/>
						  	<img src="<?php echo $web['url']; ?>/img/iconos/bullet_star.png"> <span>Reputación: </span> <b><?php echo $row['reputacion_mob']; ?></b><br/>
							<a href="<?php echo $web['url']; ?>/_administracion/administracion_editar_mob?id=<?php echo $row['id_mob']; ?>" class="btn btn-primary btn-xs">Editar</a>
						  </div>
						</div>
					  </div>
					</div>
				  	<?php
				  			}
				  		}

							$pag_not = mysqli_query($conexion, "SELECT count(id_mob) FROM mobs");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/_administracion/administracion_mobs?mobs='.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/_administracion/administracion_mobs?mobs='.$i.'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							}
				  	?>
				  	
					<a href="<?php echo $web['url']; ?>/_administracion/administracion_agregar_mob" style="width:100%;" class="btn btn-primary">Agregar Mob</a>
				  </div>
				</div>			

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>