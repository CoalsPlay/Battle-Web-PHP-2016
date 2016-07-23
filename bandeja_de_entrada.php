<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$limite = 10;

	if(isset($_GET['mensajes'])){
		$pag = $_GET['mensajes'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Bandeja de entrada</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/email.png"> Panel de mensajería</div>
				  <div class="panel-body">
					<div class="list-group">
					  <a href="<?php echo $web['url']; ?>/bandeja_de_entrada" class="list-group-item active">
					    <img src="<?php echo $web['url']; ?>/img/iconos/email.png">&nbsp;&nbsp; Bandeja de entrada 
					    (<b><?php 
					    		$sql_num_mp = mysqli_query($conexion, "SELECT * FROM mensajes_privados WHERE nombre_receptor = '$dato_u[usuario]' AND estado_mp = '0' "); 
					    		if($most = mysqli_num_rows($sql_num_mp)){
					    			echo $most; 
					    		}else{
					    			echo '0';
					    		}
					    	?></b>)
					  </a>
					  <a href="<?php echo $web['url']; ?>/mensajes_enviados" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/email.png">&nbsp;&nbsp; Mensajes enviados
					  </a>
					  <a href="<?php echo $web['url']; ?>/crear_mensaje" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/email_add.png">&nbsp;&nbsp; Enviar mensaje
					  </a>
					</div>
				  </div>
				</div>
				
				<?php include('plantilla/box_stats.php'); ?>

				<?php include('plantilla/box_social.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/email.png"> Bandeja de entrada (<b>0</b>)</div>
				  <div class="panel-body">
					<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <th>Estado</th>
					      <th>Asunto</th>
					      <th>De</th>
					      <th>Fecha</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php
					  		$sql = mysqli_query($conexion, "SELECT * FROM mensajes_privados
					  										JOIN usuarios ON mensajes_privados.id_autor_mp = usuarios.id
					  										WHERE nombre_receptor = '$dato_u[usuario]'
					  										ORDER BY id_mp DESC LIMIT $inicio, $limite");
					  		if(mysqli_num_rows($sql) == 0){

					  			echo '<center><h3>No tienes ningún mensaje.</h3></center><br/>';
					  		}else{

					  			while($row = mysqli_fetch_array($sql)){
					  	?>
					    <tr>
					      <td>
					      	<?php
					      		if($row['estado_mp'] == 0){
									echo '<img src="'.$web['url'].'/img/iconos/email.png" title="Sin leer">';
								}else{
									echo '<img src="'.$web['url'].'/img/iconos/email_open.png" title="Leído">';
								}
					      	?>
					      </td>
					      <td><a href="#mensaje<?php echo $row['id_mp']; ?>"><?php echo $row['titulo_mp']; ?></a></td>
					      <td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
					      <td><?php echo $row['fecha_mp']; ?></td>
					    </tr>
					  	<?php
					  			}
					  		}
					  	?>
					  </tbody>
					</table>
						<?php
					  		$sql2 = mysqli_query($conexion, "SELECT * FROM mensajes_privados
					  										JOIN usuarios ON mensajes_privados.id_autor_mp = usuarios.id
					  										WHERE nombre_receptor = '$dato_u[usuario]'
					  										ORDER BY id_mp DESC LIMIT $inicio, $limite");
					  		$sql3 = mysqli_query($conexion, "UPDATE mensajes_privados SET estado_mp = '1' WHERE nombre_receptor = '$dato_u[usuario]' ");							
							while($row2 = mysqli_fetch_array($sql2)){
						?>
							<div class="panel panel-default" id="#mensaje<?php echo $row2['id_mp']; ?>">
							  <div class="panel-heading"><u><h4><?php echo $row2['titulo_mp']; ?></h4></u></div>
							  <div class="panel-body" style="word-wrap: break-word;">
						    	<?php echo $row2['texto_mp']; ?>
							  </div>
							  <div class="panel-footer">
							  	<small><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row2['usuario']; ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row2['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row2['avatar']; } ?>" alt="..."> <?php echo $row2['usuario']; ?></a>&nbsp; el:&nbsp; <i><?php echo $row2['fecha_mp'] ?></i></small>
							  </div>
							</div>
						<?php
							}

							$pag_not = mysqli_query($conexion, "SELECT count(id_mp) FROM mensajes_privados WHERE nombre_receptor = '$dato_u[usuario]' ");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/bandeja_de_entrada/'.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/bandeja_de_entrada/'.$i.'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							}
					?>
				  </div>
				</div>
				
				<?php include('plantilla/box_changelog.php'); ?>

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>