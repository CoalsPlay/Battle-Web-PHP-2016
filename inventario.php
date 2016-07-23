<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }

	$limite = 10;

	if(isset($_GET['articulos'])){
		$pag = $_GET['articulos'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

	$sql_bs2 = mysqli_query($conexion, "SELECT * FROM combates
									   JOIN mobs ON combates.id_enemigo = mobs.id_mob 
									   WHERE id_usuario = '$dato_u[id]' ");
	if(mysqli_num_rows($sql_bs2) == 1){ header('location: '.$web['url'].'/combate'); }

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Inventario</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">

			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>

			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/briefcase.png"> Inventario de <b><?php echo $dato_u['usuario']; ?></b></div>
				  <div class="panel-body">
				  	<!--
					<span>Capacidad de objetos que puedes llevar <b>13/25</b>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="min-width: 35em;">
						    13/25
						</div>
					</div>
					<hr/>-->
					  	<?php

					  		if(isset($_REQUEST['usar_i']) == "Usar"){
					  			$id_inv = $_REQUEST['id_inv'];
					  			$sql2 = mysqli_query($conexion, "SELECT * FROM inventarios
					  											 JOIN tienda ON inventarios.id_item_inv = tienda.id_articulo
					  											 WHERE id_inv = '$id_inv' ");
					  			$ar_sql2 = mysqli_fetch_array($sql2);

							  	if($ar_sql2['accion_articulo'] == 'hp'){

							  		if($dato_u['salud'] == $dato_u['max_salud']){
								  		echo '<div class="alert alert-dismissible alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
												Ya tienes la salud al máximo, no puedes usar este objeto.</div>';
							  		}else{
								  		if(($dato_u['salud'] + $ar_sql2['cantidad_accion']) > $dato_u['max_salud']){
								  			mysqli_query($conexion, "UPDATE usuarios SET salud = '$dato_u[max_salud]' WHERE id = '$dato_u[id]' ");
									  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

									  		echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
													Has rellenado la salud por completo.</div>";
								  		}else{
									  		$op1 = $dato_u['salud'] + $ar_sql2['cantidad_accion'];
									  		mysqli_query($conexion, "UPDATE usuarios SET salud = '$op1' WHERE id = '$dato_u[id]' ");
									  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

									  		echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
													Has utilizado un ojeto que te rellena la salud en <b>".$ar_sql2['cantidad_accion']."</b> puntos.</div>";
								  		}
							  		}

							  	}elseif($ar_sql2['accion_articulo'] == 'sp'){
							  		
							  		if($dato_u['energia'] == $dato_u['max_energia']){
								  		echo "<div class='alert alert-dismissible alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
												Ya tienes la energía al máximo, no puedes usar este objeto.</div>";
							  		}else{
								  		if(($dato_u['energia'] + $ar_sql2['cantidad_accion']) > $dato_u['max_energia']){
								  			mysqli_query($conexion, "UPDATE usuarios SET energia = '$dato_u[max_energia]' WHERE id = '$dato_u[id]' ");
									  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

									  		echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
													Has rellenado la energía por completo.</div>";

								  		}else{
									  		$op2 = $dato_u['energia'] + $ar_sql2['cantidad_accion'];
									  		mysqli_query($conexion, "UPDATE usuarios SET energia = '$op2' WHERE id = '$dato_u[id]' ");
									  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

									  		echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
													Has utilizado un ojeto que te rellena la energía en <b>".$ar_sql2['cantidad_accion']."</b> puntos.</div>";
								  		}
							  		}

							  	}elseif($ar_sql2['accion_articulo'] == 'def'){

							  		$op3 = $dato_u['defensa'] + $ar_sql2['cantidad_accion'];
							  		mysqli_query($conexion, "UPDATE usuarios SET defensa = '$op3' WHERE id = '$dato_u[id]' ");
							  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

							  		echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
											Has utilizado un ojeto que te aumenta la defensa en <b>".$ar_sql2['cantidad_accion']."</b> puntos.</div>";
							  	}elseif($ar_sql2['accion_articulo'] == 'atk'){

							  		$op4 = $dato_u['ataque'] + $ar_sql2['cantidad_accion'];
							  		mysqli_query($conexion, "UPDATE usuarios SET ataque = '$op4' WHERE id = '$dato_u[id]' ");
							  		mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv' ");

							  		echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
											Has utilizado un ojeto que te aumenta el ataque en <b>'.$ar_sql2['cantidad_accion'].'</b> puntos.</div>';
							  	}

					  		}

					  		if(isset($_REQUEST['tirar_i']) == "Tirar"){
					  			$id_inv2 = $_REQUEST['id_inv'];
					  			mysqli_query($conexion, "DELETE FROM inventarios WHERE id_inv = '$id_inv2' ");
					  		}

					  		$sql = mysqli_query($conexion, "SELECT * FROM inventarios
					  										JOIN tienda ON inventarios.id_item_inv = tienda.id_articulo
					  										WHERE id_usuario_inv = '$dato_u[id]'
					  										ORDER BY id_inv ASC LIMIT $inicio, $limite ");


					  		if(mysqli_num_rows($sql) == 0){
					  			echo '<center><h3>No tienes ningún objeto.</h3></center>';
					  		}else{
					  	?>
					<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <th>Objeto(s)</th>
					      <th>Descripción</th>
					      <th>Acciones</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php
					  			while($row = mysqli_fetch_array($sql)){

					  	?>
					    <tr>
					      <td><img style="margin-right:15px;" src="<?php echo $web['url']; ?>/img/articulos/<?php echo $row['img_articulo']; ?>" /> <b><?php echo $row['nombre_articulo']; ?></b></td>
					      <td><?php echo $row['descripcion_articulo']; ?></td>
					      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					      <td>
					      	<input type="hidden" name="id_inv" value="<?php echo $row['id_inv']; ?>">
					      	<input type="submit" name="usar_i" class="btn btn-primary btn-xs" value="Usar">
					      	 - 
					      	<input type="submit" name="tirar_i" class="btn btn-danger btn-xs" value="Tirar"></td>
					      </form>
					    </tr>

					  	<?php
					  			}
					  		}
					  	?>

					  </tbody>
					</table>

					    <?php 
							$pag_not = mysqli_query($conexion, "SELECT count(id_inv) FROM inventarios WHERE id_usuario_inv = '$dato_u[id]' ");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/inventario/'.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/inventario/'.$i.'">'.$i.'</a></li>';
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