				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Opciones</div>
				  <div class="panel-body">
					<div class="list-group">
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/house.png">&nbsp;&nbsp; Inicio
					  </a>
					  <?php
					  	if($dato_u['rango'] == 1){
					  ?>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_configuracion" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/cog.png">&nbsp;&nbsp; Configuraciones
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_opciones" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/wrench.png">&nbsp;&nbsp; Opciones del juego
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_usuarios" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/vcard.png">&nbsp;&nbsp; Gestor de usuarios
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_rango" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/icon_security.gif">&nbsp;&nbsp; Gestor de Rangos
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_tienda" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/cart_edit.png">&nbsp;&nbsp; Gestor de tienda
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_mobs" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/bomb.png">&nbsp;&nbsp; Gestor de Mobs
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_noticias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_bugs" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/bug_error.png">&nbsp;&nbsp; Bugs Tracker
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_sugerencias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/sug.png">&nbsp;&nbsp; Sugerencias
					  </a>
					  <?php
					  	}

					  	if($dato_u['rango'] == 2){

					  ?>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_tienda" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/cart_edit.png">&nbsp;&nbsp; Gestor de tienda
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_mobs" class="list-group-item">
					    <img src="<?php echo $web['url']; ?>/img/iconos/bomb.png">&nbsp;&nbsp; Gestor de Mobs
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_noticias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_bugs" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/bug_error.png">&nbsp;&nbsp; Bugs Tracker
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_sugerencias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/sug.png">&nbsp;&nbsp; Sugerencias
					  </a>
					  <?php
					  	}

					  	if($dato_u['rango'] == 3){
					  ?>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_noticias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/page_white_edit.png">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_bugs" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/bug_error.png">&nbsp;&nbsp; Bugs Tracker
					  </a>
					  <a href="<?php echo $web['url']; ?>/_administracion/administracion_sugerencias" class="list-group-item">
					  	<img src="<?php echo $web['url']; ?>/img/iconos/sug.png">&nbsp;&nbsp; Sugerencias
					  </a>  
					  <?php
					  	}
					  ?>
					</div>
				  </div>
				</div>