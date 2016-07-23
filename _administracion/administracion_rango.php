<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 3 or $dato_u['rango'] == 2){ header('location: '.$web['url'].'/_administracion/administracion'); }

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Administración</title>
		<?php include('../plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_opciones.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/icon_security.gif"> Administración - Gestor de Rangos</div>
				  <div class="panel-body">
				  	<div class="col-md-6">
				  	<?php
				  		if(isset($_POST['dar_r']) == 'Actualizar rango'){
				  			$u_rango = proteccion($_POST['usuario_rango']);
				  			$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$u_rango' ");
				  			$row = mysqli_fetch_array($sql);
				  			$rango = $_POST['rango_u'];

				  			if($row['rango'] == $rango){
				  				echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
										No puedes asignar el mismo rango a un usuario.</div>';
				  			}elseif(empty($u_rango)){
				  				echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
										Debes especificar un usuario.</div>';
				  			}elseif(mysqli_num_rows($sql) == 0){
				  				echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
										El usuario que ha especificado no existe.</div>';
				  			}else{
				  				mysqli_query($conexion, "UPDATE usuarios SET rango='$rango' WHERE id='$row[id]' ");
				  				echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
										El rango se ha actualizado correctamente.</div>';
				  			}
				  		}
				  	?>
				  	 <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				        <label for="rango" class="col-lg-2 control-label">Usuario</label>
				        <input type="text" name="usuario_rango" class="form-control" id="rango" placeholder="Usuario"><br/>

				        <label for="select" class="col-lg-2 control-label">Rango</label>
				        <select class="form-control" id="select" name="rango_u">
				          <option value="1">Administrador</option>
				          <option value="2">Moderador</option>
				          <option value="3">Colaborador</option>
				          <option value="0">Normal</option>
				        </select><br/>

				        <input type="submit" style="width:100%;" class="btn btn-primary" value="Actualizar rango" name="dar_r">
				  	  </form>
				  	</div>
				  	<div class="col-md-5">

						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

						  <div class="panel panel-default">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#administradores" aria-expanded="false" aria-controls="collapseOne">
						          Administradores
						        </a>
						      </h4>
						    </div>
						    <div id="administradores" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
								<ul class="list-group">
									<?php
										$sql1 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='1' ");
										if(mysqli_num_rows($sql1) == 0){
											echo '<center>No hay ningún usuario con este rango.</center>';
										}else{
											while($row1 = mysqli_fetch_array($sql1)){
									?>
								  <li class="list-group-item">
								  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row1['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row1['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row1['usuario']; ?>"><?php echo $row1['usuario']; ?></a>
								  </li>
									<?php
											}
										}
									?>
								</ul>
						      </div>
						    </div>
						  </div>

						  <div class="panel panel-default">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#moderadores" aria-expanded="false" aria-controls="collapseOne">
						          Moderadores
						        </a>
						      </h4>
						    </div>
						    <div id="moderadores" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
								<ul class="list-group">
									<?php
										$sql2 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='2' ");
										if(mysqli_num_rows($sql2) == 0){
											echo '<center>No hay ningún usuario con este rango.</center>';
										}else{
											while($row2 = mysqli_fetch_array($sql2)){
									?>
								  <li class="list-group-item">
								  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row2['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row2['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row2['usuario']; ?>"><?php echo $row2['usuario']; ?></a>
								  </li>
									<?php
											}
										}
									?>
								</ul>
						      </div>
						    </div>
						  </div>

						  <div class="panel panel-default">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#colaboradores" aria-expanded="false" aria-controls="collapseOne">
						          Colaboradores
						        </a>
						      </h4>
						    </div>
						    <div id="colaboradores" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
								<ul class="list-group">
									<?php
										$sql3 = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rango='3' ");
										if(mysqli_num_rows($sql3) == 0){
											echo '<center>No hay ningún usuario con este rango.</center>';
										}else{
											while($row3 = mysqli_fetch_array($sql3)){
									?>
								  <li class="list-group-item">
								  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($row3['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $row3['avatar']; } ?>" alt="..."> <a href="<?php echo $web['url']; ?>/perfil/<?php echo $row3['usuario']; ?>"><?php echo $row3['usuario']; ?></a>
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
				   
				    </div>
				</div>			

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>