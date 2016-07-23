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

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Lista de usuarios</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/list_users.gif"> Lista de usuarios</div>
				  <div class="panel-body">
					<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal">
					  <div class="input-group">
					    <input type="search" name="busqueda" placeholder="Buscar usuario..." class="form-control">
					    <span class="input-group-btn">
					      <input class="btn btn-primary" name="buscar" value="Buscar" type="submit">
					    </span>
					  </div>
					</form>
					<br/>
				  	<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <!--<th>Estado</th>-->
					      <th>Usuario</th>
					      <th>Nivel</th>
					      <th>Redes sociales</th>
					    </tr>
					  </thead>
					  <tbody>
				  	<?php
				  		if(isset($_POST['buscar'])){
				  			$busqueda = proteccion($_POST['busqueda']);
				  			$sql2 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario LIKE '%$busqueda%' ");

				  			if(empty($busqueda)){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Debes rellenar el campo.</div>";
							}

				  			if(mysqli_num_rows($sql2) == 0){
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										No existe el usuario o no se han encontrado coincidencias.</div>";
				  			}else{
				  				while($row2 = mysqli_fetch_array($sql2)){
				  	?>

					    <tr>
					      <!--<td style="position:relative; left:15px;">
					      	<?php
					      		if($row2['online'] == 1){
					      			echo '<img class="hidden-xs" src="'.$web['url'].'/img/iconos/useron.gif">';
					      		}else{
					      			echo '<img class="hidden-xs" src="'.$web['url'].'/img/iconos/useroff.gif">';
					      		}
					      	?>
					      </td>-->
					      <td><img style="position:relative; top:-1px;" width="25" height="25" class="media-object img-circle pull-left" src="<?php if($row2['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row2['avatar']; } ?>" alt="...">&nbsp;&nbsp; <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row2['usuario']; ?>"><?php echo $row2['usuario']; ?></a></td>
					      <td class="hidden-xs"><?php echo $row2['nivel']; ?></td>
					      <td>
						        <?php
						        	if($row2['twitter'] != NULL ){
						        		echo '<a href="https://twitter.com/'.$row2['twitter'].'"><img src="'.$web['url'].'/img/redsocial/tw.png"></a> ';
						        	}else{
						        		echo '';
						        	}

						        	if($row2['facebook'] != NULL ){
						        		echo '<a href="https://facebook.com/'.$row2['facebook'].'"><img src="'.$web['url'].'/img/redsocial/fb.png"></a> ';
						        	}else{
						        		echo '';
						        	}

						        	if($row2['youtube'] != NULL ){
						        		echo '<a href="https://www.youtube.com/user/'.$row2['youtube'].'"><img src="'.$web['url'].'/img/redsocial/yt.png"></a> ';
						        	}else{
						        		echo '';
						        	}
						        ?>
					      </td>
					    </tr>

				  	<?php
				  				}
				  			}
				  		}else{

					  		$sql = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id ASC LIMIT $inicio, $limite");
					  		if(mysqli_num_rows($sql) == 0){
					  			echo 'No hay ningún usuario.';
					  		}else{
					  			while($row = mysqli_fetch_array($sql)){
					?>
					    <tr>
					      <!--<td style="position:relative; left:15px;">
					      	<?php
					      		if($row['online'] == 1){
					      			echo '<img src="'.$web['url'].'/img/iconos/useron.gif">';
					      		}else{
					      			echo '<img src="'.$web['url'].'/img/iconos/useroff.gif">';
					      		}
					      	?>
					      </td>-->
					      <td><img style="position:relative; top:-1px;" width="25" height="25" class="media-object img-circle pull-left" src="<?php if($row['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row['avatar']; } ?>" alt="...">&nbsp;&nbsp; <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row['usuario']; ?>"><?php echo $row['usuario']; ?></a></td>
					      <td><?php echo $row['nivel']; ?></td>
					      <td>
						        <?php
						        	if($row['twitter'] != NULL ){
						        		echo '<a href="https://twitter.com/'.$row['twitter'].'"><img src="'.$web['url'].'/img/redsocial/tw.png"></a> ';
						        	}else{
						        		echo '';
						        	}

						        	if($row['facebook'] != NULL ){
						        		echo '<a href="https://facebook.com/'.$row['facebook'].'"><img src="'.$web['url'].'/img/redsocial/fb.png"></a> ';
						        	}else{
						        		echo '';
						        	}

						        	if($row['youtube'] != NULL ){
						        		echo '<a href="https://www.youtube.com/user/'.$row['youtube'].'"><img src="'.$web['url'].'/img/redsocial/yt.png"></a> ';
						        	}else{
						        		echo '';
						        	}
						        ?>
					      </td>
					    </tr>
					    <?php
					  			}
					  		}
					  	}
					  	?>
					  </tbody>
					</table>
				  	<?php
						$pag_not = mysqli_query($conexion, "SELECT count(id) FROM usuarios");
						$total_not = mysqli_fetch_array($pag_not);
						$total_pag = ceil(intval($total_not['0']) / $limite);

						echo '<ul class="pagination pagination-sm">';

						if ($total_pag > 1){
						    for ($i=1;$i<=$total_pag;$i++){
						       if ($pag == $i)
						          echo '<li class="active"><a href="'.$web['url'].'/usuarios?usuarios='.$i.'">'.$pag.'</a></li>';
						       else
						       		echo '<li><a href="'.$web['url'].'/usuarios/'.$i.'">'.$i.'</a></li>';
						    }

						   	echo '</ul>';
						}
				  	?>
				  </div>
				</div>

				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>