<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 3){ header('location: '.$web['url'].'/_administracion/administracion'); }

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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cart_edit.png"> Administración - Gestor de la tienda</div>
				  <div class="panel-body">
				  	<?php
				  		if(isset($_GET['articulo'])){
				  			$id_art = $_GET['articulo'];
				  			$sql = mysqli_query($conexion, "SELECT * FROM tienda WHERE id_articulo = '$id_art' ");
				  			$row = mysqli_fetch_array($sql);

					  		if(isset($_POST['sav_art'])){
					  			$nombre_art = proteccion($_POST['nombre_articulo']);
					  			$precio_art = proteccion($_POST['precio_articulo']);
					  			$cant_accion = proteccion($_POST['cantidad_accion']);
					  			$accion_art = proteccion($_POST['accion_articulo']);
					  			$desc_articulo = proteccion($_POST['desc_articulo']);
					  			$lista_art = $_POST['lista_articulo'];

					  			if(empty($nombre_art) or empty($precio_art) or empty($accion_art) or empty($desc_articulo) or empty($lista_art)){

					  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Debes rellenar todos los campos.</div>";
					  			}else{

					  				$sql2 = "UPDATE tienda
					  						SET nombre_articulo = '$nombre_art', precio_articulo = '$precio_art', accion_articulo = '$accion_art', cantidad_accion = '$cant_accion', descripcion_articulo = '$desc_articulo', img_articulo = '$lista_art'
					  						WHERE id_articulo = '$id_art' ";
					  				if(mysqli_query($conexion, $sql2)){
					  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
												Se han guardado los cambios correctamente.</div><meta http-equiv='refresh' content='1;administracion_tienda'>";
					  				}else{
					  					echo 'Ha ocurrido un error al insertar el artículo.';
					  				}
					  			}
					  		}

					  		if(isset($_POST['del_art'])){
					  			if(mysqli_query($conexion, "DELETE FROM tienda WHERE id_articulo = '$id_art' ")){
						  			header("Location: administracion_tienda");
						  		}else{
									echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Ha ocurrido un error en la eliminación del usuario.</div>";
						  		}
					  		}

					  	}else{
					  		header("Location: administracion");
					  	}

				  	?>
				  	<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				  		<label class="control-label" for="focusedInput">Nombre del artículo</label>
				  		<input type="text" name="nombre_articulo" value="<?php echo $row['nombre_articulo']; ?>" class="form-control" id="inputEmail" placeholder="Nombre del artículo"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Precio del artículo</label>
				  		<input type="text" name="precio_articulo" value="<?php echo $row['precio_articulo']; ?>" class="form-control" id="inputEmail" placeholder="Precio del artículo"><br/>
				        
				  		<label class="control-label" for="focusedInput">Acción del artículo</label>
				        <select class="form-control" id="select" name="accion_articulo">
				          <option <?php if($row['accion_articulo'] == 'hp'){ echo 'selected="selected" '; } ?> value="hp">Salud</option>
				          <option <?php if($row['accion_articulo'] == 'sp'){ echo 'selected="selected" '; } ?> value="sp">Energía</option>
				          <option <?php if($row['accion_articulo'] == 'def'){ echo 'selected="selected" '; } ?> value="def">Defensa</option>
				          <option <?php if($row['accion_articulo'] == 'atk'){ echo 'selected="selected" '; } ?> value="atk">Ataque</option>
				        </select><br/>
				  		
				  		<label class="control-label" for="focusedInput">Cantidad de acción del artículo</label>
				  		<input type="text" name="cantidad_accion" value="<?php echo $row['cantidad_accion']; ?>" class="form-control" id="inputEmail" placeholder="Acción del artículo"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del artículo</label>
				  		<textarea class="form-control" style="max-width:100%;" name="desc_articulo" rows="2" id="textArea" placeholder="Descripción del artículo"><?php echo $row['descripcion_articulo']; ?></textarea><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del artículo</label>
						<select class="form-control" name="lista_articulo">
							<option><?php echo $row['img_articulo']; ?></option>
						<?php 
							$dir = opendir("../img/articulos/"); 
							while($listar_d = readdir($dir)){ 
								if ($listar_d[0] != "." && $listar_d[0] != ".." ){ 
									echo "<option value=\"$listar_d\">$listar_d</option>"; 
								} 
							} 
							echo '</select>';
							closedir($dir);
						?>
						<br/>
						<input type="submit" name="sav_art" class="btn btn-primary" value="Guardar cambios">
						<input type="submit" name="del_art" class="btn btn-danger" value="Borrar artículo">
				  	</form>
				  </div>
				</div>
					

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>