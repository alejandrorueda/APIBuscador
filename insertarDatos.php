<?php 

$hostname_localhost ="mysql.hostinger.es";
$database_localhost ="u334727470_medic";
$username_localhost ="u334727470_medic";
$password_localhost ="frende5557111";

$mysqli = new mysqli($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);
 
$DS = '/';
 
 set_include_path(implode(PATH_SEPARATOR, array(
                    realpath('lib' . $DS . 'PHPexcel' . $DS . 'Classes' . $DS),
                    get_include_path(),
                )));
				
require_once("PHPExcel/IOFactory.php");
 $nombreArchivo = 'datos.xlsx';
// Cargo la hoja de cálculo
 $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);			

//Asigno la hoja de calculo activa
$objPHPExcel->setActiveSheetIndex(0);
//Obtengo el numero de filas del archivo
$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 

$query_search = "DELETE FROM patologia_sintoma;";
mysqli_query($mysqli, $query_search);

$query_search = "DELETE FROM Sintoma;";
mysqli_query($mysqli, $query_search);


$query_search = "DELETE FROM patologia;";
mysqli_query($mysqli, $query_search);
	

for ($i = 2; $i <= $numRows; $i++) {
    
    $informacion[] = array(
        'nombre' => $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
        'apellido' => $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()
        
    );
	$query_search = "insert into patologia_sintoma(Patologia,Sintoma) values('".$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()."','".$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()."');";
	if(!$query=mysqli_query($mysqli, $query_search)){
		echo mysql_error();
		echo $query_search;
	}

    $query_search = "insert into patologia(Nombre) values('".$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue()."');";
	if(!$query=mysqli_query($mysqli, $query_search)){
		echo mysql_error();
		echo $query_search;
	}

    $query_search = "insert into Sintoma(Nombre) values('".$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()."');";
	if(!$query=mysqli_query($mysqli, $query_search)){
		echo mysql_error();
		echo $query_search;
	}			
   
			
 }
 
  $mysqli->close();
 


				
?>	