		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="author" content="CoalsPlay">
		<meta name="description" content="<?php echo $web['descripcion']; ?>">

		<link rel="shortcut icon" href="<?php echo $web['url']; ?>/img/favicon.ico" />
		
		<!-- SCM Music Player http://scmplayer.net -->
		<script type="text/javascript" src="http://scmplayer.net/script.js" 
		data-config="{'skin':'skins/tunes/skin.css','volume':12,'autoplay':<?php if($dato_u['autoplay'] == 0){ echo 'false';}elseif($dato_u['autoplay'] == 1){ echo 'true'; } ?>,'shuffle':false,'repeat':1,'placement':'bottom','showplaylist':false,'playlist':[{'title':'Melodía 1','url':'<?php echo $web['url']; ?>/BGM/bgm.mp3'}]}" ></script>
		<!-- SCM Music Player script end -->

		
		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo $web['url']; ?>/css/<?php if(isset($_SESSION['login'])){ echo $dato_u['theme']; } else { echo "lumen.css"; } ?>" />
	</head>
	<body style="background: url('<?php echo $web['url']; ?>/img/bg.png');">
		<?php if(isset($_SESSION['login'])) { ?>
		<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container"> <!-- Cont -->
			
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo $web['url']; ?>/"><?php echo $web['nombre']; ?><span class="text-danger"></span></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li><a href="<?php echo $web['url']; ?>/"><img src="<?php echo $web['url']; ?>/img/iconos/house.png"> Inicio <span class="sr-only">(current)</span></a></li>
				<li><a href="<?php echo $web['url']; ?>/tienda"><img src="<?php echo $web['url']; ?>/img/iconos/cart.png"> Tienda</a></li>
				<li><a href="<?php echo $web['url']; ?>/inventario"><img src="<?php echo $web['url']; ?>/img/iconos/briefcase.png"> Inventario</a></li>
				<li><a href="<?php echo $web['url']; ?>/mapa"><img src="<?php echo $web['url']; ?>/img/iconos/map.png"> Mapa</a></li>
				<li class="dropdown">
				  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="<?php echo $web['url']; ?>/img/iconos/picture.png"> Información del juego <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo $web['url']; ?>/top"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> Top 10</a></li>
					<li><a href="<?php echo $web['url']; ?>/cementerio"><img src="<?php echo $web['url']; ?>/img/iconos/muerte.png"> Cementerio</a></li>
					<li><a href="<?php echo $web['url']; ?>/mobs"><img src="<?php echo $web['url']; ?>/img/iconos/bug.png"> Lista de monstruos</a></li>
					<li><a href="<?php echo $web['url']; ?>/usuarios"><img src="<?php echo $web['url']; ?>/img/iconos/list_users.gif"> Usuarios</a></li>
					<li><a href="<?php echo $web['url']; ?>/staff"><img src="<?php echo $web['url']; ?>/img/iconos/icon_security.gif"> Staff</a></li>
				  </ul>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img style="position:relative; top:-4px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($dato_u['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $dato_u['avatar']; } ?>" alt="...">&nbsp; <?php echo $dato_u['usuario']; ?> <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo $web['url']; ?>/perfil/<?php echo $dato_u['usuario']; ?>"><img src="<?php echo $web['url']; ?>/img/iconos/icon_user.gif"> Mi Perfil</a></li>
					<li><a href="<?php echo $web['url']; ?>/bandeja_de_entrada"><img src="<?php echo $web['url']; ?>/img/iconos/email.png"> Mensajes privados (<b><?php $sql_num_mp = mysqli_query($conexion, "SELECT * FROM mensajes_privados WHERE nombre_receptor = '$dato_u[usuario]' AND estado_mp = '0' "); echo mysqli_num_rows($sql_num_mp); ?></b>)</a></li>
					<li><a href="<?php echo $web['url']; ?>/solicitudes"><img src="<?php echo $web['url']; ?>/img/iconos/report_user.png"> Amigos y Peticiones 
					(<b><?php 

				  			$sql2 = mysqli_query($conexion, "SELECT * FROM peticiones_amistad WHERE id_receptor_pa = '$dato_u[id]' AND estado_pa = '0' ");
				  			if($sql2_m = mysqli_num_rows($sql2)){
				  				echo $sql2_m;
				  			}else{
				  				echo '0';
				  			}

				  		?></b>)</a></li>
					<li><a href="<?php echo $web['url']; ?>/configuracion"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Configuración</a></li>
					<li><a href="<?php echo $web['url']; ?>/reporte"><img src="<?php echo $web['url']; ?>/img/iconos/bug_add.png"> Reportar Bug</a></li>
					<li><a href="<?php echo $web['url']; ?>/sugerir"><img src="<?php echo $web['url']; ?>/img/iconos/add_sug.png"> Crear Sugerencia</a></li>
					<!--<li><a href="<?php echo $web['url']; ?>/faq"><img src="<?php echo $web['url']; ?>/img/iconos/book.png"> FAQ</a></li>-->
					<li class="divider"></li>
					<?php if($dato_u['rango'] == 1 or $dato_u['rango'] == 2 or $dato_u['rango'] == 3){ echo '<li><a href="'.$web['url'].'/_administracion/administracion"><img src="'.$web['url'].'/img/iconos/admin_go.png"> <span class="text-danger">Administración</span></a></li>'; } ?>
					<li class="divider"></li>
					<li><a href="<?php echo $web['url']; ?>/desconectar" onClick="alert('Te has desconectado con éxito.')"><img src="<?php echo $web['url']; ?>/img/iconos/door_in.png"> Desconectar</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
		  </div>
		</nav><br/><br/><br/><br/>
		<?php }else { ?>
		<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container"> <!-- Cont -->
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo $web['url']; ?>/"><?php echo $web['nombre']; ?> -<small> Alpha</small></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li><a href="<?php echo $web['url']; ?>/"><img src="<?php echo $web['url']; ?>/img/iconos/house.png"> Inicio <span class="sr-only">(current)</span></a></li>
				<li><a href="<?php echo $web['url']; ?>/registro"><img src="<?php echo $web['url']; ?>/img/iconos/user_add.png"> Registro</a></li>
				<li><a href="<?php echo $web['url']; ?>/top"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> Top</a></li>
				<li><a href="<?php echo $web['url']; ?>/staff"><img src="<?php echo $web['url']; ?>/img/iconos/icon_security.gif"> Staff</a></li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Visitante <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo $web['url']; ?>/login"><img src="<?php echo $web['url']; ?>/img/iconos/door_in.png"> Conectarse</a></li>
					<li><a href="<?php echo $web['url']; ?>/registro"><img src="<?php echo $web['url']; ?>/img/iconos/user_add.png"> Registrarse</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
		  </div>
		</nav><br/><br/><br/><br/>
		<?php } ?>
		</div>