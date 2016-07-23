<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 3 or $dato_u['rango'] == 2){ header('location: '.$web['url'].'/_administracion/administracion'); }

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Administración - Gestor de noticias</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png"> Administración - Edición de usuario: <?php echo $dato_u['usuario']; ?></div>
				  <div class="panel-body">
				  	<div class="col-md-12">
				  		<?php

				  			if(isset($_GET['id'])){
				  				$id = $_GET['id'];
								$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$id' ");
								$row = mysqli_fetch_array($sql);

					  			if(isset($_POST['aceptar_edicion'])){
					  				$usuario = proteccion($_POST['usuario']);
					  				$email = proteccion($_POST['email']);
					  				$sobre_mi = proteccion($_POST['sobre_mi']);
					  				$twitter = proteccion($_POST['twitter']);
					  				$facebook = proteccion($_POST['facebook']);
					  				$youtube = proteccion($_POST['youtube']);
					  				$nivel = proteccion($_POST['nivel']);
					  				$oro = proteccion($_POST['oro']);
					  				$reputacion = proteccion($_POST['reputacion']);
					  				$bajas = proteccion($_POST['bajas']);
					  				$energia = proteccion($_POST['energia']);
					  				$ataque = proteccion($_POST['ataque']);
					  				$defensa = proteccion($_POST['defensa']);
					  				$salud = proteccion($_POST['salud']);

					  				if(empty($usuario) or empty($email) or empty($email) or empty($nivel) or empty($oro) or empty($energia) or empty($ataque) or empty($defensa) or empty($salud)){
					  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
												No puede quedar en blanco los campos de gran importancia.</div>";
					  				}else{

					  					if(mysqli_query($conexion, "UPDATE usuarios 
					  						SET usuario = '$usuario', email = '$email', sobre_mi = '$sobre_mi', twitter = '$twitter', facebook = '$facebook', youtube = '$youtube', nivel = '$nivel', oro = '$oro', reputacion = '$reputacion', bajas = '$bajas', energia = '$energia', ataque = '$ataque', defensa = '$defensa', salud = '$salud'
					  						WHERE id = '$id' ")){
					  						echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
													Se ha editado correctamente el usuario.</div><meta http-equiv='refresh' content='2;".$web['url']."/_administracion/administracion_usuarios '>";
					  					}else{
					  						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
													Ha ocurrido un error en la edición.</div>";
					  					}
					  				}
					  			}

					  			if(isset($_POST['borrar_us'])){
					  				if(mysqli_query($conexion, "DELETE FROM usuarios WHERE id = '$id' ")){
					  					header('location: '.$web['url'].'/administracion_usuarios');
					  				}else{
										echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
													Ha ocurrido un error en la eliminación del usuario.</div>";
					  				}
					  				
					  			}
						?>
						<div class="col-md-6">
							<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
								<label>Usuario</label>
								<input type="text" class="form-control" id="inputEmail" name="usuario" value="<?php echo $row['usuario']; ?>"><br/>

								<label>Email</label>
								<input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo $row['email']; ?>"><br/>

								<label class="control-label" for="disabledInput">Ip</label>
								<input class="form-control" id="disabledInput" type="text" name="ip" value="<?php echo $row['ip']; ?>" disabled="disabled"><br/>

								<label class="control-label" for="focusedInput">Sobre mi</label>
								<textarea class="form-control" style="max-width:100%" placeholder="Información no especificada" name="sobre_mi" rows="5" id="textArea"><?php echo $row['sobre_mi']; ?></textarea><br/>

								<label class="control-label" for="disabledInput">Fecha de registro</label>
								<input class="form-control" id="disabledInput" type="text" name="fecha_registro" value="<?php echo $row['fecha_registro']; ?>" disabled="disabled"><br/>

								<label class="control-label" for="focusedInput">Twitter</label>
								<input type="text" class="form-control" name="twitter" placeholder="Información no especificada" id="inputEmail" value="<?php echo $row['twitter']; ?>"><br/>

								<label class="control-label" for="focusedInput">Facebook</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="facebook" value="<?php echo $row['facebook']; ?>"><br/>

								<label class="control-label" for="focusedInput">Youtube</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="youtube" value="<?php echo $row['youtube']; ?>"><br/>

								<label class="control-label" for="focusedInput">Nivel</label>
								<input type="text" class="form-control" id="inputEmail" name="nivel" value="<?php echo $row['nivel']; ?>"><br/>

								<label class="control-label" for="focusedInput">Oro</label>
								<input type="text" class="form-control" id="inputEmail" name="oro" value="<?php echo $row['oro']; ?>"><br/>
						</div>
						<div class="col-md-6">
								<label class="control-label" for="focusedInput">Youtube</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="youtube" value="<?php echo $row['youtube']; ?>"><br/>

								<label class="control-label" for="focusedInput">Nivel</label>
								<input type="text" class="form-control" id="inputEmail" name="nivel" value="<?php echo $row['nivel']; ?>"><br/>

								<label class="control-label" for="focusedInput">Oro</label>
								<input type="text" class="form-control" id="inputEmail" name="oro" value="<?php echo $row['oro']; ?>"><br/>

								<label class="control-label" for="focusedInput">Mobs asesinados</label>
								<input type="text" class="form-control" id="inputEmail" name="bajas" value="<?php echo $row['bajas']; ?>"><br/>

								<label class="control-label" for="focusedInput">Reputación</label>
								<input type="text" class="form-control" id="inputEmail" name="reputacion" value="<?php echo $row['reputacion']; ?>"><br/>

								<label class="control-label" for="disabledInput">Experiencia</label>
								<input class="form-control" id="disabledInput" type="text" name="exp" value="<?php echo $row['exp']; ?>" disabled="disabled"><br/>

								<label class="control-label" for="disabledInput">Energía</label>
								<input class="form-control" id="disabledInput" type="text" name="energia" value="<?php echo $row['energia']; ?>"><br/>

								<label class="control-label" for="focusedInput">Ataque</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="ataque" value="<?php echo $row['ataque']; ?>"><br/>

								<label class="control-label" for="focusedInput">Defensa</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="defensa" value="<?php echo $row['defensa']; ?>"><br/>

								<label class="control-label" for="focusedInput">Salud</label>
								<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="salud" value="<?php echo $row['max_salud']; ?>"><br/>

								<br/>
								<button type="submit" name="aceptar_edicion" class="btn btn-primary">Aceptar edición</button>
								<button type="submit" onClick="alert('Usuario eliminado con éxito.')" name="borrar_us" class="btn btn-danger">Borrar usuario</button>
							</form>
						</div>
						<?php
				  			}else{
				  				header('location: '.$web['url'].'/_administracion/administracion_usuarios');
				  			}
				  		?>
					</div>
				  </div>
				</div>
		

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>