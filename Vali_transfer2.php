<?php 
	session_start();
	error_reporting(0);
	//conexion a la base de datos
	
	$serverName= "LUISSALDAÑA\SQLEXPRESS";
	$connectionInfo = array ("Database" =>"BBVA", "UID"=>"prueba2", "PWD"=>"prueba23*", "CharacterSet"=> "UTF-8");
	$con = sqlsrv_connect($serverName, $connectionInfo);
	$dni1 = $_SESSION["dni"];
	$sql="select nombre, UPPER(apellidos),monto,tarjeta  from BBVA.dbo.Usuarios where dni = '$dni1'	";
	$stmt = sqlsrv_query($con, $sql);
    $row=sqlsrv_fetch_array($stmt);
    

	if(isset($_SESSION["dni"] )){
                
				$consulta_tot = " select Row#,Iddni, tarj_orig,tarj_dest , monto from(      
					SELECT ROW_NUMBER() OVER(PARTITION BY iddni ORDER BY id_num_t desc) AS Row#,Iddni,tarj_orig,tarj_dest,monto
					FROM Transferencias)T1 
					where T1.iddni= '$dni1'
					and T1.Row#=1";

				$ejecu_consu_tot = sqlsrv_query($con,$consulta_tot);
				$fila_tot_con = sqlsrv_fetch_array($ejecu_consu_tot);	
				//Actualiza el prestamo del origen
				
                $upd_saldo_sube = "UPDATE Usuarios  	SET  monto = monto + '$fila_tot_con[4]'  where tarjeta='$fila_tot_con[3]'" ;
                $ejecutar_redu = sqlsrv_query($con,$upd_saldo_sube);
                sqlsrv_free_stmt( $ejecutar_redu);

                //Actualiza el prestamos del destino
                $upd_saldo_baja = "UPDATE Usuarios  	SET  monto = monto - '$fila_tot_con[4]'  where tarjeta='$fila_tot_con[2]'" ;
                $ejecutar_redu = sqlsrv_query($con,$upd_saldo_baja);
                sqlsrv_free_stmt( $ejecutar_redu);
               
				
				//Actualiza estado de transferencia
				$upd_trans_est =  "update Transferencias
				set estado=1
				where id_num_t in (select TOP (1) id_num_t from Transferencias where estado= 0 order by id_num_t desc)";
				$ejecutar_upd_trasn = sqlsrv_query($con,$upd_trans_est);
				sqlsrv_free_stmt( $ejecutar_upd_trasn);
				echo "Operacion Realizada con exito!!<br>";
				header("Location:dashboard.php");
            }
            