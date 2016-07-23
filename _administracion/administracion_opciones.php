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
		<title><?php echo $web['nombre']; ?> - Administración</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/wrench.png"> Administración - Opciones del juego</div>
				  <div class="panel-body">
				  	<?php
				  		if(isset($_POST['aceptar_cog']) == 'Aceptar cambios'){
				  			$exp_nec = proteccion($_POST['exp_nec']);
				  			$lvl_max = proteccion($_POST['lvl_max']);
				  			$pts_atr_lvl = proteccion($_POST['pts_atr_lvl']);
				  			$lvl_dif = proteccion($_POST['lvl_dif']);
				  			$precio_cem = proteccion($_POST['precio_cem']);
				  			$num_top = proteccion($_POST['num_top']);

				  			if(empty($exp_nec) or empty($lvl_max) or empty($pts_atr_lvl) or empty($lvl_dif) or empty($precio_cem) or empty($num_top)){
								echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
										No puedes dejar ningún campo en blanco.</div>';

				  			}else{
				  				mysqli_query($conexion, "UPDATE configuraciones 
				  				SET intervalo_exp='$exp_nec', nivel_maximo='$lvl_max', precio_cementerio='$precio_cem', pts_atributos_lvl='$pts_atr_lvl', num_top='$num_top', int_lvl='$lvl_dif' ");
				  				echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
									Los cambios se han actualizado correctamente.</div>';

				  			}
				  		}
				  	?>
				  	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				      <label for="intexp" class="control-label">Experiencia necesaria para siguiente nivel</label>
				      <input type="text" name="exp_nec" class="form-control" value="<?php echo $game['int_exp']; ?>" id="intexp" placeholder="Intervalo de Experiencia">
				      <br/>
				      <label for="intlvl">Nivel Máximo</label>
				      <input type="text" name="lvl_max" class="form-control" value="<?php echo $game['max_lvl']; ?>" id="intlvl" placeholder="Nivel máximo del juego">
				      <br/>
				      <label for="intpts" class="control-label">Puntos de atributos otorgados al subir nivel</label>
				      <input type="text" name="pts_atr_lvl" class="form-control" value="<?php echo $game['pts_atr_lvl']; ?>" id="intpts" placeholder="Puntos de atributos otorgados al subir nivel">
				      <br/>
				      <label for="lvlf" class="control-label">Nivel de diferencia para poder combatir con un usuario</label>
				      <input type="text" name="lvl_dif" class="form-control" value="<?php echo $game['int_lvl']; ?>" id="lvlf" placeholder="Nivel de diferencia para poder combatir con un usuario">
				      <br/>
				      <label for="prc" class="control-label">Precio para revivir a un usuario en Cementerio</label>
				      <input type="text" name="precio_cem" class="form-control" value="<?php echo $game['pre_cem']; ?>" id="prc" placeholder="Precio para revivir usuario en Cementerio">
				      <br/>
				      <label for="intop" class="control-label">Número de usuarios en TOP</label>
				      <input type="text" name="num_top" class="form-control" value="<?php echo $game['num_top']; ?>" id="intop" placeholder="Número de usuarios en TOP">
				      <br/>
				      <input type="submit" name="aceptar_cog" value="Aceptar cambios" class="btn btn-primary">
				    </form>
				  </div>
				</div>		

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>