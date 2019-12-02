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
			<title>Dashboard</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
			<!--<link rel="stylesheet" type="text/css" href="estilos_dashboard.css">-->
			<link rel="stylesheet" href="bootstrap.min.css">
			<meta http-equiv="X-UA-Compatible" content="IE-Edge">
			<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
			<link rel="stylesheet" href="estilos.css">
			
			
		</head>
		<body style="background-color: nieve">
		<div class="sidebar">
			<h2>MENU</h2>
			<ul>
				<li><a href="">Inicio</a></li>
				<li><a href="Transfer.php">Transferencia</a></li>
				
				<li><a href="salir.php" class="btn btn-info">Salir del Sistema</a></li>
			</ul>
		</div>

		<div class="contenido">
		<img src="menu3.png" alt="" class="menu-bar"> 
			
			<h1>Bienvenido</h1>
				<!--<h2><?php echo $_SESSION["dni"].$var_ape ?>    </h2>-->
				<h2><?php echo $row[1].', '.$row[0]  ?>              </h2>
				<h3><?php echo 'Con un saldo de S/.'.$row[2]?></h3>
				
			<form method="POST" action="Deuda.php">
				<div class="form-group" >
					<input type="submit"  name="insert" class="btn btn-warning" value="CREAR ALARMA"><br/>
				</div>

				<?php
				//Buscando cuanto gasta mensual
				sqlsrv_free_stmt( $stmt);
				$Tot_mes_mon = "select mes, SUM(Monto) mon_tot, SUM(mora) MOR from pagos where Iddni= '$dni1' group by mes";
				$stmt2 = sqlsrv_query($con,$Tot_mes_mon);
				
				$array_tot= array(1=>0,0,0,0,0,0,0,0,0,0,0,0);
				$i=1;
				$emp=0;
				while ( $fila_tot=sqlsrv_fetch_array($stmt2)and $i<= 12) {
					$array_tot[$fila_tot['mes']]=$fila_tot['mon_tot']+$fila_tot['MOR'];
					$i++;
					$emp++;
				}
					
				?>	

				<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
				<script>
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(dibujarGrafico);
				function dibujarGrafico() {
					// Tabla de datos: valores y etiquetas de la gráfica
					var data = google.visualization.arrayToDataTable([
					['Texto', 'Valor numérico'],
					['Enero', <?php echo $array_tot[1]  ?>],
					['Febrero', <?php echo $array_tot[2]  ?>],
					['Marzo', <?php echo $array_tot[3]  ?>],
					['Abril', <?php echo $array_tot[4]  ?>],
					['Mayo',<?php echo $array_tot[5]  ?>],
					['Junio',<?php echo $array_tot[6]  ?>],
					['Julio',<?php echo $array_tot[7]  ?>],
					['Agosto',<?php echo $array_tot[8]  ?>],
					['Setiembre',<?php echo $array_tot[9]  ?>],
					['Octubre',<?php echo $array_tot[10]  ?>],    
					['Noviembre',<?php echo $array_tot[11]  ?>],
					['Diciembre',<?php echo $array_tot[12]  ?>],
					]);
					var options = {
					title: 'Reporte de gastos mensuales'
					}
					// Dibujar el gráfico
					new google.visualization.ColumnChart( 
					//ColumnChart sería el tipo de gráfico a dibujar
					document.getElementById('GraficoGoogleChart-ejemplo-1')
					).draw(data, options);
				}
				</script> 
			

				<div id="GraficoGoogleChart-ejemplo-1" style="width: 1600px; height: 600px">
				</div><br /><br />

			
				<div class="col-md-8 col-md-offset-2">
					<table class="table  table-striped  table-hover">
						<tr align="center">
							<th style="width:120px; background-color: #5DACCD; color:#fff">#</th>
							<th style="width:250px; background-color: #5DACCD; color:#fff">Empresa</th>
							<th style="width:160px; background-color: #5DACCD; color:#fff">Fecha de Vencimiento</th>
							<th style="width:160px; background-color: #5DACCD; color:#fff">Monto</th>
							<th style="width:160px; background-color: #5DACCD; color:#fff">Monto_Mora</th>
							<th style="width:250px; background-color: #5DACCD; color:#fff">Observacion</th>
							<th style="width:160px; background-color: #5DACCD; color:#fff">Acción</th>
							<th style="width:160px; background-color: #5DACCD; color:#fff">Acción</th>
						</tr>


						<?php
								$consulta2 =" select nom_emp , Fech_venc, monto, Mora, DATEDIFF(day,  Fech_venc,SYSDATETIME() ) num_mora_dia from Empresas  where Iddni= '$dni1' ";
								


								$ejecutar2= sqlsrv_query($con, $consulta2);

								$i = 0;
								$int = 1;

									while($fila =sqlsrv_fetch_array($ejecutar2)){
										$id = $int;
										$nom_emp= $fila['nom_emp'];
										//$Fech_venc= $fila['Fech_venc'];
										//$Fech_venc = strtotime("$Fech_venc");
										$Fech_venc = date("m-d-Y", $fila['Fech_venc']);
										$monto= $fila['monto'];
										$mon_mora = $fila['Mora'];
										$num_dia = $fila['num_mora_dia'];
										$mensaje = "No hay recargo de mora";
										if($num_dia>=0){
											$num_dia=$num_dia*$mon_mora;
											$mensaje = "Tiene un recargo de ".$num_dia." soles de mora";
										}
										$i++;
										$int++;
						?>

							<tr align="center">
								<td><?php echo $id; ?></td>
								<td><?php echo $nom_emp; ?></td>
								<td><?php echo date_format($fila['Fech_venc'], 'd-m-Y'); ?></td>
								<td><?php echo $monto; ?></td>
								<td><?php echo $mon_mora; ?></td>
								<td><?php echo $mensaje; ?></td>
								<td><a class="btn btn-warning" href="dashboard.php?Cancelar=<?php echo $id;?>">Cancelar</a></td>
								<td><a class="btn btn-danger" href="dashboard.php?Eliminar=<?php echo $id;?>">Eliminar</a></td>
							</tr>
				
						<?php } ?>         <!-- Aqui cerramos el while-->
						
					</table>
					
				<?php
					if(isset($_GET['Cancelar'])){
						include("cancelar.php");
					}

				?>



				<?php
				if (isset($_GET['Eliminar'])) {
				$borrar_id = $_GET['Eliminar'];

				$consulta3 ="delete T1 from( SELECT ROW_NUMBER() OVER(PARTITION BY iddni ORDER BY id ASC) AS Row#,* FROM Empresas)T1 where T1.iddni= '$dni1' and T1.Row#= '$borrar_id'";
				//DELETE FROM   (select ROW_NUMBER() OVER (ORDER BY Id) AS cont ,* from Empresas  ) T1 where  Iddni = 123 and cont=2
				$ejecutar3= sqlsrv_query($con, $consulta3);
						

					if ($ejecutar3) {
						
						echo "<script>alert('La alarma ha sido borrado')</script>";
						sqlsrv_free_stmt( $ejecutar3);
						header("Location: dashboard.php");
						//echo "<script>windows.open('dashboard.php','_self')</script>";
					}
				}
				?>

				
				

				</div>


			</form>

		</div>
		<script src="abrir.js"></script>
		</body>
		</html>
<?php
}else{
	 "<script type=\"text/javascript\">alert(\"Has cerrado Session correctamente\");</script>"; 
	header("location:one.html")	;
}

?>
