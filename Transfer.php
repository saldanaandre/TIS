<?php 
	session_start();
	error_reporting(0);
	//conexion a la base de datos
	
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	$dni1 = $_SESSION["dni"];
	$sql="select nombre, UPPER(apellidos),monto  from BBVA.dbo.Usuarios where dni = '$dni1'	";
	$stmt = sqlsrv_query($con, $sql);
	$row=sqlsrv_fetch_array($stmt);
	;
	if(isset($_SESSION["dni"] )){
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>Transferencia</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	initial-scale=1, maximum-scale=1, minimum-scale=1">
	<link rel="stylesheet" type="text/css" href="estilos_cuenta.css">
</head>
<body>          
	<form method="POST" action="Vali_transfer.php">
        <h2>Transferencias a terceros</h2>
        <h3>Usted tiene un monto de S/<?php echo $row[2];?></h3>
		<input type="number" placeholder="Monto" name="Monto"><br/>
		<input type="number" placeholder="Cuenta de Destino" name="Cuenta_Destino"><br/>
		<input type="text" placeholder="Concepto" name="Concepto"><br/>
		<!--<input type="text" placeholder="Correo" name="Correo"><br/> -->
		<input type="submit" value="Paso 1 de 2" name="transferir">
	</form>
			
	
</body>
</html>

<?php
}else{
	 "<script type=\"text/javascript\">alert(\"Has cerrado Session correctamente\");</script>"; 
	header("location:one.html")	;
}

?>
