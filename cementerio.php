<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$limite="15";

	if(isset($_GET['fallecidos'])){
		$pag = $_GET['fallecidos'];
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
		<title><?php echo $web['nombre']; ?> - Inicio</title>
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/muerte.png"> Cementerio</div>
				  <div class="panel-body">
				  					   	Esta opción requiere <b>500</b> de Oro y <b>50</b> de Energía. Una vez revivas a un usuario a éste se le restablecerá su Salud al 100% y se te otorgará +10 Pts. de Reputación.<br/><br/>
				  	<?php
				  		if(isset($_REQUEST['revivir']) == "Revivir"){
				  			$id_f = $_REQUEST['id_f'];
				  			$usuario_f = $_REQUEST['id_u_f'];

				  			$comp_u = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$usuario_f' ");
				  			$row2 = mysqli_fetch_array($comp_u);

				  			if($dato_u['oro'] < $game['pre_cem']){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										No tienes suficiente Oro para revivir a este usuario.</div>";
				  			}elseif($dato_u['energia'] < 50){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										No tienes suficiente Energía para revivir a este usuario.</div>";
				  			}else{
					  			$rest_f = $dato_u['oro'] - $game['pre_cem'];
					  			$sum_f = $dato_u['reputacion'] + 10;
					  			$rest_e = $dato_u['energia'] - 50;

					  			$sum_s = $dato_u['salud'] + $dato_u['max_salud'];

					  			$up_u_r = mysqli_query($conexion, "UPDATE usuarios SET salud = '$sum_s' WHERE id = '$row2[id]'  ");

					  			$up_u = mysqli_query($conexion, "UPDATE usuarios 
					  											 SET oro = '$rest_f', reputacion = '$sum_f', energia = '$rest_e'
					  											 WHERE id = '$dato_u[id]' ");
					  			$text_msg = '¡Has sido revivido por <b><a href="'.$web['url'].'/perfil/'.$dato_u['usuario'].'">'.$dato_u['usuario'].'</a></b>!';
					  			$env_msg = mysqli_query($conexion, "INSERT INTO mensajes_privados (id_autor_mp, nombre_receptor, titulo_mp, texto_mp, fecha_mp, estado_mp)
				  													VALUES ('$dato_u[id]','".$row2['usuario']."','Notificación Automática','".$text_msg."','".date("Y-m-d H:i")."','0') ");
					  			$sql_r = mysqli_query($conexion, "DELETE FROM cementerio WHERE id_fallecido = '$id_f' ");
					  			echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
										Has revivido a este usuario corréctamente.</div>";
				  			}
				  		}
				  	?>
					<table class="table">
						<thead>
							<tr>
								<th>Usuario Fallecido</th>
								<th>Asesinado por</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = mysqli_query($conexion, "SELECT * FROM cementerio
																JOIN usuarios ON cementerio.id_usuario_fallecido = usuarios.id
																JOIN mobs ON cementerio.id_enemigo_asesino = mobs.id_mob
																ORDER BY id_fallecido ASC LIMIT $inicio, $limite");

								if(mysqli_num_rows($sql) == 0){
									echo "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
											No hay ningún usuario fallecido actualmente.</div>";
								}else{
									while($row = mysqli_fetch_array($sql)){
							?>
							<tr>
								<td><a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row['avatar']; } ?>" alt="..."> <?php echo $row['usuario']; ?></a></td>
								<td><b>
									<span class="text-danger">
									<?php echo $row['nombre_mob']; ?>
									</span></b></td> 
								<td>
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<input type="hidden" name="id_f" value="<?php echo $row['id_fallecido']; ?>">
										<input type="hidden" name="id_u_f" value="<?php echo $row['id_usuario_fallecido']; ?>">
										<input type="submit" name="revivir" class="btn btn-success btn-xs" value="Revivir">
									</form>
								</td> 
							</tr>
							<?php
									}
								}
							?>
						</tbody> 
					</table>				  	
					    <?php 
							$pag_not = mysqli_query($conexion, "SELECT count(id_fallecido) FROM cementerio ");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/cementerio/'.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/cementerio/'.$i.'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							}
					    ?>
					</div>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>