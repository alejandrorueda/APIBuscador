<?php 

try {
$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u334727470_medic";
$username_localhost ="u334727470_medic";
$password_localhost ="frende5557111";
$cadenaSintomas=implode(" ",array_filter(explode(" ", TRIM($_POST['sintomas']))));
$str = explode(" ", TRIM($cadenaSintomas));

//echo $_POST['sintomas'];
$i  = 0;
$k =0;
$j = 0;
$l = 0;
$nsintomas = count($str);
//$nsintomas = $nsintomas-1;
//coincidencias repetidos;
$cadena ="";
$j=-1;
$coindicencias1 = true;
//$resultados['patologias'][0]=
$proposiciones=array('a', 'ante', 'bajo', 'con', 'contra', 'de', 'desde', 'en', 'entre','hacia','hasta','para','por', 'según', 'sin', 'so', 'sobre', 'tras', 'durante', 'mediante');
$str=array_diff($str, $proposiciones); 
$resultados = array();
$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
//echo $numeroCoincidencias[$row['Patologia']];

while ( $j <$nsintomas ) 
   {
        $j=$j+1;
	 $cadena="";
     $putolike = strtolower($str[$j]); 
     $putolike = '%'.$putolike.'%'.$j;
     $query_search = "select * from patologia_sintoma where Sintoma= lower(TRIM('".$str[$j]."')) OR  Sintoma LIKE '".$putolike."';";
	// echo "p ".$j;
	 $query_exec = mysqli_query($mysqli, $query_search);
	 $coindicencias1=true;
	 //echo $putolike;
	 if(mysqli_num_rows($query_exec)>0){
						
						  $i = $i+1;
						  $k = $k+1;
					
                       while ($coindicencias1 && $j<$nsintomas ) {
                            $cadena = $cadena." [[:<:]]".TRIM(strtolower($str[$j]))."[[:>:]]";
							$query_search = "select * from patologia_sintoma where Sintoma REGEXP '".TRIM($cadena)."';";
							$query_exec = mysqli_query($mysqli, $query_search);
                            $coindicencias1=false;
                            //echo 'Coincidencia '.$query_search;
							
                            if(mysqli_num_rows($query_exec)>0){
                               unset($rep);
                               $numeroCoincidencias=$numeroCoincidenciasGeneral;
							//   echo 'Coincidencia '.$query_search;
                               while($row=mysqli_fetch_array($query_exec)){
                                $patologia['Nombre'] = $row['Patologia'];
                                    if(isset($numeroCoincidencias[$row['Patologia']])){
																
									$numeroCoincidencias[$row['Patologia']]+=1;					
									$patologia['Numero'] = $numeroCoincidencias[$row['Patologia']];
									}
									else{
									$patologia['Numero'] = 1;
									$numeroCoincidencias[$row['Patologia']]=1;
									}
                                    $coindicencias1=true;
                                    $rep['patologias'][] = $patologia;


                               }
                            }

                            if($coindicencias1){
							  $j=$j+1;
							 }
                             else{ 
							   $j=$j-1;
							   $numeroCoincidenciasGeneral=$numeroCoincidencias;
							   
							 }
                       }
                     $resultados=array_merge((array)$resultado,(array)$rep);				
	                			
                    }

}

echo json_encode($resultados);

$mysqli->close();

} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

?>
