<?PHP
$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u334727470_medic";
$username_localhost ="u334727470_medic";
$password_localhost ="frende5557111";

switch($_POST['operacion']){
   case '5':
	/*$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
	or
	trigger_error(mysql_error(),E_USER_ERROR);

	
	mysql_select_db($database_localhost, $localhost);*/
	try {
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	$query_search = "select USUARIO,contrasena,nombre,email,estado from Usuario where contrasena='".$_POST['contrasena']."' and USUARIO='".$_POST['usuario']."' ORDER BY nombre"; 

	$query_exec = mysqli_query($mysqli, $query_search);

	$json = array();	
		if(mysqli_num_rows($query_exec)){
				   
			while($row=mysqli_fetch_array($query_exec)){
			$json['datos'][]=$row;
			}
			$mysqli->close();
			echo json_encode($json);
		}
		
		
		
	} catch (Exception $e) {
	   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	   echo 1;
	}
   break;
   
   case '6':
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);

		$resultado='0';
		try {
		//mysql_select_db($database_localhost, $localhost);
		  $query_search = 
			 "
			 SET @entrada=(select MAX(mensajesEntrada) from bandeja)+1;
             SET @salida=(select MAX(mensajesSalida) from bandeja)+1;
			 
			 insert into bandeja(usuario,mensajesEntrada,mensajesSalida,NUEVO_MENSAJE) values(trim('".$_POST['usuario']."'),@entrada,@salida,0);
               insert into Usuario(usuario,contrasena,email,estado,nombre,fecha_ingreso,numero_consultas) values(trim('".$_POST['usuario']."'),'".$_POST['contrasena']."','".$_POST['email']."','".$_POST['estado']."','".$_POST['nombre']."',sysdate(),1);";
			  
                          echo $query_search;
			  if(!$mysqli->multi_query($query_search)){
			    $resultado='1';
				echo mysql_error();
				echo $query_search;
				 }


		$mysqli->close();
		

		} catch (Exception $e) {
		   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		   $resultado='1';
		}

		//$json['enviado'][]="{'correcto':'".$resultado."'}";
                echo json_encode(array("correcto"=>$resultado));
   break;

      

}
?>