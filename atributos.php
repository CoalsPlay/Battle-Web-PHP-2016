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
				
				<?php include('plantilla/box_stats.php'); ?>
				
				<?php include('plantilla/box_social.php'); ?>

			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/upgrade.png"> Puntos de atributos</div>
				  <div class="panel-body">
				  	<span style="font-size:14pt;">Actualmente dispones de <b><span class="text-danger">
				  		<?php
				  			if($dato_u['pts_atributos'] > 0){

				  				echo '<span class="text-success">'.$dato_u['pts_atributos'].'</span>';
				  			}else{
				  				echo '<span class="text-danger">'.$dato_u['pts_atributos'].'</span>';
				  			}
				  		?>
				  	</span></b> puntos de atributos.</span><br/><br/>

					<table class="table table-striped table-hover ">
					  <tbody>
					    <!--<tr>
					      <td><img src="<?php echo $web['url']; ?>/img/iconos/shield.png"></td>
					      <td>Defensa</td>
					      <td>Incrementa tu defensa en 3, para resistir más ante los golpes enemigos.</td>
					      <td>
					      <?php
					      		if(isset($_POST['def'])){
					      			if($dato_u['pts_atributos'] > 0){
						      			$rest_def = $dato_u['pts_atributos'] - 1;
						      			$sum_def = $dato_u['defensa'] + 3;
						      			mysqli_query($conexion, "UPDATE usuarios SET defensa = '$sum_def', pts_atributos = '$rest_def' WHERE id = '$dato_u[id]' ");
						      			
						      			echo '<b><span class="text-success">+3 de Defensa</span></b>';
						      			echo "<meta http-equiv='refresh' content='0.5;atributos'>";
					      			}
					      		}
					      ?>
					  	  </td>
					  	  <td>
					      <?php
					      	if($dato_u['pts_atributos'] > 0){

					      		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
										<button type="submit" name="def" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
					      			</form>';

					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge"><?php echo $dato_u['defensa']; ?></span></td>
					    </tr>-->
					    <tr>
					      <td><img src="<?php echo $web['url']; ?>/img/iconos/attack.png"></td>
					      <td>Ataque</td>
					      <td>Incrementa tu ataque en 3, para dar golpes más dañinos.</td>
					      <td>
					      <?php
					      		if(isset($_POST['ataque'])){
					      			if($dato_u['pts_atributos'] > 0){
						      			$rest_atk = $dato_u['pts_atributos'] - 1;
						      			$sum_atk = $dato_u['ataque'] + 3;
						      			mysqli_query($conexion, "UPDATE usuarios SET ataque = '$sum_atk', pts_atributos = '$rest_atk' WHERE id = '$dato_u[id]' ");
						      			
						      			echo '<b><span class="text-success">+3 de Ataque</span></b>';
						      			echo "<meta http-equiv='refresh' content='0.5;atributos'>";
					      			}
					      		}
					      ?>
					  	  </td>
					      <td>
					      <?php
					      	if($dato_u['pts_atributos'] > 0){

					      		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
										<button type="submit" name="ataque" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
					      			</form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge"><?php echo $dato_u['ataque']; ?></span></td>
					    </tr>
					    <tr>
					      <td><img src="<?php echo $web['url']; ?>/img/iconos/heart.png"></td>
					      <td>Salud</td>
					      <td>Aumenta tu salud máxima en 10, para disponer de más HP para los combates.</td>
						  <td>
					      <?php
					      		if(isset($_POST['salud'])){
					      			if($dato_u['pts_atributos'] > 0){
						      			$rest_hp = $dato_u['pts_atributos'] - 1;
						      			$sum_hp = $dato_u['max_salud'] + 10;
						      			mysqli_query($conexion, "UPDATE usuarios SET max_salud = '$sum_hp', pts_atributos = '$rest_hp' WHERE id = '$dato_u[id]' ");
						      			
						      			echo '<b><span class="text-success">+10 HP</span></b>';
						      			echo "<meta http-equiv='refresh' content='0.5;atributos'>";
					      			}
					      		}
					      ?>
					  	  </td>
					      <td>
					      <?php
					      	if($dato_u['pts_atributos'] > 0){

					      		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
										<button type="submit" name="salud" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
					      			</form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge"><?php echo $dato_u['max_salud']; ?></span></td>
					    </tr>
					    <tr>
					      <td><img src="<?php echo $web['url']; ?>/img/iconos/energia.png"></td>
					      <td>Energía</td>
					      <td>Aumenta tu energía en 5, para poder combatir durante más tiempo sin cansarte.</td>
					      <td>
					      <?php
					      		if(isset($_POST['energia'])){
					      			if($dato_u['pts_atributos'] > 0){					      			
						      			$rest_sp = $dato_u['pts_atributos'] - 1;
						      			$sum_sp = $dato_u['max_energia'] + 5;
						      			mysqli_query($conexion, "UPDATE usuarios SET max_energia = '$sum_sp', pts_atributos = '$rest_sp' WHERE id = '$dato_u[id]' ");
						      			
						      			echo '<b><span class="text-success">+5 de Energía</span></b>';
						      			echo "<meta http-equiv='refresh' content='0.5;atributos'>";
					      			}
					      		}
					      ?>
					  	  </td>
					      <td>
					      <?php
					      	if($dato_u['pts_atributos'] > 0){

					      		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">
										<button type="submit" name="energia" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
					      			</form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge"><?php echo $dato_u['max_energia']; ?></span></td>
					    </tr>
					  </tbody>
					</table> 
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>