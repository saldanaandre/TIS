<?php
			if (isset($_GET['Cancelar'])) {
			$borrar_id = $_GET['Cancelar'];

	
	

		
			
			$sql_pago=		"select MONTH(Fech_venc),monto,Mora, DATEDIFF(day, Fech_venc,SYSDATETIME()) NUM_DS ,nom_emp, CONVERT(varchar, Fech_venc, 23), CONVERT(smalldatetime, GETDATE(), 23)
								from(   SELECT Mora,ROW_NUMBER() OVER(PARTITION BY iddni ORDER BY id ASC) AS  Row#,Iddni,monto,Fech_venc,nom_emp
								FROM Empresas)T1  
									where T1.iddni= '$dni1' 
									and T1.Row#='$borrar_id'";
			//echo "$sql_pago";					   	
			$ejecutar_cancelar	= sqlsrv_query($con,$sql_pago);

			$fila_pago=sqlsrv_fetch_array($ejecutar_cancelar);
			$mes_cancel = $fila_pago[0];
			$monto_cancel = $fila_pago[1];
			$num_mont_mor = $fila_pago[2]; 
			$num_mont_mor = 0;
			$num_mora = $fila_pago[3];
			$emp= $fila_pago[4];
			$fecha_pago2 = $fila_pago[5];
			$fech_canc = GETDATE;
			if($num_mora>0){
				$num_mont_mor = $fila_pago[2]*$num_mora;
			}else{
				$num_mont_mor = 0;
			}
			$monto_redu = $monto_cancel + $num_mont_mor;
			
			$conul_sald = "Select monto from Usuarios where dni='$dni1'";
			$eje_consu_sald= sqlsrv_query($con,$conul_sald);
			$row_sald = sqlsrv_fetch_array($eje_consu_sald);
			if($row_sald[0]>$monto_redu){
				
				$insertar_pago	= " INSERT into Pagos values ('$dni1','$mes_cancel','$monto_cancel','$num_mont_mor','$emp','$fecha_pago2',GETDATE())";

				$ejecutar_pago = sqlsrv_query($con, $insertar_pago);
				sqlsrv_free_stmt( $ejecutar_pago);
				$consulta3 ="DELETE T1 from( SELECT ROW_NUMBER() OVER(PARTITION BY iddni ORDER BY id ASC) AS Row#,* FROM Empresas)T1 WHERE T1.iddni= '$dni1' and T1.Row#= '$borrar_id'";
				//DELETE FROM   (select ROW_NUMBER() OVER (ORDER BY Id) AS cont ,* from Empresas  ) T1 where  Iddni = 123 and cont=2
				$ejecutar3= sqlsrv_query($con, $consulta3);
				sqlsrv_free_stmt( $ejecutar3);

				
				$redu_saldo="UPDATE Usuarios   	SET  monto = monto - '$monto_redu'    where dni='$dni1'" ;
				$ejecutar_redu = sqlsrv_query($con,$redu_saldo);
	
					echo "<script>alert('La alarma ha sido cancelada')</script>";
				//header("Location: dashboard.php");
				//echo "<script>windows.open('dashboard.php','_self')</script>";
					header("Location:dashboard.php");
			}else{
				echo "<script>alert('No cuenta con saldo suficiente')</script>";
				//header("Location:dashboard.php");
			}
	}
