<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$usuario = $_GET['usuario'];
	$sql_pu = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario' ");
	$ejec = mysqli_fetch_array($sql_pu);
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Perfil de <?php echo $ejec['usuario']; ?></title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">


				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/page_user.gif"> Perfil de <?php echo $ejec['usuario']; ?></div>
				  <div class="panel-body">
					<?php
						if(mysqli_num_rows($sql_pu) == 0){
							echo '<center><img src="'.$web['url'].'/img/iconos/error.png"> <h3>El perfil que está buscando no existe.<br/><br/>
									 <a href="javascript:history.back(1)">Volver atrás</a></center>';
						}else{
					?>
						<div class="page-header">
						  <?php
						  	if(isset($_POST['env_p_a'])){

						  		$env_peti = "INSERT INTO peticiones_amistad (id_autor_pa, id_receptor_pa, fecha_pa, estado_pa)
						  					 VALUES('".$dato_u['id']."','".$ejec['id']."','".date("Y-m-d H:i")."','0') ";
						  		mysqli_query($conexion, $env_peti);
						  	}
						  ?>
						  <h1>Perfil - <small><?php echo $ejec['usuario']; ?></small></h1>
						</div>
						<div class="row">

							<div class="col-md-3" style="word-wrap: break-word;">
								<center><img width="150" height="150" src="<?php if($ejec['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ejec['avatar']; } ?>" alt=""></center><br/>
								<?php
									if(isset($_SESSION['login'])){

										$sql_comp = mysqli_query($conexion, "SELECT * FROM peticiones_amistad 
													  						 WHERE 
													  						 (id_autor_pa='$dato_u[id]' AND id_receptor_pa='$ejec[id]')
													  						 OR
													  						 (id_autor_pa='$ejec[id]' AND id_receptor_pa='$dato_u[id]')
													  						 AND estado_pa = '0' ");
								  		
								  		$sql_comp2 = mysqli_query($conexion, "SELECT * FROM amigos
								  											  WHERE
													  						 id_usuario_1='$dato_u[id]' AND id_usuario_2='$ejec[id]' ");
										if($ejec['id'] === $dato_u['id']){
											echo NULL;
										}elseif(mysqli_num_rows($sql_comp2) == 1){
											echo '<center><button disabled name="env_p_a" class="btn btn-primary btn-xs">Ya sois amigos</button></center>';
										}elseif(mysqli_num_rows($sql_comp) == 1){
											echo '<center><button disabled name="env_p_a" class="btn btn-default btn-xs">Pendiente...</button></center>';
										}else{
											echo '<center><form method="post" action="">
													<button type="submit" name="env_p_a" class="btn btn-success btn-xs">Añadir a amigos</button>
													</form></center>';
										}
								  	
									}else{
										echo NULL;
									}
									
								?>
								<hr/>
								<span style="font-size:16pt;"><?php echo $ejec['usuario']; ?></span> 
								<!--<?php
									if(mysqli_query($conexion, "SELECT * FROM usuarios WHERE time >= '$tiempo_p' WHERE id = '$ejec[id]' ")){
										echo '<span class="text-success"> ●</span>';
									}else{
										echo '<span class="text-danger"> ●</span>';
									}
								?>--><br/>
								<span style="font-size:14pt;"><u>Sobre mi</u></span><br/>
								<span><?php if($ejec['sobre_mi'] == NULL){ echo 'Dato no especificado.'; } ?><?php echo $ejec['sobre_mi']; ?></span><br/><br/>
								<span style="font-size:14pt;"><u>Género</u></span><br/>
						        <?php
						        	if($ejec['genero'] == 1 ){
						        		echo '<img src="'.$web['url'].'/img/iconos/male.png"> Masculino ';
						        	}

						        	if($ejec['genero'] == 2){
						        		echo '<img src="'.$web['url'].'/img/iconos/female.png"> Femenino ';
						        	}

						        	if($ejec['genero'] == 0){
						        		echo 'Dato no especificado.';
						        	}
						        ?><br/><br/>
								 <span style="font-size:14pt;"><u>Redes sociales</u></span><br/>
						        <?php
						        	if($ejec['twitter'] != NULL ){
						        		echo '<a href="https://twitter.com/'.$ejec['twitter'].'"><img src="'.$web['url'].'/img/redsocial/tw.png"></a> ';
						        	}else{
						        		echo NULL;
						        	}

						        	if($ejec['facebook'] != NULL ){
						        		echo '<a href="https://facebook.com/'.$ejec['facebook'].'"><img src="'.$web['url'].'/img/redsocial/fb.png"></a> ';
						        	}else{
						        		echo NULL;
						        	}

						        	if($ejec['youtube'] != NULL ){
						        		echo '<a href="https://www.youtube.com/user/'.$ejec['youtube'].'"><img src="'.$web['url'].'/img/redsocial/yt.png"></a> ';
						        	}else{
						        		echo NULL;
						        	}

						        	if($ejec['twitter'] && $ejec['facebook'] && $ejec['youtube'] == NULL){
						        		echo 'Dato no especificado.';
						        	}
						        ?>
								<br/><br/>
							</div>
							<div class="col-md-9">
								<div class="panel panel-default">
								  <div class="panel-body">
								  	<?php
								  		$sql10 = mysqli_query($conexion, "SELECT * FROM arenas WHERE id_usuario_arena1 = '$ejec[id]' OR id_usuario_arena2 = '$ejec[id]' OR id_usuario_arena1 = '$dato_u[id]' OR id_usuario_arena2 = '$dato_u[id]' ");

								  		if($ejec['id'] == $dato_u['id']){
								  			echo NULL;
								  		}elseif($dato_u['salud'] == 0){
								  			echo '<script> function restringir(){ alert("No tienes Salud para poder combatir."); }</script>
									  		<button type="submit" onclick="restringir()" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									  		<br/><br/><hr/>';
								  		}elseif($dato_u['energia'] == 0){
								  			echo '<script> function restringir(){ alert("No tienes Energía para poder combatir."); }</script>
									  		<button type="submit" onclick="restringir()" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									  		<br/><br/><hr/>';
								  		}elseif($ejec['salud'] == 0){
								  			echo '<script> function restringir(){ alert("El usuario con el que quiere combatir no tiene Salud para poder combatir."); }</script>
									  		<button type="submit" onclick="restringir()" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									  		<br/><br/><hr/>';
								  		}elseif($ejec['energia'] < 5){
								  			echo '<script> function restringir(){ alert("El usuario con el que quiere combatir no tiene Energía para poder combatir."); }</script>
									  		<button type="submit" onclick="restringir()" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									  		<br/><br/><hr/>';
								  		}elseif($dato_u['nivel'] - $ejec['nivel'] > $game['int_lvl']){
								  			echo '<script> function restringir(){ alert("Hay una diferencia de '.$game['int_lvl'].' o más niveles. No puedes combatir."); }</script>
									  		<button type="submit" onclick="restringir()" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									  		<br/><br/><hr/>';
									  	}else{
									  		if(isset($_POST['crear_arena'])){
									  			$rest_e = $dato_u['energia'] - 5;
									  			mysqli_query($conexion, "UPDATE usuarios SET energia = '$rest_e' WHERE id = '$dato_u[id]' ");
									  			mysqli_query($conexion, "INSERT INTO arenas (id_usuario_arena1, id_usuario_arena2, atk_arena, hp_arena, max_hp_arena, sp_arena, max_sp_arena)
									  									 VALUES ('$dato_u[id]','$ejec[id]','$ejec[ataque]','$ejec[salud]','$ejec[max_salud]','$ejec[energia]','$ejec[max_energia]') ");
									  			header('location: '.$web['url'].'/arena');
									  		}

									  		if(mysqli_num_rows($sql10) == 1){
									  ?>
									  		<button type="submit" disabled="disabled" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-hourglass"></span> &nbsp;&nbsp;En combate...</button></form>
									  		<br/><br/><hr/>
									  	<?php
									  		}else{
									  	?>
									  		<form method="post" action="<?php echo $web['url']; ?>/perfil/<?php echo $ejec['usuario']; ?>">
									  		<button type="submit" name="crear_arena" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button></form>
									  		<br/><br/><hr/>
									  	<?php
									  		}
								  		}
								  		?>
			
									<ul class="nav nav-tabs">
									  <li class="active"><a href="#informacion" data-toggle="tab" aria-expanded="true">Información</a></li>
									  <li class=""><a href="#amigos" data-toggle="tab" aria-expanded="false">Amigos 
									  	(<b>
										<?php
									    	$sql_rec = mysqli_query($conexion, "SELECT * FROM amigos
									    										WHERE id_usuario_1 = '$ejec[id]' ");
									    	if($most_rec = mysqli_num_rows($sql_rec)){
									    		echo $most_rec;
									    	}else{
									    		echo '0';
									    	}
					    				?>
									    </b>)</a>
									  </li>
									  <li class=""><a href="#estadisticas" data-toggle="tab" aria-expanded="false">Estadísticas</a></li>
									</ul>
									<div id="myTabContent" class="tab-content">
									  <div class="tab-pane fade active in" id="informacion">
									  		<br/>
											<ul class="list-group">
											  <li class="list-group-item">
												<img src="<?php echo $web['url']; ?>/img/iconos/user_red.png"> Rango:&nbsp;
												<?php 
													if($ejec['rango'] == 1){
														echo ' <span class="label label-danger">Administrador</span>'; 
													}elseif($ejec['rango'] == 2){
														echo ' <span class="label label-success">Moderador</span>';
													}elseif($ejec['rango'] == 3){
														echo ' <span class="label label-primary">Colaborador</span>';
													}elseif($ejec['rango'] == 0){
														echo ' <span class="label label-default">Normal</span>';
													} ?>
											  </li>
											  <li class="list-group-item">
											   <img src="<?php echo $web['url']; ?>/img/iconos/rosette.png"> Nivel <b><?php echo $ejec['nivel']; ?></b>
											  	<?php
											  		if($ejec['nivel'] == $game['max_lvl']){
														echo ' &nbsp;&nbsp; <span class="label label-danger">MÁX</span>';
													}else{
														echo NULL;
													}
											  	?>
											  </li>
											  <!--<li class="list-group-item">
												<?php 
													if($ejec['insignia'] == 1){ 
														echo '<img src="'.$web['url'].'/img/iconos/medal.png"> Bronce';
													}elseif($ejec['insignia'] == 2){ 
														echo '<img src="'.$web['url'].'/img/iconos/medal_silver_1.png"> Plata'; 
													}elseif($ejec['insignia'] == 3){
														echo '<img src="'.$web['url'].'/img/iconos/medal_gold_1.png"> Oro'; 
													}
												?> 
											  </li>-->
											  <li class="list-group-item">
											    <img src="<?php echo $web['url']; ?>/img/iconos/coins.png"> Oro: <b><?php echo $ejec['oro']; ?></b>
											  </li>	  
											  <li class="list-group-item">
											    <img src="<?php echo $web['url']; ?>/img/iconos/exp.png"> Experiencia: <b><?php echo $ejec['exp']; ?></b>
											  </li>
											  <!--<li class="list-group-item">
											    <img src="<?php echo $web['url']; ?>/img/iconos/shield.png"> Defensa: <b><?php echo $ejec['defensa']; ?></b>
											  </li>-->
											  <li class="list-group-item">
											    <img src="<?php echo $web['url']; ?>/img/iconos/attack.png"> Ataque: <b><?php echo $ejec['ataque']; ?></b>
											  </li>
											</ul>
									  </div>

									  <div class="tab-pane fade" id="amigos">
									  	<br/>
									  	<ul class="list-group">
										  <?php
										  	$sql_ver = mysqli_query($conexion, "SELECT * FROM amigos
										  										JOIN usuarios ON amigos.id_usuario_2 = usuarios.id
										  										WHERE id_usuario_1 = '$ejec[id]' ");
										  	if(mysqli_num_rows($sql_ver) == 0){
										  		echo '<li class="list-group-item text-center"><h4><u>Este usuario no tiene amigos actualmente.</u></h4></li>';
										  	}else{

										  		while($row3 = mysqli_fetch_array($sql_ver)){
										  ?>
											  <li class="list-group-item">
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

									  <div class="tab-pane fade" id="estadisticas">
									  	<br/>
										<ul class="list-group">
										  <li class="list-group-item">
										    <img src="<?php echo $web['url']; ?>/img/iconos/objetive.png"> Mobs o usuarios asesinados: <b><?php echo $ejec['bajas']; ?></b>
										  </li>
										  <li class="list-group-item">
										    <img src="<?php echo $web['url']; ?>/img/iconos/muerte.png"> Veces muerto: <b><?php echo $ejec['muertes']; ?></b>
										  </li>
										</ul>
									  </div>
									</div>


								  </div>
								</div>
							</div>
						</div>

					<?php
						}
					?>
				  </div>
				</div>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>