				<div class="panel panel-default">
				   <div class="panel-heading text-center">
				   	<?php if(isset($_SESSION['login'])){ echo '<img src="'.$web['url'].'/img/iconos/icon_user.gif"> ¡Bienvenido <b><a href="'.$web['url'].'/perfil/'.$dato_u['usuario'].'">'.$dato_u['usuario'].'</a></b>'; }else{ echo '<img src="'.$web['url'].'/img/iconos/door_in.png"> ¡Conéctate!'; } ?></b></div>
				   <div class="panel-body">
				  	<?php
				  		if(isset($_POST['envio'])){
				  			$usuario = proteccion($_POST['usuario']);
				  			$pass = proteccion($_POST['pass']);
				  			$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND passw='".md5($pass)."' ");
				  			
				  			if(empty($usuario) or empty($pass)){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar todos lo campos.</div>";
				  			}else{

				  				if(mysqli_num_rows($sql)){
				  					$_SESSION['login'] = $usuario;
									$_SESSION['inicio'] = time();
					  				mysqli_query($conexion, "UPDATE usuarios SET online = '1' WHERE usuario = '".$_SESSION['login']."' ");
									header("Location:".$_SERVER['PHP_SELF']."");

									$_SESSION['ult_acceso'] = date("Y-n-j H:i:s");


				  				}else{
				  					echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										El usuario o la contraseña no coinciden.</div>";
				  				}
				  			}
				  		}
				  	?>
				  	<?php if(isset($_SESSION['login'])){

				  		$sql_bs2 = mysqli_query($conexion, "SELECT * FROM combates
				  										JOIN mobs ON combates.id_enemigo = mobs.id_mob 
				  										WHERE id_usuario = '$dato_u[id]' ");
				  		if(mysqli_num_rows($sql_bs2)){

				  	?>
					<div class="alert alert-dismissible alert-danger">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Recordatorio</strong> Tienes un combate en proceso, puede volver dando<br/> <b><a href="<?php echo $web['url']; ?>/combate">Clic aquí</a></b>.
					</div>				  	
				  	<?php
				  		}

				  		$sql_bs3 = mysqli_query($conexion, "SELECT * FROM arenas
				  										JOIN usuarios ON arenas.id_usuario_arena1 = usuarios.id 
				  										WHERE id_usuario_arena1 = '$dato_u[id]' ");
				  		if(mysqli_num_rows($sql_bs3) == 1){

				  	?>
					<div class="alert alert-dismissible alert-danger">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Recordatorio</strong> Tienes un combate en proceso, puede volver dando<br/> <b><a href="<?php echo $web['url']; ?>/arena">Clic aquí</a></b>.
					</div>				  	
				  	<?php
				  		}

				  		$sql3 = mysqli_query($conexion, "SELECT * FROM peticiones_amistad WHERE id_receptor_pa = '$dato_u[id]' AND estado_pa = '0' ");
				  		$sql_num_mp = mysqli_query($conexion, "SELECT * FROM mensajes_privados WHERE nombre_receptor = '$dato_u[usuario]' AND estado_mp = '0' ");

				  		if(mysqli_num_rows($sql3) >= 1){
				  			$sql3_m = mysqli_num_rows($sql3);
				  			if($sql3_m == 1){
						  		echo '<div class="well well-sm">
										  <img src="'.$web['url'].'/img/iconos/user_add.png"> Tienes <b><span class="text-primary"><a href="'.$web['url'].'/solicitudes">'.$sql3_m.'</a></span></b> petición de amistad pendiente.
										</div>';
				  			}elseif($sql3_m > 1){
						  		echo '<div class="well well-sm">
										  <img src="'.$web['url'].'/img/iconos/user_add.png"> Tienes <b><span class="text-primary"><a href="'.$web['url'].'/solicitudes">'.$sql3_m.'</a></span></b> peticiones de amistad pendiente.
										</div>';				  				
				  			}
				  		}

				  		if(mysqli_num_rows($sql_num_mp) >= 1){
				  			$sql4_m = mysqli_num_rows($sql_num_mp);
				  			if($sql4_m == 1){
						  		echo '<div class="well well-sm">
										  <img src="'.$web['url'].'/img/iconos/email.png"> Tienes <b><span class="text-primary"><a href="'.$web['url'].'/bandeja_de_entrada">'.$sql4_m.'</a></span></b> mensaje privado sin leer.
										</div>';
				  			}elseif($sql4_m	> 1){
						  		echo '<div class="well well-sm">
										  <img src="'.$web['url'].'/img/iconos/email.png"> &nbsp;Tienes <b><span class="text-primary"><a href="'.$web['url'].'/bandeja_de_entrada">'.$sql4_m.'</a></span></b> mensajes privados sin leer.
										</div>';				  				
				  			}
						}
				  	?>
						<ul class="list-group">
						  <li class="list-group-item">
					  		<?php
					  			if($dato_u['pts_atributos'] > 0){

					  				echo '<span class="badge" style="background:green;">'.$dato_u['pts_atributos'].'</span>';
					  			}else{
					  				echo '<span class="badge" style="background:red;">'.$dato_u['pts_atributos'].'</span>';
					  			}
					  		?>
						    <img src="<?php echo $web['url']; ?>/img/iconos/upgrade.png">
						    <a href="<?php echo $web['url']; ?>/atributos">Puntos de atributos</a>
						  </li>
						  <li class="list-group-item">
							<img src="<?php echo $web['url']; ?>/img/iconos/rosette.png"> Nivel: <b><?php echo $dato_u['nivel']; ?></b>		 	 
						  	<?php
						  		if($dato_u['nivel'] == $game['max_lvl']){
									echo ' &nbsp;&nbsp; <span class="label label-danger">MÁX</span>';
								}else{
									echo NULL;
								}
						  	?>
						  </li>
						  <!--<li class="list-group-item">
							<?php 
								if($dato_u['insignia'] == 1){ 
									echo '<img src="'.$web['url'].'/img/iconos/medal.png"> Bronce';
								}elseif($dato_u['insignia'] == 2){ 
									echo '<img src="'.$web['url'].'/img/iconos/medal_silver_1.png"> Plata'; 
								}elseif($dato_u['insignia'] == 3){
									echo '<img src="'.$web['url'].'/img/iconos/medal_gold_1.png"> Oro'; 
								}
							?> 
						  </li>-->
						  <li class="list-group-item">
							<img src="<?php echo $web['url']; ?>/img/iconos/coins.png"> Oro: <b><?php echo $dato_u['oro']; ?></b>
						  </li>
						  <li class="list-group-item">
							<img src="<?php echo $web['url']; ?>/img/iconos/exp.png"> Experiencia: <b><span class="text-success"><?php echo $dato_u['exp']; ?></span></b>/<b> <span class="text-success"><?php echo $dato_u['max_exp']; ?></span></b><br/>
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-success " title="<?php echo $dato_u['exp']; ?> puntos de Experiencia" style="width:<?php echo porCiento($dato_u['exp'], $dato_u['max_exp']); ?>%; max-width:100%;">
							  	<b><?php echo round(porCiento($dato_u['exp'], $dato_u['max_exp'])); ?>%</b>
							  </div>
							</div> 	 
						  </li>
						  <li class="list-group-item">
						    </span>
						    <img src="<?php echo $web['url']; ?>/img/iconos/heart.png"> Salud: <b><span class="text-danger"><?php echo $dato_u['salud']; ?></span></b>/<b><span class="text-danger"><?php echo $dato_u['max_salud']; ?></span></b> HP
							<div class="progress progress-striped active" style="position:relative; bottom:-10px;">
							  <div class="progress-bar progress-bar-danger " title="<?php echo $dato_u['salud']; ?>/<?php echo $dato_u['max_salud']; ?> HP" style="width:<?php echo porCiento($dato_u['salud'], $dato_u['max_salud']); ?>%; max-width:100%;">
							  	<b><?php echo $dato_u['salud']; ?>/<?php echo $dato_u['max_salud']; ?> HP</b>
							  </div>
							</div> 
						  </li>
						  <li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/energia.png"> Energia: <b><span class="text-primary"><?php echo $dato_u['energia']; ?></span></b>/<b><span class="text-primary"><?php echo $dato_u['max_energia']; ?></span></b>
							<div class="progress progress-striped active" style="position:relative; bottom:-10px; width:100%; max-width:100%;" >
							  <div class="progress-bar progress-bar-primary " title="<?php echo $dato_u['energia']; ?>/<?php echo $dato_u['max_energia']; ?> de Energía" style="width:<?php echo porCiento($dato_u['energia'], $dato_u['max_energia']); ?>%; max-width:100%;">
							  	<b><?php echo $dato_u['energia']; ?>/<?php echo $dato_u['max_energia']; ?></b>
							  </div>
							</div>
						  </li>
						  <!--<li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/shield.png"> Defensa: <b><?php echo $dato_u['defensa']; ?></b>
						  </li>-->
						  <li class="list-group-item">
						    <img src="<?php echo $web['url']; ?>/img/iconos/attack.png"> Ataque: <b><?php echo $dato_u['ataque']; ?></b>
						  </li>
						</ul>
					  	<?php }else{ ?>
					  			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
									<input type="text" name="usuario" class="form-control" id="inputEmail" placeholder="Usuario"><br/>
									<input type="password" name="pass" class="form-control" id="inputEmail" placeholder="Contraseña"><br/>
									<a href="<?php echo $web['url']; ?>/registro">¡Registrate!</a><br/>
									<a href="<?php echo $web['url']; ?>/recuperar_pass">¿Contraseña perdida?</a><br/><br/>
									<button type="submit" name="envio" class="btn btn-primary">Conectar</button><!--&nbsp;&nbsp; <input type="checkbox"> Recordarme-->
								</form>
						<?php } ?>
						</div>
					</div>