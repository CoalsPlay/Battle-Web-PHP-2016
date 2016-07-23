<?php
	ob_start();
	session_start();

	require('conexion/conexion.php');
	include('funciones.php');

	if($web['mantenimiento'] == 1 && $dato_u['rango'] == 0){ header('location:'.$web['url'].'/mantenimiento'); }


	$sql_bs = mysqli_query($conexion, "SELECT * FROM combates
									   JOIN mobs ON combates.id_enemigo = mobs.id_mob 
									   WHERE id_usuario = '$dato_u[id]' ");
	if(mysqli_num_rows($sql_bs) == 1){ header("Location: combate"); }

	$limite = 10;

	if(isset($_GET['articulos'])){
		$pag = $_GET['articulos'];
		$inicio = (($pag - 1) * $limite);
	}else{
		$inicio = 0;
		$pag = 1;
	}

	if(!isset($_SESSION['login'])){ header("Location: ".$web['url']."/404"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $web['nombre']; ?> - Tienda</title>
		<?php include('plantilla/cabecera.php'); ?>
	
		<div class="container">
		<div class="row">
			
			<div class="col-md-3">

				<?php include('plantilla/box_login.php'); ?>
				
			</div>
			
			<div class="col-md-9">

				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="img/iconos/cart.png"> Tienda</div>
				  <div class="panel-body">
					      <?php
					      	if(isset($_REQUEST['acept_comp']) == "Comprar"){
					      		$id_art = $_REQUEST['id_art'];
					      		// $cant = proteccion($_REQUEST['cant']);
					      		$sql_t = mysqli_query($conexion, "SELECT * FROM tienda WHERE id_articulo = '$id_art' ");
					      		$row_c = mysqli_fetch_array($sql_t);
					      		// $mult_cant = $row_c['precio_articulo'] * $cant;

					      		if($dato_u['oro'] < $row_c['precio_articulo']){
					      			echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
											No tienes suficiente oro para realizar esta compra.</div>';
					      		/*}elseif($cant == 0){
					      			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
											Debes poner una cantidad.</div>";*/
					      		}else{
					      			$result = $dato_u['oro'] - $row_c['precio_articulo'];
									mysqli_query($conexion, "UPDATE usuarios SET oro = '$result' WHERE id = '$dato_u[id]' ");
					      			mysqli_query($conexion, "INSERT INTO inventarios (id_usuario_inv, id_item_inv)
					      									 VALUES ('".$dato_u['id']."','".$id_art."') ");
					      			echo '<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
												Haz realizado la compra corréctamente: <b>-'.$row_c["precio_articulo"].' de oro.</b></div>';
					      		}

					      	}
					      ?>
					<div class="panel panel-default">

					      <!-- Table -->
					      <table class="table">
					        <thead>
					          <tr>
					            <th>Artículo</th>
					            <th>Precio</th>
					            <th>Descripción</th>
					            <!--<th>Cantidad</th>-->
					            <th>Acción</th>
					          </tr>
					        </thead>
					        <tbody>
					        	<?php
					        		$sql = mysqli_query($conexion, "SELECT * FROM tienda ORDER BY id_articulo ASC LIMIT $inicio, $limite");
					        		if(mysqli_num_rows($sql) == 0){
					        			echo '<center><h3>Actualmente no hay ningún objeto para comprar en la tienda.</h3></center><br/>';
					        		}else{

					        			while($row = mysqli_fetch_array($sql)){
					        	?>
					          <tr>
					            <td><img src="<?php echo $web['url']; ?>/img/articulos/<?php echo $row['img_articulo']; ?>" width="34"> <span style="position:relative; top:-5px;"><?php echo $row['nombre_articulo']; ?></span></td>
					            <td><?php echo $row['precio_articulo']; ?> <img src="<?php echo $web['url']; ?>/img/iconos/coins.png"></td>
					            <td><?php echo $row['descripcion_articulo']; ?></td>
					            <!--<td>--><form method="post" action="<?php $_SERVER['PHP_SELF']; ?>"><div class="input-group input-group-sm">
								  <!--<input type="text" class="form-control" name="cant" maxlength="2" value="1" style="width:35px;" aria-describedby="sizing-addon3">-->
								</div>
								<!--</td>-->
								<td>
									<input type="hidden" value="<?php echo $row['id_articulo']; ?>" name="id_art" >
									<input type="submit" name="acept_comp" value="Comprar" class="btn btn-default btn-xs">
								  </form>
								</td>
					          </tr>
								<?php
					        			}
					        		}
					        	?>
					        </tbody>
					      </table>
					    </div>
					    <?php 
							$pag_not = mysqli_query($conexion, "SELECT count(id_articulo) FROM tienda");
							$total_not = mysqli_fetch_array($pag_not);
							$total_pag = ceil(intval($total_not['0']) / $limite);

							echo '<ul class="pagination pagination-sm">';

							if ($total_pag > 1){
							    for ($i=1;$i<=$total_pag;$i++){
							       if ($pag == $i)
							          echo '<li class="active"><a href="'.$web['url'].'/tienda/'.$i.'">'.$pag.'</a></li>';
							       else
							       		echo '<li><a href="'.$web['url'].'/tienda/'.$i.'">'.$i.'</a></li>';
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