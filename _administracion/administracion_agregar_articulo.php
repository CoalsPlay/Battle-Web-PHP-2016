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
				  		if(isset($_POST['add_art'])){
				  			$nombre_art = proteccion($_POST['nombre_articulo']);
				  			$precio_art = proteccion($_POST['precio_articulo']);
				  			$accion_art = proteccion($_POST['accion_articulo']);
				  			$cantidad_acc = proteccion($_POST['cantidad_accion_articulo']);
				  			$desc_articulo = proteccion($_POST['desc_articulo']);
				  			$lista_art = $_POST['lista_articulo'];

				  			if(empty($nombre_art) or empty($precio_art) or empty($accion_art) or empty($desc_articulo) or empty($lista_art)){

				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar todos los campos.</div>";
				  			}else{

				  				$sql = "INSERT INTO tienda (nombre_articulo, precio_articulo, accion_articulo, cantidad_accion, descripcion_articulo, img_articulo) 
				  						VALUES ('".$nombre_art."','".$precio_art."','".$accion_art."','".$cantidad_acc."','".$desc_articulo."','".$lista_art."')";
				  				if(mysqli_query($conexion, $sql)){
				  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											Artículo implementado correctamente.</div><meta http-equiv='refresh' content='1;administracion_tienda'>";
				  				}else{
				  					echo 'Ha ocurrido un error al insertar el artículo.';
				  				}
				  			}
				  		}
				  	?>
				  	<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				  		<label class="control-label" for="focusedInput">Nombre del artículo</label>
				  		<input type="text" name="nombre_articulo" class="form-control" id="inputEmail" placeholder="Nombre del artículo"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Precio del artículo</label>
				  		<input type="text" name="precio_articulo" class="form-control" id="inputEmail" placeholder="Precio del artículo"><br/>
				        
				  		<label class="control-label" for="focusedInput">Acción del artículo</label>
				        <select class="form-control" id="select" name="accion_articulo">
				          <option value="hp">Salud</option>
				          <option value="sp">Energía</option>
				          <option value="def">Defensa</option>
				          <option value="atk">Ataque</option>
				        </select><br/>
				        
				  		<label class="control-label" for="focusedInput">Cantidad de acción del artículo</label>
				        <input type="text" name="cantidad_accion_articulo" class="form-control" id="inputEmail" placeholder="Cantidad acción"><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del artículo</label>
				  		<textarea class="form-control" style="max-width:100%;" name="desc_articulo" rows="2" id="textArea" placeholder="Descripción del artículo"></textarea><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del artículo</label>
						<select class="form-control" name="lista_articulo">
							<option>Imagen</option>
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
						<input type="submit" name="add_art" class="btn btn-primary" value="Agregar artículo">
				  	</form>
				  </div>
				</div>
					

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>