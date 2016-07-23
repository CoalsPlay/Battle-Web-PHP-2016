<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	$limite = 4;

	if(isset($_GET['pagina'])){
		$pag = $_GET['pagina'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png"> Administración - Gestor de noticias</div>
				  <div class="panel-body">
				  	<div class="col-md-8">
				  		<?php

				  			if(isset($_POST['envio4'])){
				  				$titulo = proteccion($_POST['titulo']);
				  				$texto = $_POST['texto'];

				  				if(empty($titulo) or empty($texto)){
				  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debe llenar todos los campos.</div>";
				  				}else{
				  					if(mysqli_query($conexion, "INSERT INTO noticias (titulo, texto, autor, fecha) VALUES('".$titulo."','".$texto."','".$dato_u['id']."','".date("Y-m-d")."')")){
				  						echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
												Noticia creada con éxito.</div><meta http-equiv='refresh' content='1;administracion_noticias'><br/>";
				  					}else{
				  						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Hubo un error en la creación de la noticia.</div>";
				  					}
				  				}
				  			}

				  		?>
						<form method="post" action="" class="form-horizontal">
				  			<label class="control-label" for="focusedInput">Título de la noticia</label>
							<input type="text" class="form-control" id="inputEmail" name="titulo" placeholder="Título"><br/>
							
							<label class="control-label" for="focusedInput">Texto de la noticia</label>
							<textarea class="form-control" style="max-width:100%" name="texto" rows="5" id="textArea" placeholder="Noticia"></textarea><br/>
							<button type="submit" name="envio4" class="btn btn-primary">Crear noticia</button>
						</form>
					</div>

				  	<div class="col-md-4">
				  		<label class="control-label" for="focusedInput">Noticias creadas</label>
						<div class="list-group">
						  <?php

						  	$sql = mysqli_query($conexion, "SELECT * FROM noticias ORDER BY id_articulo DESC LIMIT $inicio, $limite");

						  	if(mysqli_num_rows($sql) == 0){
						  		echo '<a href="#" class="list-group-item">
									    No hay noticias actualmente.
									  </a>';
						  	}else{

						  		while($row = mysqli_fetch_array($sql)){
						  	?>
								<a href="<?php echo $web['url']; ?>/_administracion/administracion_editar_noticia?id=<?php echo $row['id_articulo']; ?>" class="list-group-item">
									<?php echo $row['titulo']; ?>
								</a>
						  	<?php
						  		}
						  	}

							$pag_not = mysqli_query($conexion, "SELECT count(id_articulo) FROM noticias");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/_administracion/_administracion/administracion_noticias?pagina='.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/_administracion/administracion_noticias?pagina='.$i.'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							}
						  ?>
						</div>
					</div>

				  </div>
				</div>
				

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>