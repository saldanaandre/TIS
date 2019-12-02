<?php 
	session_start();
	error_reporting(0);
	//conexion a la base de datos
	
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	$dni1 = $_SESSION["dni"];
	$sql="select nombre from BBVA.dbo.Usuarios where dni = '$dni1'	";
	$stmt = sqlsrv_query($con, $sql);
	$row =sqlsrv_fetch_array($stmt);
	;
	if(isset($_SESSION["dni"] )){


?>


<!DOCTYPE html>
<html>
<head>
	<title>Insertar Deuda</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	initial-scale=1, maximum-scale=1, minimum-scale=1">
	<link rel="stylesheet" type="text/css" href="estilos_cuenta.css">

</head>
<body>
	
	<form method="POST" action="Validar_Deuda.php">
		<h2>Formulario de Nuevo Deuda</h2>
		
		<input type="text" placeholder="Nombre de la Empresa" name="Nomb_Empre"><br/>
		<input type="date" placeholder="Fecha de Vencimiento de la deuda" name="Fech_venc_deuda"><br/>
		<input type="Number" placeholder="Monto a Cancelar" step="0.01" name="Monto_deuda"><br/>
		<input type="Number" placeholder="Monto de mora" step="0.01" name="Monto_mora"><br/>
		<input type="submit" value="Ingresar deuda" name="insert_deuda"><br/>
		<style type="text/CSS">
			a{
								text-decoration: none;
							    padding: 10px;
							    font-weight: 600;
							    font-size: 20px;
							    color: #ffffff;
							    background-color: #1883ba;
							    border-radius: 6px;
							    border: 2px solid #0016b0;
			}
		</style>	
		<a href="Dashboard.php" class="_btn_personalizado">Ir a la Pagina Principal</a>
		
	</form>
	
</body>
</html>
<?php
}else{
	 "<script type=\"text/javascript\">alert(\"Has cerrado Session correctamente\");</script>"; 
	header("location:one.html")	;
}

?>