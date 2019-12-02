<?php
		if (isset($_POST['Ingresar'])) {
								    

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
		}
		
		if (isset($_POST['Cuenta'])) {
	?>		
		   <!DOCTYPE html>
					<html>
					<head>
						<title>Crear Cuenta</title>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, user-scalable=no,
						initial-scale=1, maximum-scale=1, minimum-scale=1">
						<link rel="stylesheet" type="text/css" href="estilos_cuenta.css">
					</head>
					<body>
						<form method="POST" action="Registro_Cuenta.php">
							<h2>Formulario de Nuevo Usuario</h2>
							<input type="text" placeholder="Nombres" name="Nombres"><br/>
							<input type="text" placeholder="Apellidos" name="Apellidos"><br/>
							<input type="text" placeholder="DNI" name="DNI"><br/>
							<input type="text" placeholder="Correo" name="Correo"><br/>
							<input type="password" placeholder="&#128272; Password" name="Password"><br/>
							<input type="text" placeholder="Numero de Tarjeta" name="Tarjeta"><br/>
							<input type="password" placeholder="&#128272; CVV" name="CVV"><br/>
							<input type="date" placeholder="Fecha de Vencimiento" name="Fech_Venc"><br/>
							<input type="submit" value="Crear Cuenta" name="insert">
						</form>
								
						
					</body>
					</html>
<?php					
		}
?>		



