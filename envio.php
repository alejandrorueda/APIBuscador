<?PHP
$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u334727470_medic";
$username_localhost ="u334727470_medic";
$password_localhost ="frende5557111";
$localhost = mysql_connect($hostname_localhost,$username_localhost,$password_localhost)
or
trigger_error(mysql_error(),E_USER_ERROR);

$usuarios = explode(" ", $_POST['destinatarios']);

$nusuarios=count($usuarios);
$resultado=0
try {
mysql_select_db($database_localhost, $localhost);
FOR ($i=0;$i<$nusuarios;$i++){
  $query_search = 
     "update bandeja b set b.NUEVO_MENSAJE=1 where usuario=TRIM("+usuarios[i].");
     
      insert into mensaje(idmensaje,asunto,destinatario,emisor,mensaje,fecha,leido) values(NULL,".$_POST['asunto'].",".usuarios[i].",".$_POST['emisor'].",".$_POST['mensaje'].",sysdate(),0);
	  SET @idmensaje=LAST_INSERT_ID();
      insert into  BANDEJAENTRADA(idbandeja,numero,mensaje) values((select mensajesEntrada from bandeja where usuario=".usuarios[i]."),NULL,@idmensaje);
   
      insert into  BANDEJASALIDA(idbandeja,numero,mensaje) values((select mensajesEntrada from bandeja where usuario=".$_POST['emisor']."),NULL,@idmensaje);";
	  if(!mysql_query($query_search)){
	    $resultado=1;
	     }
}

mysql_close($localhost);
echo $resultado;

} catch (Exception $e) {
   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
   echo 1;
}
?>