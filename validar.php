<?php

session_start(); 

$usuario=$_POST['dni'];
$clave=$_POST['password'];

$_SESSION["dni"] = $usuario;

//conexion a la base de datos
$serverName= "LUISSALDAÑA\SQLEXPRESS";
$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
$con = sqlsrv_connect($serverName, $connectionInfo);
	if ($usuario!='' and $clave!='') {
		//echo "esta lleno";

	$consulta="select * from BBVA.dbo.Usuarios where dni= $usuario and pass ='$clave'";
	$ejecutar = sqlsrv_query($con, $consulta);
	
	if ($ejecutar === false) {
		echo "Error en la autentificacion";
		die();

	}

	$filas=sqlsrv_fetch_array($ejecutar);
	
		if ($filas>0){
			 
			header("Location:dashboard.php");
			//echo 'entrando en la página';
			//echo '<script type="text/javascript">
			//alert("Probando vamos a proceder a redireccionar");
			//window.location.assign("dashboard.php");
			//</script>';
			//echo 'salida de la página';
		}else{
			echo "Error en la autentificacion";
		}


	}else{
	echo "Llenar los campos requeridos ";
	}
sqlsrv_close($con);	