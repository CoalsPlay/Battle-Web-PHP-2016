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
		<title><?php echo $web['nombre']; ?> - Añadir sugerencia</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/add_sug.png"> Creación de sugerencia</div>
				  <div class="panel-body">
				  	<?php

				  	if(isset($_POST['crear'])){
				  		$text_sug = proteccion(mysqli_real_escape_string($conexion, $_POST['text_sug']));

				  		if(empty($text_sug)){
				  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
									Debes rellenar el campo.</div>";
				  		}elseif(strlen($text_sug) <= 10){
				  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
									Por favor, detállenos un poco más la sugerencia.</div>";
				  		}else{
				  			if(mysqli_query($conexion, "INSERT INTO sugerencias (text_sug, autor, fecha) VALUES('".$text_sug."','".$dato_u['id']."','".date("Y-m-d H:i")."') ")){
				  				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
									Has enviado correctamente la sugerencia, agradecemos su colaboración. Lo revisaremos enseguida.</div>";
				  			}else{
				  				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
										Hubo un error en la creación de la sugerencia.</div>";
				  			}
				  		}
				  	}

				  	?>
					<form method="post" action="" class="form-horizontal">
						<textarea class="form-control" style="max-width:100%;" name="text_sug" rows="3" id="textArea" placeholder="Explicación de la sugerencia"></textarea>
						<span class="help-block">Se agradece que este sistema se use con el fin con el que ha sido implementado. ¡Gracias por su interés!</span>
						<input type="hidden" name="autor_sug" value="<?php echo $dato_u['id']; ?>">
						<input type="submit" name="crear" class="btn btn-primary" value="Enviar sugerencia">
					</form>
				  </div>
				</div>
				
				<?php include('plantilla/box_onlines.php'); ?>

			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>