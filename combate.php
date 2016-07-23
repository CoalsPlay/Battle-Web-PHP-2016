<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header('location: '.$web['url'].'/404'); }

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
				  <div class="panel-body">

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
						    <img src="<?php echo $web['url']; ?>/img/iconos/shield.png"> Defensa: <?php echo $dato_u['defensa']; ?>
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
				  	<?php

				  		$sql = mysqli_query($conexion, "SELECT * FROM combates
				  										JOIN mobs ON combates.id_enemigo = mobs.id_mob 
				  										WHERE id_usuario = '$dato_u[id]' ");

				  		if(mysqli_num_rows($sql) == 1){
				  			$sql_m = mysqli_fetch_array($sql);

				  	?>
				  	<div class="col-md-4">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">Información de combate</div>
						  <div class="panel-body">
						  
						    <?php
						    if($dato_u['salud'] == 0 && $sql_m['hp_enemigo'] == 0){
						    	echo '<center><b>¡Ha acabado en empate!</b></center>
						  				<center>Más suerte para la próxima vez...</center><br/>
						  				<center>No has perdido nada, pero tampoco has ganado ninguna recompensa.</center><br/>
									  <form method="post" action="'.$_SERVER['PHP_SELF'].'">
						    		    <input name="finalizar_e" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
						    		  </form>';

						    	if(isset($_POST['finalizar_e'])){

						    		mysqli_query($conexion, "UPDATE usuarios 
						    								 SET salud = '0'
						    								 WHERE id = '$dato_u[id]' ");
						    		mysqli_query($conexion, "DELETE FROM combates WHERE id_combate = '$sql_m[id_combate]' ");
						    		header('location: '.$web['url'].'/');
						    	}

						    }elseif($sql_m['hp_enemigo'] == 0){
						    	echo '<center><b>¡Has ganado el combate!<br/>¡Felicidades!</b></center><br/>
						    	  	  <center>Recompensa<br/>
						    		  <div class="well well-sm">
								  		<img src="'.$web['url'].'/img/iconos/exp.png"> &nbsp;<b>+'.$sql_m['exp_mob'].'</b> de Experiencia<br/>
								  		<img src="'.$web['url'].'/img/iconos/coins.png"> &nbsp;<b>+'.$sql_m['oro_mob'].'</b> de Oro<br/>
								  		<img src="'.$web['url'].'/img/iconos/bullet_orange.png"> &nbsp;<b>+'.$sql_m['reputacion_mob'].'</b> Pts. de Reputación</center>
									  <br/>
									  <form method="post" action="'.$_SERVER['PHP_SELF'].'">
						    		    <input name="finalizar_v" type="submit" style="width:100%;" class="btn btn-success" value="Finalizar combate">
						    		  </form>';

						    	if(isset($_POST['finalizar_v'])){
						    		$sum_exp = $dato_u['exp'] + $sql_m['exp_mob'];
						    		$sum_oro = $dato_u['oro'] + $sql_m['oro_mob'];
						    		$sum_rep = $dato_u['reputacion'] + $sql_m['reputacion_mob'];
						    		$sum_kill = $dato_u['bajas'] + 1;

						    		mysqli_query($conexion, "UPDATE usuarios 
						    								 SET exp = '$sum_exp', oro = '$sum_oro', reputacion = '$sum_rep', bajas = '$sum_kill'
						    								 WHERE id = '$dato_u[id]' ");
						    		mysqli_query($conexion, "DELETE FROM combates WHERE id_combate = '$sql_m[id_combate]' ");
						    		header('location: '.$web['url'].'/');
						    	}

						    }elseif($dato_u['salud'] == 0){
						  		echo '<center><b>¡Has perdido!</b></center>
						  				<center>Más suerte para la próxima vez...</center><br/>
						  				<center>Has perdido:<br/>
						    		  <div class="well well-sm">
								  		<img src="'.$web['url'].'/img/iconos/coins.png"> &nbsp;<b><span class="text-danger">-'.$sql_m['oro_mob'].'</span></b> de Oro<br/>
								  		<img src="'.$web['url'].'/img/iconos/bullet_orange.png"> &nbsp;<b><span class="text-danger">-'.$sql_m['reputacion_mob'].'</span></b> Pts. de Reputación</center>
									  <br/>
									  <form method="post" action="'.$_SERVER['PHP_SELF'].'">
						    		    <input name="finalizar_d" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
						    		  </form>';

						    	if(isset($_POST['finalizar_d'])){
							  		$rest_reputacion = $dato_u['reputacion'] - $sql_m['reputacion_mob'];
							  		$rest_oro = $dato_u['oro'] - $sql_m['oro_mob'];
							  		$rest_kill = $dato_u['muertes'] + 1;

							  		mysqli_query($conexion, "UPDATE usuarios 
							  								 SET salud = '0', reputacion = '$rest_reputacion', oro = '$rest_oro', muertes = '$rest_kill'
							  								 WHERE id = '$dato_u[id]' ");
						    		mysqli_query($conexion, "DELETE FROM combates WHERE id_combate = '$sql_m[id_combate]' ");
						    		mysqli_query($conexion, "INSERT INTO cementerio (id_usuario_fallecido, id_enemigo_asesino)
						    								 VALUES ('".$dato_u['id']."','".$sql_m['id_mob']."') ");
						    		header('location: '.$web['url'].'/');
						    	}
						    }elseif(isset($_POST['atacar'])){						  			
						    	$r_hp = $dato_u['salud'] - $sql_m['ataque_mob'];
						    	$r_sp = $dato_u['energia'] - 5;
					  			$r_hp_m = $sql_m['hp_enemigo'] - $dato_u['ataque'];

					  			mysqli_query($conexion, "UPDATE usuarios SET salud='$r_hp', energia='$r_sp' WHERE id = '$dato_u[id]' ");
					  			mysqli_query($conexion, "UPDATE combates SET hp_enemigo = '$r_hp_m' WHERE id_combate = '$sql_m[id_combate]' ");
						  			
					  			echo "<meta http-equiv='refresh' content='2;combate'>";
					 			echo '<b>'.$dato_u['usuario'].'</b> infligió <b>'.$dato_u['ataque'].'</b> de daño.<br/>';
					 			echo '<b><span class="text-danger">'.$sql_m['nombre_mob'].'</span></b> infligió <b>'.$sql_m['ataque_mob'].'</b> de daño.';
						  	
						  	}elseif(isset($_POST['rendirme'])){

						  		mysqli_query($conexion, "UPDATE usuarios SET salud = '0' WHERE id = '$dato_u[id]' ");
						  		header('location: '.$web['url'].'/combate');

						  	}else{
						  		echo '<center><b>Esperando acción...</b></center>';
						  	}


					  		?>
						  </div>
						</div>
				  		<br/><br/><br/><br/><br/><br/>
				  		<center><h1>VS</h1></center>
				  	</div>

				  	<div class="col-md-4">
				  		<div class="well">
				  			<center><img width="130" height="150" src="<?php echo $web['url']; ?>/img/mobs/<?php echo $sql_m['img_mob']; ?>"></center>

				  			<hr>
						<ul class="list-group">
						  <li class="list-group-item text-center">
						    <b><?php echo $sql_m['nombre_mob']; ?></b>
						  </li>
						  <li class="list-group-item">
						  	<img src="<?php echo $web['url']; ?>/img/iconos/heart.png"> Salud: <b><span class="text-danger"><?php echo $sql_m['hp_enemigo']; ?></span></b>/<b><span class="text-danger"><?php echo $sql_m['max_hp_enemigo']; ?></span></b> HP
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-danger" title="200/200 HP" style="width:<?php echo porCiento($sql_m['hp_enemigo'], $sql_m['max_hp_enemigo']); ?>%;">
							  	<?php echo $sql_m['hp_enemigo']; ?>/<?php echo $sql_m['max_hp_enemigo']; ?> HP
							  </div>
							</div> 
						  </li>
						  <?php
						  	if($sql_m['hp_enemigo'] == 0 or $dato_u['salud'] == 0){
						  		echo NULL;
						  	}else{
						  ?>
						  <li class="list-group-item">
						  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						    	<input type="submit" name="atacar" style="width:100%;" class="btn btn-primary" value="Atacar">
						    </form>
						  </li>
						  <li class="list-group-item">
						  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						    	<input type="submit" name="rendirme" style="width:100%;" class="btn btn-danger" value="Rendirme">
						    </form>
						  </li>
						  <?php
						  	}
						  ?>
						</ul>
				  		</div>
				  	</div>
				  	<?php
				  		}else{
				  			header("Location: mapa");
				  		}
				  	?>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>