<?php
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	
	if($con){
	 	echo "conexión exitosa";
	}else{
		echo "fallo en la conexión";
		die( print_r( sqlsrv_errors(),true));
		}
		
?>