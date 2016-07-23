<?php
	ob_start();
	session_start();

	require('../conexion/conexion.php');
	include('../funciones.php');

	if($dato_u['rango'] == 3){ header('location: '.$web['url'].'/_administracion/administracion'); }

	$limite = 10;

	if(isset($_GET['articulos'])){
		$pag = $_GET['articulos'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

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
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/cart_edit.png"> Administración - Gestor de la tienda</div>
				  <div class="panel-body">

					  	<?php
					  		$sql = mysqli_query($conexion, "SELECT * FROM tienda ORDER BY id_articulo ASC LIMIT $inicio, $limite");

					  		if(mysqli_num_rows($sql) == 0){
					  			echo '<center><h3>No hay ningún artículo implementado en la tienda.</h3></center>';
					  		}else{
					  	?>
					<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <th>Id</th>
					      <th>Imagen</th>
					      <th>Nombre</th>
					      <th>Acción</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php
					  			while($row = mysqli_fetch_array($sql)){
					  	?>
					    <tr>
					      <td><?php echo $row['id_articulo']; ?></td>
					      <td><img src="<?php echo $web['url']; ?>/img/articulos/<?php echo $row['img_articulo']; ?>"></td>
					      <td><b><?php echo $row['nombre_articulo']; ?></b></td>
					      <td><span><a href="<?php echo $web['url']; ?>/_administracion/administracion_editar_articulo?articulo=<?php echo $row['id_articulo']; ?>"><img src="<?php echo $web['url']; ?>/img/iconos/wrench.png"> Editar</a></span></td>
					    </tr>
					  	<?php
					  			}
					  		}
					  	?>
					  </tbody>
					</table>

					    <?php 
							$pag_not = mysqli_query($conexion, "SELECT count(id_articulo) FROM tienda");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/_administracion/administracion_tienda?articulos='.intval($i).'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/_administracion/administracion_tienda?articulos='.intval($i).'">'.$i.'</a></li>';
							    }

							   	echo '</ul>';
							}
					    ?>

					  <br/><br/>
					<a href="<?php echo $web['url']; ?>/_administracion/administracion_agregar_articulo" style="width:100%;" class="btn btn-primary">Agregar artículo</a>
				  </div>
				</div>
					

			</div>
			
		</div>

		
		<?php include('../plantilla/footer.php'); ?>