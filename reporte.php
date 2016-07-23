<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	if(!isset($_SESSION['login'])){ header("Location: registro.php"); }

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
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bug_add.png"> Reporte de Bugs</div>
				  <div class="panel-body">
				  	<?php

				  	if(isset($_POST['reporte'])){
				  		$text_bug = proteccion(mysqli_real_escape_string($conexion, $_POST['text_bug']));

				  		if(empty($text_bug)){
				  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
									Debes rellenar el campo.</div>";
				  		}elseif(strlen($text_bug) <= 10){
				  			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
									Por favor, detállenos un poco más el bug.</div>";
				  		}else{
				  			mysqli_query($conexion, "INSERT INTO bugs (text_bug, autor, fecha) VALUES('".$text_bug."','".$dato_u['id']."','".date("Y-m-d H:i")."') ");
				  			echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
								Has reportado correctamente el bug, agradecemos su colaboración. Lo resolveremos cuanto antes.</div>";
				  		}
				  	}

				  	?>
					<form method="post" action="" class="form-horizontal">
						<textarea class="form-control" style="max-width:100%;" name="text_bug" rows="3" id="textArea" placeholder="Explicación del bug"></textarea>
						<span class="help-block">Se agradece que este sistema se use con el fin con el que ha sido implementado. ¡Gracias por su interés!</span>
						<input type="submit" name="reporte" class="btn btn-primary" value="Reportar bug">
					</form>
				  </div>
				</div>
				
				<?php include('plantilla/box_onlines.php'); ?>
				
			</div>
			
		</div>

		
		<?php include('plantilla/footer.php'); ?>