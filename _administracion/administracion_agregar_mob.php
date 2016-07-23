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
				  		if(isset($_POST['add_mob'])){
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

				  			if(empty($nombre_mob) or empty($ataque_mob) or empty($defensa_mob) or empty($max_salud_mob) or empty($oro_mob) or empty($exp_mob) or empty($reputacion_mob) or empty($descripcion_mob) or empty($img_mob)){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debe llenar todos los campos.</div>";
				  			}else{

				  				$sql = "INSERT INTO mobs (nombre_mob, ataque_mob, def_mob, salud_mob, max_salud_mob, oro_mob, exp_mob, reputacion_mob, descripcion_mob, img_mob) 
				  						VALUES ('".$nombre_mob."','".$ataque_mob."','".$defensa_mob."','".$max_salud_mob."','".$max_salud_mob."','".$oro_mob."','".$exp_mob."','".$reputacion_mob."','".$descripcion_mob."','".$img_mob."')";
				  				if(mysqli_query($conexion, $sql)){
				  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
										Mob agregado correctamente.</div><meta http-equiv='refresh' content='1;administracion_mobs'>";
				  				}else{
				  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Ha ocurrido un error.</div>";
				  				}
				  			}
				  		}
				  	?>

				  	<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				  		<label class="control-label" for="focusedInput">Nombre del mob</label>
				  		<input type="text" name="nombre_mob" class="form-control" id="inputEmail" placeholder="Nombre del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Ataque del mob</label>
				  		<input type="number" name="ataque_mob" class="form-control" id="inputEmail" placeholder="Ataque del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Defensa del mob</label>
				  		<input type="number" name="defensa_mob" class="form-control" id="inputEmail" placeholder="Defensa del mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Salud máxima del mob</label>
				  		<input type="number" name="max_salud_mob" class="form-control" id="inputEmail" placeholder="Máxima salud del mob"><br/>
				  		
				  		<!--<label class="control-label" for="focusedInput">Frecuencia del mob</label>
				  		<input type="number" name="frecuencia_mob" class="form-control" id="inputEmail" placeholder="Frecuencia del mob"><br/>-->
				  		
				  		<label class="control-label" for="focusedInput">Experiencia drop</label>
				  		<input type="number" name="exp_mob" class="form-control" id="inputEmail" placeholder="Experiencia que da"><br/>				  		
				  		
				  		<label class="control-label" for="focusedInput">Oro drop</label>
				  		<input type="number" name="oro_mob" class="form-control" id="inputEmail" placeholder="Oro que dropea"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Reputación drop</label>
				  		<input type="number" name="reputacion_mob" class="form-control" id="inputEmail" placeholder="Reputación que da el mob"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del mob</label>
				  		<textarea class="form-control" style="max-width:100%;" name="descripcion_mob" rows="2" id="textArea" placeholder="Descripción del mob"></textarea><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del mob</label>
						<select class="form-control" name="img_mob">
							<option>Imagen</option>
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
						<input type="submit" name="add_mob" class="btn btn-primary" value="Agregar mob">
				  	</form>
				  </div>
				</div>
								

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>