<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/registro"); }

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Opciones y configuraciones</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_confi.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cog.png"> Opciones y Configuraciones</div>
				  <div class="panel-body">
				  	<div class="col-md-3">
				  		<img width="150" height="150" src="<?php if($dato_u['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $dato_u['avatar']; } ?>">
				  	</div>
				  	<div class="col-md-6">
				  		<?php
				  			// Generamos un código al azar.
				  			if(isset($_POST['subir_avatar'])){
								$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; 
								$cad = ""; 
								for($i = 0; $i < 12; $i++) { 
									$cad .= substr($str, rand(0,62),1);
								}

								// Definimos las variables guardando el valor del tamaño de la imagen y el tamaño max. permitido.
								$tamano = $_FILES ['avatar'][ 'size' ]; 
								$tamano_max = "350000"; 

								if($tamano < $tamano_max){ 
									$destino = 'avatars/'; 
									$sep = explode('image/',$_FILES["avatar"]["type"]); 
									$tipo = $sep[1];

									if($tipo == "gif" || $tipo == "jpeg" || $tipo == "png"){ 
										move_uploaded_file ( $_FILES['avatar']['tmp_name'], $destino . '/' .$cad.'.'.$tipo);
										$nombre_file = $cad.".".$tipo;
										$sql = mysqli_query($conexion, "UPDATE usuarios SET avatar = '$nombre_file' WHERE usuario = '$_SESSION[login]' ");
										echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
												Se ha subido su avatar correctamente.</div><meta http-equiv='refresh' content='1; configuracion_avatar'>"; 
									}else{
										echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
												Este formato de archivo no es compatible, solo se permiten: .png, .jpg y .gif</div>"; 
									}
								
								}else{
									echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											La imagen pesa demasiado, lo máximo son 200kb.</div>";
								}
				  			}
				  		?>
						<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
							<input type="file" name="avatar" class="form-control" id="inputEmail"><br/>
							<input type="submit" name="subir_avatar" class="btn btn-primary" value="Subir avatar">
						</form>
					</div>
				  </div>
				</div>


			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>