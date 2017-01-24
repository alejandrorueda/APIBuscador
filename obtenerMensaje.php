<?PHP
$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u334727470_medic";
$username_localhost ="u334727470_medic";
$password_localhost ="frende5557111";


switch($_POST['operacion']){
    case "0":
	try {
	/*$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
	or
	trigger_error(mysql_error(),E_USER_ERROR);*/
	
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	$query_search = "select * from mensaje WHERE idmensaje=ANY(select mensaje from BANDEJAENTRADA where idbandeja=(SELECT mensajesEntrada from bandeja where usuario='".$_POST['usuario']."'))";
	//echo $query_search;
	$query_exec = mysqli_query($mysqli, $query_search);
	$json = array();	
		if(mysqli_num_rows($query_exec)){
			while($row=mysqli_fetch_array($query_exec)){
			$json['mensajes'][]=$row;
			}
		}		
		$actualizar = mysqli_query($mysqli,"update bandeja m set nuevo_mensaje  =0 where usuario ='".$_POST['usuario']."';");
		//echo $actualizar;
		//echo "update bandeja m set m.nuevo_mensaje  =0 where usuario =".$_POST['usuario'].";";
		$mysqli->close();

		echo json_encode($json);
	} catch (Exception $e) {
	   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	   //echo 1;
	   
	}
    break;
	
	case "1":
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	  $usuarios = explode(" ", $_POST['destinatarios']);

		$nusuarios=count($usuarios);
		$resultado='0';
		echo $nusuarios;
		try {
		//mysql_select_db($database_localhost, $localhost);
		FOR ($i=0;$i<$nusuarios;$i++){
		  $query_search = 
			 "update bandeja b set b.NUEVO_MENSAJE=1 where usuario=TRIM('".$usuarios[$i]."');
			 
			  insert into mensaje(idmensaje,asunto,destinatario,emisor,mensaje,fecha,leido) values(NULL,'".$_POST['asunto']."','".$usuarios[$i]."','".$_POST['emisor']."','".$_POST['mensaje']."',sysdate(),0);
			  SET @idmensaje=LAST_INSERT_ID();
			  insert into  BANDEJAENTRADA(idbandeja,numero,mensaje) values((select mensajesEntrada from bandeja where usuario='".$usuarios[$i]."'),NULL,@idmensaje);
		   
			  insert into  BANDEJASALIDA(idbandeja,numero,mensaje) values((select mensajesEntrada from bandeja where usuario='".$_POST['emisor']."'),NULL,@idmensaje);
			  update bandeja m set m.nuevo_mensaje  =1 where usuario =".$usuarios[$i].";
			  ";
                          echo $query_search;
			  if(!$mysqli->multi_query($query_search)){
			    $resultado='1';
				echo mysql_error();
				echo $query_search;
				 }
		}

		$mysqli->close();
		

		} catch (Exception $e) {
		   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		   $resultado='1';
		}

		//$json['enviado'][]="{'correcto':'".$resultado."'}";
                echo json_encode(array("correcto"=>$resultado));
	break;
	
	
	
	case "2":
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	  $resultado='0';
		try {
		//mysql_select_db($database_localhost, $localhost);
		
		  $query_search = "DELETE FROM BANDEJAENTRADA WHERE mensaje =".$_POST['idmensaje'].";";
                          
			echo $query_search;
			  if(!$query = mysqli_query($mysqli,$query_search)){
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
	
		case "3":
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	
		$resultado='0';
		try {
		//mysql_select_db($database_localhost, $localhost);
		
		  $query_search = "update mensaje m set leido =1 where idmensaje =".$_POST['idmensaje'].";";
                          
			echo $query_search;
			  if(!$query = mysqli_query($mysqli, $query_search)){
			    $resultado='1';
				echo mysql_error();
				echo $query_search;
				 }


		$mysqli->close();
		

		} catch (Exception $e) {
		   echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		   $resultado='1';
		}

		//$json['enviado'][]="{'correcto':'".$resultado."'}";
                echo json_encode(array("correcto"=>$resultado));
	break;
	
	case "4":
	$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
	
		$resultado='-1';
		try {
		//mysql_select_db($database_localhost, $localhost);
		
		  $query_search ="select nuevo_mensaje from bandeja where usuario ='".$_POST['usuario']."';";
  
			  if(!$query = mysqli_query($mysqli, $query_search)){
			   
				echo mysql_error();
				echo $query_search;
				 }else{
				   if(mysqli_num_rows($query)){
					while($row=mysqli_fetch_array($query)){
					$resultado=$row['nuevo_mensaje'];
			        }
				 
				 }
				 
		
		}			 


		$mysqli->close();
		

		} catch (Exception $e) {
		   echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		   $resultado='-1';
		}

		//$json['enviado'][]="{'correcto':'".$resultado."'}";
                echo json_encode(array("nuevomensaje"=>$resultado));
	break;


}
?>