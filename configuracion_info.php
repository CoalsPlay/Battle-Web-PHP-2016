<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/registro"); }

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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Opciones y Configuraciones</div>
				  <div class="panel-body">
				  	<?php

				  		if(isset($_POST['guardar_info'])){
				  			$sobre_mi = proteccion($_POST['sobre_mi']);
				  			$sexo = proteccion($_POST['sexo']);
				  			$autoplay = $_POST['autoplay'];
				  			$theme = $_POST['theme'];
				  			$twitter = proteccion($_POST['twitter']);
				  			$facebook = proteccion($_POST['facebook']);
				  			$youtube = proteccion($_POST['youtube']);

				  			if(empty($sobre_mi) and empty($sexo) and empty($twitter) and empty($facebook) and empty($youtube)){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar aunque sea un campo.</div>";
				  			}else{

				  				if(isset($autoplay)){
				  					mysqli_query($conexion, "UPDATE usuarios SET autoplay = '$autoplay' WHERE id = '$dato_u[id]' ");
				  				}else{
				  					mysqli_query($conexion, "UPDATE usuarios SET autoplay = '1' WHERE id = '$dato_u[id]' ");
				  				}

					  			if(mysqli_query($conexion, "UPDATE usuarios 
					  			SET sobre_mi = '$sobre_mi', genero = '$sexo', theme = '$theme', twitter = '$twitter', facebook = '$facebook', youtube = '$youtube' WHERE usuario = '$_SESSION[login]' ")){

					  				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											¡Datos actualizado correctamente!</div><meta http-equiv='refresh' content='1;configuracion_info'>";
					  			}else{
					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Hubo un error en la actualización de la información.</div>";
					  			}
					  		}
				  		}

				  		$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$_SESSION[login]' ");
				  		$row = mysqli_fetch_array($sql);
				  	?>
					<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
						<h3>Información</h3>
						<textarea class="form-control" style="max-width:100%;" name="sobre_mi" maxlength="300" rows="3" id="textArea" placeholder="Escribe algo sobre ti. (300 carácteres.)"><?php echo $row['sobre_mi']; ?></textarea><br/>
				        <select class="form-control" name="sexo" id="select">
				          <option <?php if($row['genero'] == 0){ echo 'selected="selected" '; } ?> value="0">Sexo</option>
				          <option <?php if($row['genero'] == 1){ echo 'selected="selected" '; } ?> value="1">Masculino</option>
				          <option <?php if($row['genero'] == 2){ echo 'selected="selected" '; } ?> value="2">Femenino</option>
				        </select><br/>
				        
				        <h3>AutoPlay</h3>
				        <input <?php if($row['autoplay'] == 0){ echo 'checked="checked" '; } ?> type="checkbox" value="0"  name="autoplay"> Desactivar AutoPlay de la música ambiente. <span class="text-danger">(Es necesario recargar página)</span><br/>
				        
				        <h3>Apariencia</h3>
				        <select class="form-control" name="theme" id="select">
				          <option <?php if($row['theme'] == "basico.css"){ echo 'selected="selected" '; } ?> value="basico.css">De serie</option>
				          <option <?php if($row['theme'] == "lumen.css"){ echo 'selected="selected" '; } ?> value="lumen.css">Lumen</option>
				          <option <?php if($row['theme'] == "cerulean.css"){ echo 'selected="selected" '; } ?> value="cerulean.css">Cerulean</option>
				          <option <?php if($row['theme'] == "cyborg.css"){ echo 'selected="selected" '; } ?> value="cyborg.css">Cyborg</option>
				          <option <?php if($row['theme'] == "darkly.css"){ echo 'selected="selected" '; } ?> value="darkly.css">Darkly</option>
				          <option <?php if($row['theme'] == "flatly.css"){ echo 'selected="selected" '; } ?> value="flatly.css">Flatly</option>
				          <option <?php if($row['theme'] == "journal.css"){ echo 'selected="selected" '; } ?> value="journal.css">Journal</option>
				          <option <?php if($row['theme'] == "paper.css"){ echo 'selected="selected" '; } ?> value="paper.css">Paper</option>
				          <option <?php if($row['theme'] == "readable.css"){ echo 'selected="selected" '; } ?> value="readable.css">Readable</option>
				          <option <?php if($row['theme'] == "sandstone.css"){ echo 'selected="selected" '; } ?> value="sandstone.css">Sandstone</option>
				          <option <?php if($row['theme'] == "simplex.css"){ echo 'selected="selected" '; } ?> value="simplex.css">Simplex</option>
				          <option <?php if($row['theme'] == "slate.css"){ echo 'selected="selected" '; } ?> value="slate.css">Slate</option>
				          <option <?php if($row['theme'] == "spacelab.css"){ echo 'selected="selected" '; } ?> value="spacelab.css">Spacelab</option>
				          <option <?php if($row['theme'] == "superhero.css"){ echo 'selected="selected" '; } ?> value="superhero.css">Superhero</option>
				          <option <?php if($row['theme'] == "united.css"){ echo 'selected="selected" '; } ?> value="united.css">United</option>
				          <option <?php if($row['theme'] == "yeti.css"){ echo 'selected="selected" '; } ?> value="yeti.css">Yeti</option>				        </select>

				        <h3>Redes sociales</h3>
						<input type="text" class="form-control"  value="<?php echo $row['twitter']; ?>" name="twitter" id="inputEmail" placeholder="Usuario de Twitter (sin @)"><br/>
						<input type="text" class="form-control" value="<?php echo $row['facebook']; ?>" name="facebook" id="inputEmail" placeholder="Usuario de Facebook"><br/>
						<input type="text" class="form-control" value="<?php echo $row['youtube']; ?>" name="youtube" id="inputEmail" placeholder="Usuario de YouTube"><br/>

						<input type="submit" name="guardar_info" class="btn btn-primary" value="Guardar cambios">
					</form>
				  </div>
				</div>


			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>