<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Crear mensaje</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/email.png"> Panel de mensajería</div>
				  <div class="panel-body">
					<div class="list-group">
					  <a href="<?php echo $web['url']; ?>/bandeja_de_entrada" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/email.png">&nbsp;&nbsp; Bandeja de entrada (<b>0</b>)
					  </a>
					  <a href="<?php echo $web['url']; ?>/mensajes_enviados" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/email.png">&nbsp;&nbsp; Mensajes enviados
					  </a>
					  <a href="<?php echo $web['url']; ?>/crear_mensaje" class="list-group-item active">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/email_add.png">&nbsp;&nbsp; Enviar mensaje
					  </a>
					</div>
				  </div>
				</div>
				
				<?php include('plantilla/box_stats.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/email_add.png"> Crear mensaje</div>
				  <div class="panel-body">
				  	<?php
				  		if(isset($_POST['env_msg']) == "Enviar"){
				  			$para = proteccion($_POST['para']);
				  			$asunto = proteccion($_POST['asunto']);
				  			$mensaje_mp = proteccion($_POST['mensaje_mp']);
				  			$sql_bus = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$para' ");

							if(empty($para) or empty($asunto) or empty($mensaje_mp)){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar todos los campos.</div>";
				  			}elseif(mysqli_num_rows($sql_bus) == 0){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										El usuario al que quiere enviar el mensaje no existe.</div>";
				  			}else{

				  				$sql2 = "INSERT INTO mensajes_privados (id_autor_mp, nombre_receptor, titulo_mp, texto_mp, fecha_mp, estado_mp)
				  						VALUES('".$dato_u['id']."','".$para."','".$asunto."','".$mensaje_mp."','".date("Y-m-d H:i")."','0') ";
				  				if(mysqli_query($conexion, $sql2)){
				  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											El mensaje privado se ha enviado a <b>".$para."</b> correctamente.</div>";
				  				}else{
				  					echo 'Hubo un error al envíar mensaje.';
				  				}
				  			}
				  		}
				  	?>
				  	<form method="post" action="" class="form-horizontal">
						<input type="text" name="para" class="form-control" id="inputEmail" placeholder="Para:"><br/>
						<input type="text" name="asunto" class="form-control" id="inputEmail" placeholder="Asunto"><br/>
						<textarea class="form-control" rows="3" style="max-width:100%;" name="mensaje_mp" id="textArea" placeholder="Mensaje"></textarea></br>
						<input type="submit" name="env_msg" class="btn btn-primary" value="Enviar">
					</form>
				  </div>
				</div>
				

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>