
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  <div class="panel-body text-center">
					Copyright &copy; Todos los derechos reservados. <a href="<?php echo $web['url']; ?>/index.php"><?php echo $web['nombre']; ?></a> - By <a href="http://coalsplay.com">CoalsPlay</a>
					<?php
						 
						 
						//Al final de la pagina
						$time = microtime();
						$time = explode(' ', $time);
						$time = $time[1] + $time[0];
						$finish = $time;
						$total_time = round(($finish - $start), 4);
						echo '<br>Pagina generada en '.$total_time.' segundos.';
					?>
				  </div>
				</div>
			</div>
		</div>
		
		</div> <!-- Fin container -->
		<!-- JS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="<?php echo $web['url']; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $web['url']; ?>/js/holder.js"></script>
		<!-- Fin JS -->
	</body>
</html>