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
		<title><?php echo $web['nombre']; ?> - Administración - Agregar artículo</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Administración - Configuraciones</div>
				  <div class="panel-body">
				  	<?php 
				  		if(isset($_POST['acept_cam'])){
				  			$nom_web = proteccion($_POST['nombre_web']);
				  			$url_web = proteccion($_POST['url_web']);
				  			$desc_web = proteccion($_POST['desc_web']);
				  			$mante = $_POST['mantenimiento'];
				  			$ma_c = mysqli_query($conexion, "SELECT * FROM configuraciones ");
				  			$sac_ma = mysqli_fetch_array($ma_c);

				  			if(empty($nom_web) or empty($url_web) or empty($desc_web)){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar al menos un campo.</div>";
				  			}else{

				  				mysqli_query($conexion, "UPDATE configuraciones
				  										 SET nombre_web = '$nom_web', url_web = '$url_web', descripcion_web = '$desc_web', mantenimiento = '$mante' ");
								echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
										Cambios guardados correctamente.</div><meta http-equiv='refresh' content='1; administracion_configuracion'>";				  			
							}

				  		}
				  	?>
				  	<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				  		<label>Nombre del sitio web</label>
				  		<input type="text" name="nombre_web" value="<?php echo $web['nombre']; ?>" class="form-control" id="inputEmail" placeholder="Nombre del juego"><br/>
				  		<label>URL del sitio web</label>
				  		<input type="url" name="url_web" value="<?php echo $web['url']; ?>" class="form-control" id="inputEmail" placeholder="Url del sitio(Incluye el / final)"><br/>
				  		<label>Descripción del sitio web</label>
				  		<textarea class="form-control" style="max-width:100%;" name="desc_web" rows="2" id="textArea" placeholder="Descripción de la web"><?php echo $web['descripcion']; ?></textarea><br/>
				        <h3>Mantenimiento</h3>
				        <input type="radio" <?php if($web['mantenimiento'] == 1){ echo 'checked'; } ?> name="mantenimiento" id="optionsRadios2" value="1">
				        Activado
				        <input type="radio" <?php if($web['mantenimiento'] == 0){ echo 'checked'; } ?> name="mantenimiento" id="optionsRadios2" value="0">
				        Desactivado
						<br/><br/>
						<input type="submit" name="acept_cam" class="btn btn-primary" value="Guardar cambios">
				  	</form>
				  </div>
				</div>
					

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>