<?php if(isset($_SESSION['login'])){ ?>
<div class="panel panel-default">
  <div class="panel-heading text-center">Usuarios conectados</div>
  <div class="panel-body">
  	<?php
      $sql_on = mysqli_query($conexion, "SELECT * FROM usuarios WHERE online = '1' ");

  		if(mysqli_num_rows($sql_on) == 0){
  			echo '<center><h4>No hay ningún usuario conectado actualmente.</h4></center>';
  		}else{

  			while($mos_on = mysqli_fetch_array($sql_online)){
  				echo '<img src="'.$web['url'].'/img/iconos/useron.gif"> <a href="'.$web['url'].'/perfil/'.$mos_on['usuario'].'">'.$mos_on['usuario'].'</a>&nbsp;&nbsp; ';
  			}
  		}
  	?><!--
    <script>
      refresca();
    </script>-->
  </div>
</div>
<?php } ?>