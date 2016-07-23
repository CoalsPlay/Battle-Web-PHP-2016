<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header('location: '.$web['url'].'/404'); }

	$sql_comp = mysqli_query($conexion, "SELECT * FROM mobs");
	if(mysqli_num_rows($sql_comp) == 0){
  		echo '<script>alert("No hay ningún mob implementado.");</script>';
  		header('location: '.$web['url'].'/mapa');
	}

	$sql_comp2 = mysqli_query($conexion, "SELECT * FROM combates WHERE id_usuario = '$dato_u[id]' ");
	if(mysqli_num_rows($sql_comp2) == 1){
		header('location: '.$web['url'].'/combate');
	}
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/attack.png"> Combate</div>
				  <div class="panel-body" style="background:url('img/SF_Dirt.png') no-repeat;">

				  	<div class="col-md-4">
				  		<div class="well">
				  			<center><img width="150" height="150" src="<?php if($dato_u['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $dato_u['avatar']; } ?>"></center>

				  			<hr>
						<ul class="list-group">
						  <li class="list-group-item text-center">
						    <b><?php echo $dato_u['usuario']; ?></b>
						  </li>
						  <li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/rosette.png"> Nivel: <b><?php echo $dato_u['nivel']; ?></b>
						  </li>
						  <!--<li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/shield.png"> Defensa: <b><?php echo $dato_u['defensa']; ?></b>
						  </li>-->
						  <li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/attack.png"> Ataque: <b><?php echo $dato_u['ataque']; ?></b>
						  </li>
						  <li class="list-group-item">
						  	<img src="<?php echo $web['url']; ?>/img/iconos/heart.png"> Salud: <b><span class="text-danger"><?php echo $dato_u['salud']; ?></span></b>/<b><span class="text-danger"><?php echo $dato_u['max_salud']; ?></span></b> HP
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-danger " title="<?php echo $dato_u['salud']; ?>/<?php echo $dato_u['max_salud']; ?> HP" style="width:<?php echo porCiento($dato_u['salud'], $dato_u['max_salud']); ?>%;">
							  	<?php echo $dato_u['salud']; ?>/<?php echo $dato_u['max_salud']; ?> HP
							  </div>
							</div> 
						  </li>
						  <li class="list-group-item">
						  	<img src="<?php echo $web['url']; ?>/img/iconos/energia.png"> Energia: <b><span class="text-primary"><?php echo $dato_u['energia']; ?></span></b>/<b><span class="text-primary"><?php echo $dato_u['max_energia']; ?></span></b>
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-primary " title="<?php echo $dato_u['energia']; ?>/<?php echo $dato_u['max_energia']; ?> de Energía" style="width:<?php echo porCiento($dato_u['energia'], $dato_u['max_energia']); ?>%;">
							     <?php echo $dato_u['energia']; ?>/<?php echo $dato_u['max_energia']; ?> SP
							  </div>
							</div>
						  </li>
						</ul>
				  		</div>
				  	</div>

				  	<div class="col-md-4">
				  		<br/><br/><br/><br/><br/><br/><br/><br/>
				  		<center><h1>VS</h1></center>
				  	</div>
				  	<div class="col-md-4">
				  	<?php
				  		$sql_ran = mysqli_query($conexion, "SELECT * FROM mobs ORDER BY rand() LIMIT 1 ");
				  		$sql_ms = mysqli_fetch_array($sql_ran);
			

								if($dato_u['salud'] == 0 && $dato_u['energia'] < 5){
									echo '<script> function restringir(){ alert("No tienes salud ni energía para poder combatir."); }</script>';
								}elseif($dato_u['salud'] == 0){
						  			echo '<script> function restringir(){ alert("No tienes salud para poder combatir."); }</script>';
						  		}elseif($dato_u['energia'] < 5){
						  			echo '<script> function restringir(){ alert("No tienes energía suficiente para poder combatir."); }</script>';
						  		}else{
							  		if(isset($_POST['combatir'])){
							  			$id_u = $dato_u['id'];
							  			$id_m = $_POST['id_mob'];
							  			$hp_m = $_POST['hp_mob'];
							  			$max_hp_m = $_POST['max_hp_mob'];
							  			$atk_m = $_POST['atk_mob'];
							  			$def_m = $_POST['def_mob'];

							  			$rest_e = $dato_u['energia'] - 5;
							  			mysqli_query($conexion, "UPDATE usuarios SET energia = '$rest_e' WHERE id = '$dato_u[id]' ");

							  			mysqli_query($conexion, "INSERT INTO 
							  					combates (id_usuario, id_enemigo, hp_enemigo, max_hp_enemigo, atk_enemigo, def_enemigo, tiempo)
							  					VALUES('$id_u','$id_m','$hp_m','$max_hp_m','$atk_m', '$def_m', '".time()."') ");

							  			header('location: '.$web['url'].'/combate');
							  		}						  			
						  		}

						  		if(isset($_POST['huir'])){
						  			$calc = $dato_u['energia'] - 5;
						  			mysqli_query($conexion, "UPDATE usuarios SET energia='$calc' WHERE id='$dato_u[id]' ");
						  			header('location: '.$web['url'].'/accion');
						  		}
						  	?>
				  		<div class="well">
				  			<center><img width="130" height="150" src="<?php echo $web['url']; ?>/img/mobs/<?php echo $sql_ms['img_mob']; ?>"></center>

				  			<hr>
						<ul class="list-group">
						  <li class="list-group-item text-center">
						    <b><?php echo $sql_ms['nombre_mob']; ?></b>
						  </li>
						  <li class="list-group-item">
						  	<img src="<?php echo $web['url']; ?>/img/iconos/heart.png"> Salud: <b><span class="text-danger"><?php echo $sql_ms['salud_mob']; ?></span></b>/<b><span class="text-danger"><?php echo $sql_ms['max_salud_mob']; ?></span></b> HP
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-danger " title="<?php echo $sql_ms['salud_mob']; ?>/<?php echo $dato_u['max_salud']; ?> HP" style="width:<?php echo porCiento($sql_ms['salud_mob'], $sql_ms['max_salud_mob']); ?>%;">
							  	<?php echo $sql_ms['salud_mob']; ?>/<?php echo $sql_ms['max_salud_mob']; ?> HP
							  </div>
							</div> 
						  </li>
							  <li class="list-group-item">
							  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							  		<input type="hidden" name="id_mob" value="<?php echo $sql_ms['id_mob']; ?>">
							  		<input type="hidden" name="hp_mob" value="<?php echo $sql_ms['salud_mob']; ?>">
							  		<input type="hidden" name="max_hp_mob" value="<?php echo $sql_ms['max_salud_mob']; ?>">
							  		<input type="hidden" name="atk_mob" value="<?php echo $sql_ms['ataque_mob']; ?>">
							  		<input type="hidden" name="def_mob" value="<?php echo $sql_ms['def_mob']; ?>">
							    	<input type="submit" onClick="restringir()" name="combatir" style="width:100%;" class="btn btn-primary" value="Combatir">
							    </form>
							  </li>
						  <li class="list-group-item">
						  	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						    	<input type="submit" name="huir" style="width:100%;" class="btn btn-danger" value="Huir">
						  	</form>
						  </li>
						</ul>
				  		</div>
				  	</div>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>