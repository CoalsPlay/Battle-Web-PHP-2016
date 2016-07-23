<?php
	##############################################
	#/											/#
	#/		Desarrollado por CoalsPlay			/#
	#/		Todos los derechos reservados		/#
	#/		Sitio: www.coalsplay.com			/#
	#/											/#
	##############################################

	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$limite = 3;

	if(isset($_GET['pagina'])){
		$pag = $_GET['pagina'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Inicio</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
			<!--<div class="alert alert-dismissible alert-warning">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <h4>Atención!</h4>
			  <p>Las barras de Salud, Exp y Energía, no funcionan según tus atributos actuales aun, es un bug que estoy pendiente de corregirlo pronto.</p>
			</div>-->
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
				<?php include('plantilla/box_stats.php'); ?>

				<?php include('plantilla/box_social.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/posts.gif"> Noticias de <?php echo $web['nombre']; ?></div>
				  <div class="panel-body">
				  	<?php

				  	$sql_not = mysqli_query($conexion, "SELECT * FROM noticias 
				  										JOIN usuarios ON noticias.autor = usuarios.id 
				  										ORDER BY id_articulo DESC LIMIT $inicio, $limite");
				  	if(mysqli_num_rows($sql_not) == 0){
				  		echo "<center><h1>No hay noticias actualmente.</h1></center>";
				  	}else{
				  		while($ext_not = mysqli_fetch_array($sql_not)){
				  	?>
					<div class="panel panel-default" id="<?php echo $ext_not['id_articulo']; ?>">
						<div class="panel-body" style="word-wrap: break-word;">
						  <a href="<?php echo $web['url']; ?>/noticia/<?php echo $ext_not['id_articulo']; ?>"><h3><?php echo $ext_not['titulo']; ?></h3></a>
						  <?php echo substr($ext_not['texto'], 0, 300); ?>... <a href="<?php echo $web['url']; ?>/noticia/<?php echo $ext_not['id_articulo']; ?>">Leer más</a>
						</div>
						<div class="panel-footer">
						  <small><a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_not['usuario']; ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_not['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_not['avatar']; } ?>" alt="..."> <?php echo $ext_not['usuario']; ?></a>&nbsp; el:&nbsp; <i><?php echo $ext_not['fecha'] ?></i></small>
						   - <a href="<?php echo $web['url']; ?>/noticia/<?php echo $ext_not['id_articulo']; ?>">Comentarios</a> <span class="badge">
					    	<?php
					    		$query_coment = mysqli_query($conexion, "SELECT count(id_comentario) FROM comentarios WHERE id_noticia = '$ext_not[id_articulo]' ");
					    		$query_ext_coment = mysqli_fetch_array($query_coment);
					    			echo intval($query_ext_coment[0]);
					    	?>
							</span>
							<?php
								if(isset($_SESSION['login'])){
									if($dato_u['rango'] == 1){
							?>
								<small class="text-left"> - <img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png"> <a href="<?php echo $web['url']; ?>/_administracion/administracion_editar_noticia?id=<?php echo $ext_not['id_articulo'];?>">Editar</a></small>
							<?php
									}
								}
							?>
						</div>
					</div>
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
						          echo '<li class="active"><a href="'.$web['url'].'/index/'.$i.'">'.$pag.'</a></li>';
						       else
						       		echo '<li><a href="'.$web['url'].'/index/'.$i.'">'.$i.'</a></li>';
						    }

						   	echo '</ul>';
						} 
				  	?>
				  </div>
				</div>
				
				<?php include('plantilla/box_changelog.php'); ?>

				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>