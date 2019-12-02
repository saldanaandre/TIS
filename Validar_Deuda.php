<?php 
	session_start();
	error_reporting(0);
	//conexion a la base de datos
	
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	$dni1 = $_SESSION["dni"];
	//$sql="select nombre from BBVA.dbo.Usuarios where dni = '$dni1'	";
	//$stmt = sqlsrv_query($con, $sql);
	//$row =sqlsrv_fetch_array($stmt);
	
	if(isset($_SESSION["dni"] )){
			
			$empresa = $_POST['Nomb_Empre'];
			$fech = $_POST['Fech_venc_deuda'];
			$monto = $_POST['Monto_deuda'];
			$mto_mora = $_POST['Monto_mora'];
			
			if(empty($empresa and $fech and $monto and $mto_mora))
			{
				echo "Falta llenar todos los campos";
			
			}else{
				$insertar = //"INSERT INTO  Usuarios (nombre , apellidos ,	correo ,	pass ,tarjeta ,	cvv ,fech_ven ,dni )
							//	    VALUES    ('$usuario', '$apellidos', '$correo','$pass', '$tarjeta', '$cvv','$fech','$dni')";

							" INSERT INTO Empresas 
									values ($dni1,'$empresa',cast('$fech' as date),$monto,$mto_mora)";	    

					$ejecutar = sqlsrv_query($con, $insertar);

					if($ejecutar){
						//echo "<h3>Insertado correctamente</h3>";
						
						//echo "<script type=\"text/javascript\">alert(\"Insertado correctamente \");</script>";
						header("Location:dashboard.php"); 			
						//echo '<script language="javascript">alert("Insertado correctamente");</script>';
						//echo 'window.location.href = "/dashboard.php"';
						//alert("Se ah insertado correctamente");
						

					}else{
						//echo "<h3>No se ah insertado correctamente</h3>";
						echo "<script type=\"text/javascript\">alert(\"No se ah insertado correctamente\");</script>"; 
						header("Location:Deuda.php");
					}
			}		
    }		

?>