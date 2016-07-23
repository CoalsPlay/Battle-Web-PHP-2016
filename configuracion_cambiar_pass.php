<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header('location: '.$web['url'].'/registro'); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Opciones y configuraciones</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_confi.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/textfield_key.png"> Cambio de contraseña</div>
				  <div class="panel-body">
				  	<?php
				  		if(isset($_POST['guardar'])){
				  			$pass_antigua = proteccion($_POST['pass_antigua']);
				  			$pass_new = proteccion($_POST['pass_new']);
				  			$repetir_pass_new = proteccion($_POST['repetir_pass_new']);

				  			$sql_pass = mysqli_query($conexion, "SELECT * FROM usuarios WHERE passw='$pass_antigua'");
				  			$sql_ext_pass = mysqli_fetch_array($sql_pass);

				  			if(empty($pass_antigua) or empty($pass_new) or empty($repetir_pass_new)){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar todos lo campos.</div>";

				  			}elseif($sql_ext_pass['passw'] !== $pass_antigua){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										La antigua contraseña es inválida.</div>";

				  			}elseif(strlen($pass_new) <= 6){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										La contraseña debe contener más de 6 carácteres.</div>";
							}elseif($sql_ext_pass['passw'] == $pass_new){

								echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										La contraseña que has introducido es la que tienes actualmente. Elige otra para mayor seguridad.</div>";

				  			}elseif($pass_new !== $repetir_pass_new){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Las contraseñas no coinciden.</div>";

				  			}else{

					  			if(mysqli_query($conexion, "UPDATE usuarios SET passw='$pass_new' WHERE usuario='$_SESSION[login]' ")){

					  				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											Tu contraseña ha sido cambiada correctamente.</div><meta http-equiv='refresh' content='1;configuracion_cambiar_pass'>";

					  			}else{

					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Hubo un error en el cambio de contraseña.</div>";
					  				
					  			}
				  			}
				  		
				  		}
				  	?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
						<h3>Cambio de contraseña</h3>
						<input type="password" class="form-control" name="pass_antigua" id="inputEmail" placeholder="Contraseña antigua"><br/>
						<input type="password" class="form-control" name="pass_new" id="inputEmail" placeholder="Contraseña nueva"><br/>
						<input type="password" class="form-control" name="repetir_pass_new" id="inputEmail" placeholder="Repetir contraseña nueva"><br/>
						<input type="submit" name="guardar" class="btn btn-primary" value="Guardar cambios">
					</form>
				  </div>
				</div>
				

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>