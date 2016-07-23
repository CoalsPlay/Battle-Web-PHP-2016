<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$id = $_GET['id'];
	$sql_com = mysqli_query($conexion, "SELECT * FROM noticias
										JOIN usuarios ON noticias.autor = usuarios.id
										WHERE id_articulo = '$id' ");
	$ext_com = mysqli_fetch_array($sql_com);

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Noticia</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
				<?php include('plantilla/box_stats.php'); ?>

				<?php include('plantilla/box_social.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center" style="word-wrap:break-word;"><img src="<?php echo $web['url']; ?>/img/iconos/posts.gif"> Noticias de <?php echo $web['nombre']; ?> - <b><?php echo $ext_com['titulo']; ?></b></div>
				  <div class="panel-body">
					<?php 
					if(mysqli_num_rows($sql_com) == 0){ 
						echo '<center><img src="'.$web['url'].'/img/iconos/error.png"> <h3>La noticia que está buscando no existe o ha sido eliminada.<br/><br/>
										 <a href="javascript:history.back(1)">Volver atrás</a></center>'; 
					}else{
						?>
					<div class="panel panel-default" id="<?php echo $ext_com['id_noticia']; ?>">
						<div class="panel-body" style="word-wrap: break-word;">
						  <h3><?php echo $ext_com['titulo']; ?></h3>
						  <?php echo $ext_com['texto']; ?>
						  <hr>
						  <small><a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_com['usuario']; ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_com['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_com['avatar']; } ?>" alt="..."> <?php echo $ext_com['usuario']; ?></a>&nbsp; el:&nbsp; <i><?php echo $ext_com['fecha'] ?></i></small>
						   - Comentarios <span class="badge">
					    	<?php
					    		$query_coment = mysqli_query($conexion, "SELECT count(id_noticia) FROM comentarios WHERE id_noticia = '$id'  ");
					    		$query_ext_coment = mysqli_fetch_array($query_coment);
					    			echo intval($query_ext_coment[0]);
					    	?>
							</span>
						  <hr>
						    <?php
						  		if(isset($_SESSION['login'])){

							   		if(isset($_POST['comentario'])){
							   			$text_coment = proteccion($_POST['text_coment']);
							   			$id = $_POST['id_noticia'];

								  		if(empty($text_coment)){
								  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
													Debes rellenar el campo.</div>";
								  		}elseif(strlen($text_coment) <= 3){
								  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
													Debes detallar un poco más el comentario.</div>";
								  		}else{
								  			if(mysqli_query($conexion, "INSERT INTO comentarios (text_coment, autor, fecha, id_noticia) VALUES('".$text_coment."','".$dato_u['id']."','".date("Y-m-d H:i")."','".$id."') ")){
								  				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
														Tú comentario ha sido añadido con éxito.</div><meta http-equiv='refresh' content='1; ".$web['url']."/noticia/".$id."'>";
								  			}else{
								  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
														Hubo un error en la creación del comentario.</div>";
								  			}
								  		}
							   		}
						   	
							?>
							<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
								<textarea class="form-control" style="max-width:100%;" name="text_coment" rows="2" id="textArea" placeholder="Comentario"></textarea>
								<input type="hidden" name="id_noticia" value="<?php echo $_GET['id']; ?>"><br/>
								<input type="submit" name="comentario" class="btn btn-primary" value="Comentar">
							</form>
							<hr>
							<?php
							
								$sql_mos_coment = mysqli_query($conexion, "SELECT * FROM comentarios
																		   JOIN usuarios ON comentarios.autor = usuarios.id
																		   WHERE id_noticia = '$id' 
																		   ORDER BY id_comentario DESC");

							if(mysqli_num_rows($sql_mos_coment) == 0){
								echo '<center><h3>No hay comentarios en esta noticia. ¡Sé el primer!</h3></center>';
							}else{
								while($sql_ext_coment = mysqli_fetch_array($sql_mos_coment)){
							?>
							<div class="panel panel-default">
							  <div class="panel-body">
							    <?php echo $sql_ext_coment['text_coment']; ?>
							    <hr>
							    <a href="<?php echo $web['url']; ?>/perfil/<?php echo $sql_ext_coment['usuario']; ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($sql_ext_coment['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $sql_ext_coment['avatar']; } ?>" alt="..."> <b><?php echo $sql_ext_coment['usuario']; ?></b></a> - el: <?php echo $sql_ext_coment['fecha']; ?>
							  </div>
							</div>
							<?php
								}
							}
							}else{
						    ?>
						    <center><h4>Debes estar conectado para poder comentar. <a href="<?php echo $web['url']; ?>/login">Conectarse</a> o <a href="<?php echo $web['url']; ?>/registro">Registrarse</a></h4></center>
						    <hr>
							<?php 
							}
								}

						    ?>
						</div>
					</div>
				  </div>
				</div>
				
				<?php include('plantilla/box_changelog.php'); ?>

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>