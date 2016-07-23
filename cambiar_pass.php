<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(isset($_SESSION['login'])){ header('location: '.$web['url'].'/'); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Cambiar contraseña</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/lock_break.png"> Cambiar contraseña</div>
				  <div class="panel-body">
					  	<?php
					  		if(isset($_POST['cambiar_pass']) == 'Aceptar'){
					  			$pass_new = proteccion($_POST['pass_new']);
					  			$pass_new_repetir = proteccion($_POST['pass_new_repetir']);
					  			$usuario_comp = proteccion($_POST['usuario_comp']);

					  			if(empty($pass_new) or empty($pass_new_repetir)){
					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Debes rellenar todos los campos.</div>";
					  			}elseif($pass_new !== $pass_new_repetir){
					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Las contraseñas no coinciden.</div>";
								}elseif(strlen($pass_new) <= 6){
									echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											La contraseña debe contener 6 o más carácteres.</div>";
					  			}else{

					  				mysqli_query($conexion, "UPDATE usuarios SET passw='$pass_new' WHERE usuario='$usuario_comp' ");
					  				mysqli_query($conexion, "UPDATE usuarios SET pass_reset='0' WHERE usuario='$usuario_comp' ");

					  				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											Contraseña cambiada correctamente.</div>";
					  			}
					  		}


							if(isset($_GET['codigo'])){
								$obtener_codigo = $_GET['codigo'];
								$obtener_usuario = $_GET['usuario'];

								$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$obtener_usuario' ");

								$row = mysqli_fetch_assoc($sql);
								$sql_codigo = $row['pass_reset'];
								$sql_usuario = $row['usuario'];
							
								if($sql_codigo == 0){

									header('location: '.$web['url'].'/');

								}elseif($obtener_usuario == $sql_usuario && $obtener_codigo == $sql_codigo){
						?>
						<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
							<input type="password" name="pass_new" class="form-control" id="inputEmail" placeholder="Nueva contraseña"><br/>
							<input type="password" name="pass_new_repetir" class="form-control" id="inputEmail" placeholder="Repetir nueva contraseña"><br/>
							<input type="hidden" name="usuario_comp" value="<?php echo $sql_usuario; ?>">
							<input type="submit" name="cambiar_pass" class="btn btn-primary" value="Aceptar">
						</form>
						<?php
								}
							}else{
								header('location:'.$web['url'].'/');
							}
						?>

				  </div>
				</div>
				
				<?php include('plantilla/box_changelog.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>