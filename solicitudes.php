<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$limite = 15;

	if(isset($_GET['pagina'])){
		$pag = $_GET['pagina'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Solicitudes de amigos</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/report_user.png"> Solicitudes de amigos 
				  	(<b><?php 

				  			$sql2 = mysqli_query($conexion, "SELECT * FROM peticiones_amistad WHERE id_receptor_pa = '$dato_u[id]' AND estado_pa = '0' ");
				  			if($sql2_m = mysqli_num_rows($sql2)){
				  				echo $sql2_m;
				  			}else{
				  				echo '0';
				  			}

				  		?></b>)</div>
				  <div class="panel-body">
				  	<?php
						if(isset($_REQUEST['id_acept']) == 'Aceptar'){
							$id_autor = $_REQUEST['id_autor'];

							mysqli_query($conexion, "UPDATE peticiones_amistad SET estado_pa = '1'
														 WHERE id_autor_pa = '$id_autor' AND id_receptor_pa = '$dato_u[id]' ");
							mysqli_query($conexion, "INSERT INTO amigos (id_usuario_1, id_usuario_2, fecha_a)
										  	  VALUES('".$id_autor."','".$dato_u['id']."','".date("Y-m-d H:i")."') ");
							mysqli_query($conexion, "INSERT INTO amigos (id_usuario_1, id_usuario_2, fecha_a)
										  	  VALUES('".$dato_u['id']."','".$id_autor."','".date("Y-m-d H:i")."') ");
							header('location:'.$web['url'].'/solicitudes');
						}

						if(isset($_REQUEST['rech_p']) == 'Rechazar'){
							$id_autor_pa = $_REQUEST['id_autor'];
							mysqli_query($conexion, "DELETE FROM peticiones_amistad
													 WHERE id_autor_pa = '$id_autor_pa' AND id_receptor_pa = '$dato_u[id]' ");
							header('location:'.$web['url'].'/solicitudes');
						}
				  	?>
				  	<div class="col-md-8">
				  	<!--
					  	<span>Capacidad de amigos <b>13/20</b>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="min-width: 5em;">
						    13/20
						  </div>
						</div>-->
						<ul class="list-group">
							<?php
								$sql = mysqli_query($conexion, "SELECT * FROM peticiones_amistad 
										JOIN usuarios ON peticiones_amistad.id_autor_pa = usuarios.id
										WHERE id_receptor_pa = '$dato_u[id]' AND estado_pa = '0' 
										ORDER BY id_p_a DESC LIMIT $inicio, $limite");

								if(mysqli_num_rows($sql) == 0){
									echo '<u><h4>Actualmente no tienes ninguna petición de amistad.</h4></u>';
								}else{

									while($row = mysqli_fetch_array($sql)){
							?>
							  <li class="list-group-item">
								<ul class="media-list">
								  <li class="media">
								    <div class="media-left">
								      <a href="#">
								        <img class="media-object img-circle" width="50" height="50" src="<?php if($row['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row['avatar']; } ?>" alt="...">
								      </a>
								    </div>
								    <div class="media-body">
								      <h4 class="media-heading">¡<a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a> quiere ser tu amigo!</h4>
								      	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								      		<input type="hidden" name="id_autor" value="<?php echo $row['id_autor_pa']; ?>" />
								      		<input type="submit" name="id_acept" value="Aceptar" class="btn btn-success btn-xs" /> o <input type="submit" name="rech_p" value="Rechazar" class="btn btn-danger btn-xs" />
								    	</form>
								    </div>
								  </li>
								</ul>
							  </li><br/>
							<?php
									}
								}
							?>
						</ul>

						<?php
							$pag_not = mysqli_query($conexion, "SELECT count(id_p_a) FROM peticiones_amistad WHERE id_receptor_pa = '$dato_u[id]' AND estado_pa = '0' ");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/solicitudes/'.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/solicitudes/'.$i.'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							} 
						?>
				  </div>

				  <?php
				  	if(isset($_GET['borrar_amigo'])){

					  	mysqli_query($conexion, "DELETE FROM amigos WHERE id_usuario_1 = '$dato_u[id]'
					  							 AND id_usuario_2 = '$_GET[borrar_amigo]' ");
					  	mysqli_query($conexion, "DELETE FROM amigos WHERE id_usuario_1 = '$_GET[borrar_amigo]'
					  							 AND id_usuario_2 = '$dato_u[id]' ");
					  	mysqli_query($conexion, "DELETE FROM peticiones_amistad 
					  							 WHERE id_autor_pa = '$_GET[borrar_amigo]' AND id_receptor_pa = '$dato_u[id]'
					  							 OR  id_autor_pa = '$dato_u[id]' AND id_receptor_pa = '$_GET[borrar_amigo]'");
					  	header("Location: solicitudes");
				  	}
				  ?>
				  
				  <div class="col-md-4">
				  	<ul class="list-group">
					  <li class="list-group-item">
					    Amigos agregados: <b><?php
					    	$sql_rec = mysqli_query($conexion, "SELECT * FROM amigos
					    										WHERE id_usuario_1 = '$dato_u[id]' ");
					    	if($most_rec = mysqli_num_rows($sql_rec)){
					    		echo $most_rec;
					    	}else{
					    		echo '0';
					    	}
					    ?></b>
					  </li>
					  <?php
					  	$sql_ver = mysqli_query($conexion, "SELECT * FROM amigos
					  										JOIN usuarios ON amigos.id_usuario_2 = usuarios.id
					  										WHERE id_usuario_1 = '$dato_u[id]' ");
					  	if(mysqli_num_rows($sql_ver) == 0){
					  		echo '<li class="list-group-item text-center"><h4><u>No tienes amigos</u></h4></li>';
					  	}else{

					  		while($row3 = mysqli_fetch_array($sql_ver)){
					  ?>
						  <li class="list-group-item">
						  	<a style="float:right;" href="<?php echo $web['url']; ?>/solicitudes?borrar_amigo=<?php echo intval($row3['id']); ?>"><img src="<?php echo $web['url']; ?>/img/iconos/user_delete.png"> Borrar</a>
						    
						    <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row3['usuario']; ?>">
							<img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row3['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row3['avatar']; } ?>" alt="...">
							<?php echo $row3['usuario']; ?></a>
						  </li>
					  <?php
					  		}
					  	}
					  ?>
					</ul>
				  </div>

				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>