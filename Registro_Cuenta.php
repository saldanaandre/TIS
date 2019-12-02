<?php
$serverName = "LUISSALDAÑA\SQLEXPRESS";
$connectionInfo = array("Database" => "BBVA", "UID" => "prueba2", "PWD" => "prueba23*", "CharacterSet" => "UTF-8");
$con = sqlsrv_connect($serverName, $connectionInfo);

//if($con){
// 	echo "conexión exitosa";
//}else{
//	echo "fallo en la conexión";
//}

$usuario = $_POST['Nombres'];
$apellidos = $_POST['Apellidos'];
$dni = $_POST['DNI'];
$correo = $_POST['Correo'];
$pass = $_POST['Password'];
$tarjeta = $_POST['Tarjeta'];
$cvv = $_POST['CVV'];
$fech = $_POST['Fech_Venc'];
//$fech = date("m-d-Y", strtotime($_POST['Fech_Venc']));





if (empty($usuario and $apellidos and $dni and $correo and $pass and $tarjeta and $cvv and $fech)) {
	echo "Falta llenar todos los campos";
} else {
	if (strlen($dni) == 8 && is_numeric($dni)) {
		$consulta2 = " select dni, nombre from BBVA.dbo.Usuarios where dni = '$dni' ";
		$ejecutar2 = sqlsrv_query($con, $consulta2);
		$fila = sqlsrv_fetch_array($ejecutar2);
		$num_dni = $fila['dni'];
		$nom_dni = $fila['nombre'];
		//
		if (strlen($tarjeta) == 16 && ctype_digit($tarjeta)) {

		if ($num_dni=null) {
			//sqlsrv_free_stmt( $ejecutar2);
			header('Refresh: 5; URL=one.html');
			echo  " <h3> $nom_dni  usted ya fue registrado </h3>";
			echo "<body><h4>En <span id='countdown'></span><script src='countdown.js'></script> segundos sera redirido </h4></body>";
		} else {
			$insertar = "INSERT INTO  Usuarios (nombre , apellidos ,	correo ,	pass ,tarjeta ,	cvv ,fech_ven ,dni, monto )
					               VALUES    ('$usuario', '$apellidos', '$correo','$pass', '$tarjeta', '$cvv',cast('$fech' as date),'$dni',1000)";
			$ejecutar = sqlsrv_query($con, $insertar);

			if ($ejecutar) {
				header('Refresh: 5; URL=one.html');
				echo "<body><h4>Redirigiendo a la pagina principal en <span id='countdown'></span><script src='countdown.js'></script> ...</h4></body>";
				echo "<script type=\"text/javascript\">alert(\"Insertado correctamente Usuario: '$dni' y contraseña: '$pass'\");</script>";
			} else {
				//echo "<h3>No se ah insertado correctamente</h3>";
				echo "<script type=\"text/javascript\">alert(\"No se ah insertado correctamente\");</script>"; 
				die(print_r(sqlsrv_errors(), true));
			}
		}
		}else{
			//echo "<script type=\"text/javascript\">alert(\"Numero de Tarjeta ingresada incorrectamente\");</script>"; 
			echo "Numero de Tarjeta ingresada incorrectamente<br>";
			//echo "$tarjeta<br>";
			//echo var_dump($tarjeta);
		}

	} else {
		echo " Dni ingresado incorrecto";
	}
}
