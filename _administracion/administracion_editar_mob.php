<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 3){ header('location: '.$web['url'].'/_administracion/administracion'); }

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Administración - Agregar Mob</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bomb.png"> Administración - Agregar Mob</div>
				  <div class="panel-body">
				  	<?php

				  		if(isset($_GET['id'])){
				  			$id = $_GET['id'];
				  			$sql = mysqli_query($conexion, "SELECT * FROM mobs WHERE id_mob = '$id' ");
				  			$row = mysqli_fetch_array($sql);

					  		if(isset($_POST['edit_mob'])){
					  			$nombre_mob = proteccion($_POST['nombre_mob']);
					  			$ataque_mob = proteccion($_POST['ataque_mob']);
					  			$defensa_mob = proteccion($_POST['defensa_mob']);
					  			$max_salud_mob = proteccion($_POST['max_salud_mob']);
					  			// $frecuencia_mob = proteccion($_POST['frecuencia_mob']);
					  			$oro_mob = proteccion($_POST['oro_mob']);
					  			$exp_mob = proteccion($_POST['exp_mob']);
					  			$reputacion_mob = proteccion($_POST['reputacion_mob']);
					  			$descripcion_mob = proteccion($_POST['descripcion_mob']);
					  			$img_mob = proteccion($_POST['img_mob']);


					  			mysqli_query($conexion, "UPDATE mobs
					  									 SET nombre_mob = '$nombre_mob', ataque_mob = '$ataque_mob', def_mob = '$defensa_mob', salud_mob = '$max_salud_mob', max_salud_mob = '$max_salud_mob', oro_mob = '$oro_mob', exp_mob = '$exp_mob', reputacion_mob = '$reputacion_mob', descripcion_mob = '$descripcion_mob', img_mob = '$img_mob' 
					  									 WHERE id_mob = '$id' ");
					  			echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
										Mob editado correctamente.</div><meta http-equiv='refresh' content='1; ".$web['url']."/_administracion/administracion_mobs'>";
					  		}

					  			if(isset($_POST['borrar_mob'])){
					  				if(mysqli_query($conexion, "DELETE FROM mobs WHERE id_mob = '$id' ")){
					  					header('location: '.$web['url'].'administracion_mobs');
					  				}else{
										echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
												Ha ocurrido un error.</div>";
					  				}
					  				
					  			}

				  		}else{

				  			header('location: '.$web['url'].'/_administracion/administracion_mobs');
				  		}


				  	?>

				  	<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				  		<label class="control-label" for="focusedInput">Nombre del mob</label>
				  		<input type="text" name="nombre_mob" class="form-control" id="inputEmail" value="<?php echo $row['nombre_mob']; ?>" placeholder="Nombre del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Ataque del mob</label>
				  		<input type="text" name="ataque_mob" class="form-control" id="inputEmail" value="<?php echo $row['ataque_mob']; ?>" placeholder="Ataque del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Defensa del mob</label>
				  		<input type="text" name="defensa_mob" class="form-control" id="inputEmail" value="<?php echo $row['def_mob']; ?>" placeholder="Defensa del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Salud máxima del mob</label>
				  		<input type="text" name="max_salud_mob" class="form-control" id="inputEmail" value="<?php echo $row['max_salud_mob']; ?>" placeholder="Máxima salud del mob"><br/>
				  		
				  		<!--<label class="control-label" for="focusedInput">Frecuencia del mob</label>
				  		<input type="number" name="frecuencia_mob" class="form-control" id="inputEmail" value="<?php echo $row['frecuencia_mob']; ?>" placeholder="Frecuencia del mob"><br/>-->
				  		
				  		<label class="control-label" for="focusedInput">Oro drop</label>
				  		<input type="text" name="oro_mob" class="form-control" id="inputEmail" value="<?php echo $row['oro_mob']; ?>" placeholder="Oro drop"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Experiencia drop</label>
				  		<input type="text" name="exp_mob" class="form-control" id="inputEmail" value="<?php echo $row['oro_mob']; ?>" placeholder="Experiencia que da"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Reputación drop</label>
				  		<input type="text" name="reputacion_mob" class="form-control" id="inputEmail" value="<?php echo $row['reputacion_mob']; ?>" placeholder="Reputación del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del mob</label>
				  		<textarea class="form-control" style="max-width:100%;" name="descripcion_mob" rows="2" id="textArea" placeholder="Descripción del mob"><?php echo $row['descripcion_mob']; ?></textarea><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del mob</label>
						<select class="form-control" name="img_mob">
							<option><?php echo $row['img_mob']; ?></option>
						<?php 
							$dir = opendir("../img/mobs/"); 
							while($listar_d = readdir($dir)){ 
								if ($listar_d[0] != "." && $listar_d[0] != ".." ){ 
									echo "<option value=\"$listar_d\">$listar_d</option>"; 
								} 
							} 
							echo '</select>';
							closedir($dir);
						?>
						<br/>
						<input type="submit" name="edit_mob" class="btn btn-primary" value="Agregar mob">
						<input type="submit" name="borrar_mob" onClick="alert('Mob eliminado con éxito.')" class="btn btn-danger" value="Borrar mob">
				  	</form>
				  </div>
				</div>
							

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>