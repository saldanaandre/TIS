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