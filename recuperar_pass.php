<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(isset($_SESSION['login'])){ header('location:'.$web['url'].'/'); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Recuperar contraseña</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/lock_break.png"> Recuperar contraseña</div>
				  <div class="panel-body">
				  		<?php
				  			if(isset($_POST['forgot'])){
				  				$usuario = proteccion($_POST['usuario']);
				  				$email = proteccion($_POST['email']);

				  				$query_email = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND email='$email' ");

				  				if(empty($usuario) or empty($email)){
				  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Debes rellenar todos los campos.</div>";
				  				}elseif(mysqli_num_rows($query_email) == 0){
				  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											El usuario no coincide con el Email.</div>";
								}elseif(!ValidacionEmail($email)){
									echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											El Email que has introducido es inválido.</div>";
				  				}else{
				  					$codigo = rand(10000,10000000);
				  					if(mysqli_query($conexion, "UPDATE usuarios SET pass_reset='$codigo' WHERE usuario='$usuario' ")){
					  					$para = $email;
					  					$asunto = $web['nombre'].' - Cambio de password.';
					  					$cuerpo = 
					  					'Hola '.$usuario.'. Ud. ha solicitado un cambio de contraseña, para llevar a cabo 
					  					este cambio ud. debe acceder a la URL que le proporcionamos a continuación:

					  					Cambiar contraseña: '.$web['url'].'/cambiar_pass?codigo='.$codigo.'&usuario='.$usuario.'

					  					Deseamos que pueda cambiar su contraseña correctamente.

					  					Esto es un Email automático enviado por '
					  					.$web['nombre'].' por lo que no se moleste en responderlo. Gracias!';
					  					mail($para, $asunto, $cuerpo);
					  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
												Le hemos enviado un Email con los pasos a seguir para cambiar su contraseña.</div>";
				  					}else{
				  						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
												Hubo un error en el cambio.</div>";
				  					}
				  				}
				  			}
				  		?>
						<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
							<input type="text" name="usuario" class="form-control" id="inputEmail" placeholder="Usuario"><br/>
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"><br/>
							<input type="submit" name="forgot" class="btn btn-primary" value="Aceptar">
						</form>
				  </div>
				</div>
				
				<?php include('plantilla/box_changelog.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>