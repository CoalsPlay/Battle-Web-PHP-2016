				<div class="panel panel-default">
				  <div class="panel-heading text-center"><img src="<?php echo $web['url']; ?>/img/iconos/chart_bar.png"> Estadísticas</div>
				  <div class="panel-body">
					<ul class="list-group">
					  <li class="list-group-item">
						Último usuario:
					  	<?php
					  		$query_u = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC");
					  		if(mysqli_num_rows($query_u) == 0){
					  			echo '<b¡>Sin usuarios.</b>';
					  		}else{
					  			if($llamar = mysqli_fetch_array($query_u)){
					  				echo '<b><a href="'.$web['url'].'/perfil/'.$llamar['usuario'].'">'.$llamar['usuario'].'</a></b>';
					  			}
					  		}
					  	?>
					 	 
					  </li>
					  <li class="list-group-item">
					    <span class="badge">
					    	<?php
					    		$query_cu = mysqli_query($conexion, "SELECT * FROM usuarios");
					    		if($num_u = mysqli_num_rows($query_cu)){
					    			echo $num_u;
					    		}
					    	?>
					    </span>
					    Número de registros
					  </li>
					  <!--<li class="list-group-item">
					    <span class="badge">
					    	...
					    </span>
					    Usuarios online
					  </li>-->
					  <li class="list-group-item">
					  	<?php
					  		if($web['mantenimiento'] == 0){
					  			echo '<span class="badge" style="background:red;">No</span>';
					  		}elseif($web['mantenimiento'] == 1){
					  			echo '<span class="badge" style="background:green;">Sí</span>';
					  		}
					  	?>
					    Mantenimiento:
					  </li>
					</ul>
				  </div>
				</div>