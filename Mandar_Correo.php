<?php

 
	session_start();
	error_reporting(0);
	//conexion a la base de datos
	
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	$dni1 = $_SESSION["dni"];

$sql="select correo from BBVA.dbo.Usuarios where dni = '$dni1'	";
	$stmt = sqlsrv_query($con, $sql);
	$abc= sqlsrv_fetch_array($stmt);
	$destino = $abc[0];
    echo $destino;


	//$destino = 'andresaldanatello@gmail.com';
	$tema = 'prueba';
	$contenido = 'Mensaje de prueba desde PHP';
	
	$ok = mail($destino,$tema,$contenido);
	
	if($ok){
		echo "El mensaje se envio correctamente!!!";
	}else{
		echo 'No se pudo enviar el mensaje';
	}