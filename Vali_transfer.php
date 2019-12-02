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
    //
    $monto_tran = $_POST['Monto'];
    $cuenta_dest_tran = $_POST['Cuenta_Destino'];
    $concep_tran = $_POST['Concepto'];
    //
    
    
	if(isset($_SESSION["dni"] )){


        $consul_tarj_dest_exis = "select nombre, UPPER(apellidos),tarjeta   from BBVA.dbo.Usuarios where tarjeta = '$cuenta_dest_tran' ";
        $ejecu_conul=sqlsrv_query($con,$consul_tarj_dest_exis);
        $busq_consul=sqlsrv_fetch_array($ejecu_conul);



        if (    $busq_consul[0]!==null){
            if($row[2]>$monto_tran){
                //Inserta en la tabla de Transferencias
                $inser_Transfer="INSERT INTO Transferencias VALUES ('$dni1','$row[3]','$cuenta_dest_tran','$monto_tran','$concep_tran',GETDATE(),'0')";
                $ejecu_inser_trans = sqlsrv_query($con,$inser_Transfer);
                sqlsrv_free_stmt( $ejecu_inser_trans);
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <link rel="stylesheet" type="text/css" href="estilos_cuenta.css">
                <title>Transferencias</title>
            </head>
            <body>
            <form method="POST" action="Vali_transfer2.php">
                <h2>Transferencias a terceros</h2>
                <h3>Usted Transferira un monto de S/ <?php  echo $monto_tran;?></h3><br>
                <h3>Con destino a: <?php echo $busq_consul[1].', '.$busq_consul[0];?></h3>
                <!--<input type="text" placeholder="Correo" name="Correo"><br/> -->
                <input type="submit" value="Paso 2 de 2" name="transferir2">
            </form>
            <?php
             if(isset($_POST['transferir2'])){
                

                //Actualiza el prestamo del origen
                $upd_saldo_sube = "UPDATE Usuarios  	SET  monto = monto + '$monto_redu'  where tarjeta='$cuenta_dest_tran'" ;
                $ejecutar_redu = sqlsrv_query($con,$upd_saldo_sube);
                sqlsrv_free_stmt( $ejecutar_redu);

                //Actualiza el prestamos del destino
                $upd_saldo_baja = "UPDATE Usuarios  	SET  monto = monto - '$monto_redu'  where tarjeta='$row[3]'" ;
                $ejecutar_redu = sqlsrv_query($con,$upd_saldo_baja);
                sqlsrv_free_stmt( $ejecutar_redu);
                echo "Operacion Realizada con exito!!<br>";
                echo  'monto'.$cuenta_dest_tran;
    
            }
            ?>
            </body>
            </html>
            <?php  
            
                          
            }else{
                echo "<script>alert('No Cuenta con el saldo suficiente.')</script>";
            }
            
        }else{
            //echo "<script>alert('No existe dicha cuenta registrada.')</script>";
            echo "No existe dicha cuenta sin alerta";
        }
    }
		
?>