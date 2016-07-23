<?php

	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;

	require("conexion/conexion.php");

	// Validación de Emails
	function ValidacionEmail($email){
		if(preg_match("/^[^@]*@[^@]*\.[^@]*$/", $email)) {
			return true;
		}else{
			return false;
		} 
	}	
	
	// Saneamiento de inputs
	function proteccion($valor){
		$proteger = htmlspecialchars(trim($valor), ENT_QUOTES);
		return $proteger;
	}

		if(isset($_SESSION['login'])){

			if($dato_u['nivel'] == $game['max_lvl']){
				if($dato_u['exp'] > $dato_u['max_exp']){
						mysqli_query($conexion, "UPDATE usuarios SET exp='$dato_u[max_exp]' WHERE id='$dato_u[id]' ");
				}
			}else{
				// Si la Exp. del usuario es menor o igual a la Exp requerida, se ejecuta lo siguiente:
				if($dato_u['exp'] >= $dato_u['max_exp']){
						// Se declara las variables de lo que subirá cada usuario al subir de nivel.
						$up_lvl = $dato_u['nivel'] + 1;
						$up_hp = $dato_u['max_salud'] + 10;
						$up_atk = $dato_u['ataque'] + 3;
						$up_def = $dato_u['defensa'] + 5;
						$up_sp = $dato_u['max_energia'] + 5;
						$up_pts = $dato_u['pts_atributos'] + $game['pts_atr_lvl'];

						// Se obtiene el requisito de exp y le sumamos la cantidad que queremos que se incremente en cada lvl.
						$inc_exp = $dato_u['max_exp'] + $game['int_exp'];

						// Actualizamos al usuario con todos los atributos nuevos incrementados y actualizados.
						mysqli_query($conexion, "UPDATE usuarios 
												 SET pts_atributos = $up_pts, nivel = '$up_lvl', max_salud = '$up_hp', ataque = '$up_atk',
												 defensa = '$up_def', max_energia = '$up_sp', exp = '0', max_exp = '$inc_exp'
												 WHERE id = '$dato_u[id]'  ");
				}
			}

		if($dato_u['salud'] > $dato_u['max_salud']){
			mysqli_query($conexion, "UPDATE usuarios SET salud = '$dato_u[max_salud]'  WHERE id = '$dato_u[id]' ");
		}elseif($dato_u['energia'] > $dato_u['max_energia']){
			mysqli_query($conexion, "UPDATE usuarios SET energia = '$dato_u[max_energia]' WHERE id = '$dato_u[id]' ");
		}

		$sql_comp3 = mysqli_query($conexion, "SELECT * FROM combates WHERE id_usuario = '$dato_u[id]' ");
		if(mysqli_num_rows($sql_comp3) > 1){
			mysqli_query($conexion, "DELETE FROM combates WHERE id_usuario = '$dato_u[id]' ");
		}

		if($dato_u['salud'] > 0){
			mysqli_query($conexion, "DELETE FROM cementerio WHERE id_usuario_fallecido = '$dato_u[id]' ");
		}

		if($dato_u['nivel'] > $game['max_lvl']){
			mysqli_query($conexion, "UPDATE usuarios SET nivel='$game[max_lvl]' WHERE id='$dato_u[id]' ");
		}


		$ult_clic = time();
		mysqli_query($conexion, "UPDATE usuarios SET time='$ult_clic' WHERE id='$dato_u[id]' ");
        $tiempo_p = $dato_u['time'] - 10;
        $sql_online = mysqli_query($conexion, "SELECT * FROM usuarios WHERE time >= '$tiempo_p' ");
	}

	function obtenerIpReal() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        return $_SERVER['HTTP_CLIENT_IP'];
	       
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	   
	    return $_SERVER['REMOTE_ADDR'];
	}

	function claveRandom($length) {   // Generar código para cambios de contraseña.
	    $pattern = "123456789PIUYTREWQASDFGHJKLMNBVCXZ123456789PLMK1IJNBHUYGVC123456789FTRDXZSEWAQWSDERFTGYHUJ123569876543ERDFREDESWQASWQASDGHGTY";  
	    for($i=0; $i < $length; $i++) {  
	      $key .= $pattern{rand(0,35)};  
	    }  
	    return $key;  
	} 

	function porCiento($a, $b){
		$result = ($a / $b) * 100;
		return $result;
	}
	
?>