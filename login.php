<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(isset($_SESSION['login'])){ header("Location: index"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Login</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/door_in.png"> Conéctate</div>
				  <div class="panel-body">
					  	<?php
					  		if(isset($_POST['envio3'])){
					  			$usuario = proteccion($_POST['usuario']);
					  			$pass = proteccion($_POST['pass']);
					  			$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND passw='$pass'");

					  			if(mysqli_num_rows($sql)){
					  				$_SESSION['login'] = $usuario;
									header("Location: index");
					  			}else{
					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Usuario o contraseña incorrecto.</div>";
					  			}
					  		}
					  	?>
					  	<form method="post" action="" class="form-horizontal">
							<input type="text" name="usuario" class="form-control" id="inputEmail" placeholder="Usuario"><br/>
							<input type="password" name="pass" class="form-control" id="inputEmail" placeholder="Contraseña"><br/>
							<a href="#">¿Contraseña perdida?</a><br/><br/>
							<button type="submit" name="envio3" class="btn btn-primary">Conectar</button><!--&nbsp;&nbsp; <input type="checkbox"> Recordarme-->
						</form>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>