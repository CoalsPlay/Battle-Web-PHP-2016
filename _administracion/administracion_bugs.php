<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 0 or !isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }

	$limite = 5;

	if(isset($_GET['bugs'])){
		$pag = $_GET['bugs'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}
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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/bug_error.png"> Administración - Bugs reportados</div>
				  <div class="panel-body">
					<?php 

						$sql_bugs = mysqli_query($conexion, "SELECT * FROM bugs
															 JOIN usuarios ON bugs.autor = usuarios.id
															 ORDER BY id_bug DESC LIMIT $inicio, $limite");

						if(mysqli_num_rows($sql_bugs) == 0){
							echo "<center><h3><span class='text-primary'><u>Actualmente no hay bugs reportados.</u></span></h3></center>";
						}else{
							while($ext_bug = mysqli_fetch_array($sql_bugs)){

					 ?>
					<div class="panel panel-default">
						<div class="panel-body" style="word-wrap: break-word;">
						  <?php echo $ext_bug['text_bug']; ?>
						  <hr>
						  <small><a href="<?php echo $web['url']; ?>/perfil/<?php echo $ext_bug['usuario']; ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object img-circle pull-left" src="<?php if($ext_bug['avatar'] == NULL){ echo $web['url']."/img/avatar_default.png"; }else{ echo $web['url']; ?>/avatars/<?php echo $ext_bug['avatar']; } ?>" alt="..."> <?php echo $ext_bug['usuario']; ?></a>&nbsp; el:&nbsp; <i><?php echo $ext_bug['fecha'] ?></i></small>
						</div>
					</div>
					<?php 
							}
						}

						$pag_not = mysqli_query($conexion, "SELECT count(id_bug) FROM bugs");
						$total_not = mysqli_fetch_array($pag_not);
						$total_pag = ceil(intval($total_not['0']) / $limite);

						echo '<ul class="pagination pagination-sm">';

						if ($total_pag > 1){
						    for ($i=1;$i<=$total_pag;$i++){
						       if ($pag == $i)
						          echo '<li class="active"><a href="index?pagina='.$i.'">'.$pag.'</a></li>';
						       else
						       		echo '<li><a href="'.$web['url'].'/_administracion/administracion_bugs?bugs='.$i.'">'.$i.'</a></li>';
						    }

						   	echo '</ul>';
						} 
					 ?>
				  </div>
				</div>
				
				
			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>