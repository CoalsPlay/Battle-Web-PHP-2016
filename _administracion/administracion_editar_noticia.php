<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png"> Administración - Edición de noticias</div>
				  <div class="panel-body">
				  	<div class="col-md-12">
				  		<?php

				  			if(isset($_GET['id'])){
				  				$id = $_GET['id'];
								$sql = mysqli_query($conexion, "SELECT * FROM noticias 
																JOIN usuarios ON noticias.autor = usuarios.id
																WHERE id_articulo = '$id' ");
								$row = mysqli_fetch_array($sql);

					  			if(isset($_POST['aceptar_edicion'])){
					  				$titulo = $_POST['titulo'];
					  				$texto = $_POST['texto'];

					  				if(empty($titulo) or empty($texto)){
					  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
												Deben rellenarse todos los campos.</div>";
					  				}else{

					  					mysqli_query($conexion, "UPDATE noticias SET titulo = '$titulo', texto = '$texto' WHERE id_articulo = '$id' ");
					  					echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
												Se ha editado correctamente la noticia.</div><meta http-equiv='refresh' content='2;".$web['url']."/_administracion/administracion_editar_noticia?id=".$id." '>";
					  				}
					  			}

					  			if(isset($_POST['borrar_not'])){
					  				mysqli_query($conexion, "DELETE FROM noticias WHERE id_articulo = '$id' ");
					  				mysqli_query($conexion, "DELETE FROM comentarios WHERE id_noticia='$id' ");
					  				header('location: '.$web['url'].'/_administracion/administracion_noticias');
					  			}
						?>
						<form method="post" action="" class="form-horizontal">
							<label class="control-label" for="focusedInput">Título de la noticia</label>
							<input type="text" class="form-control" id="inputEmail" name="titulo" value="<?php echo $row['titulo']; ?>"><br/>
							
							<label class="control-label" for="focusedInput">Texto de la noticia</label>
							<textarea class="form-control" style="max-width:100%" name="texto" rows="13" id="textArea"><?php echo $row['texto']; ?></textarea><br/>
							
							<label class="control-label" for="focusedInput">Autor de la noticia</label>
							<input type="text" class="form-control" id="inputEmail" disabled name="autor" value="<?php echo $row['usuario']; ?>"><br/>
							
							<button type="submit" name="aceptar_edicion" class="btn btn-primary">Aceptar edición</button>
							<button type="submit" onClick="alert('Noticia eliminada con éxito.')" name="borrar_not" class="btn btn-danger">Borrar noticia</button>
						</form>
						<?php
				  			}else{
				  				header('location: '.$web['url'].'/_administracion/administracion_noticias');
				  			}
				  		?>
					</div>
				  </div>
				</div>
				

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>