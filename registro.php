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
		<title><?php echo $web['nombre']; ?> - Registro</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/posts.gif"> Registro</div>
				  <div class="panel-body">
								<?php
									if(isset($_POST['envio2']) == 'Registrar'){
										$usuario = proteccion(mysqli_real_escape_string($conexion, $_POST['usuario']));
										$email = proteccion(mysqli_real_escape_string($conexion, $_POST['email']));
										$pass = proteccion(mysqli_real_escape_string($conexion, $_POST['pass']));
										$repass = proteccion(mysqli_real_escape_string($conexion, $_POST['repass']));
										$ip = $_SERVER['REMOTE_ADDR'];

										$sql_nombre = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' ");
										$sql_email = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email' ");

										if(mysqli_fetch_assoc($sql_nombre)){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													El nombre de usuario que has introducido ya se encuentra en uso.</div>';
										
										}elseif(mysqli_fetch_assoc($sql_email)){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													El email que has introducido ya se encuentra en uso.</div>';

										}elseif(str_word_count($usuario) > 1 or str_word_count($pass) > 1){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													No se amiten espacios.</div>';

										}elseif(empty($usuario) or empty($email) or empty($pass) or empty($repass)){
											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													Debes rellenar todos los campos.</div>';

										}elseif(!ValidacionEmail($email)){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													El Email que has introducido es inválido.</div>';

										}elseif($pass !== $repass){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													Las contraseñas no coinciden.</div>';

										}elseif(strlen($usuario) <= 2){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													El usuario debe tener más de 3 carácteres.</div>';

										}elseif(strlen($pass) <= 6){

											echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
													La contraseña debe contener más de 6 carácteres.</div>';

										}else{

											mysqli_query($conexion, "INSERT INTO usuarios (usuario, email, passw, fecha_registro, ip) VALUES('".$usuario."','".$email."','".md5($pass)."','".date("Y-m-d H:i")."','$ip')");
											echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
													Usuario registrado con éxito.</div>';
										}	
									}
								?>
					<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
						<input type="text" name="usuario" class="form-control" id="inputEmail" placeholder="Usuario"><br/>
						<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"><br/>
						<input type="password" name="pass" class="form-control" id="inputEmail" placeholder="Contraseña"><br/>
						<input type="password" name="repass" class="form-control" id="inputEmail" placeholder="Repetir contraseña"><br/>
						<input type="hidden" name="ip" value="<?php $_SERVER['REMOTE_ADDR']; ?>">
						<input type="submit" name="envio2" class="btn btn-primary" value="Registrar">
					</form>
				  </div>
				</div>

				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>