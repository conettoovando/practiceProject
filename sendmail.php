<?php
/*
//
// *** To Email ***
$to = 'b.rodrguezsuazo@gmail.com';
//
// *** Subject Email ***
$subject = 'yo';
//
// *** Content Email ***
$content = 'oe paga la wea de codigo no trabajo \n gratis';
//
//*** Head Email ***
$headers = "From: practice.unb@gmail.com\r\n";
//
//*** Show the result... ***
if (mail($to, $subject, $content, $headers))
{
	echo "Success !!!";
} 
else 
{
   	echo "ERROR";
}*/

$config = include "config.php";
date_default_timezone_set("America/Santiago");
require "conexion.php";


#$today = date('d/m/Y', strtotime("this week"));
$today = date("Y-m-d");
$today = date("Y-m-d", strtotime($today."- 7 days"));
$dateQuery = date("Y-m-d", strtotime($today."- 7 days"));
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conex = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);

$consultaSQL = "SELECT * from bitacora where fechaBitacora BETWEEN '$dateQuery' and '$today' ORDER BY fechaBitacora ASC";
$array = $conex->prepare($consultaSQL);
$array->execute();
$array = $array -> fetchAll();

$SemanasTabla = [];
$fechaActual = date("d-m-Y");
foreach ($array as $rd){
	$date = $rd['fechaBitacora'];
	$date = strtotime($date);
	$semana = date("W", $date);
	if (!key_exists($semana, $SemanasTabla)){
		$SemanasTabla[$semana] = date("d-m-Y",$date);
	}elseif(key_exists($semana, $SemanasTabla)){
		if ($SemanasTabla[$semana] > $date){
			$SemanasTabla[$semana] = date("d-m-Y",$date);
		}
	}
	
}
foreach ($array as $rd ){
	$date = $rd['fechaBitacora'];
	$date = new DateTime($date);
	$year = $date -> format('Y');
	$month = $date -> format('m');
	$day = $date -> format('d');

	$diaSemana = date('w', mktime(0,0,0,$month,$day, $year));

	if ($diaSemana == 0){
		$diaSemana=7;
	}
	$ultimoDia=date("d-m-Y",mktime(0,0,0,$month,$day,$year));
	$_7Dias = date("d-m-Y", strtotime($ultimoDia."+ 7 days"));
	$_14Dias = date("d-m-Y", strtotime($ultimoDia."+ 14 days"));

	if (in_array($ultimoDia, $SemanasTabla)){
		if (strtotime($fechaActual) >= strtotime($_7Dias) && ($rd['respuestaBitacora'] === '' ||  $rd['respuestaBitacora'] === "Sin Respuesta")){
			if (strtotime($fechaActual) >= strtotime($_14Dias)){
				$segundaSemana = array_key_last($SemanasTabla);
				$rutEstudiante = $rd['rutEstudiante'];
				echo $rutEstudiante;
				$query = "SELECT estudiantes.*, informacion.*, supervisor.email as emailSupervisor, carrera.*, jefecarrera.email as emailJefe from estudiantes INNER JOIN informacion INNER JOIN supervisor INNER JOIN carrera INNER JOIN jefecarrera where estudiantes.rutEstudiante = '$rutEstudiante' and estudiantes.email = informacion.email and supervisor.rutSupervisor = estudiantes.rutSupervisor and estudiantes.CodigoCarrera = carrera.CodigoCarrera and jefecarrera.rutJefeCarrera = carrera.Rutjefe";
				$consulta = mysqli_query($conexion, $query);
				$informacionAlumno = mysqli_fetch_array($consulta);

				if ($informacionAlumno['rutSupervisor'] !== 'NA'){
					$emailSupervisor = $informacionAlumno['emailSupervisor'];
					print_r ($emailSupervisor);
					$query = "SELECT * from informacion where email = '$emailSupervisor'";
					$consulta = mysqli_query($conexion, $query);
					$informacionSupervisor = mysqli_fetch_array($consulta);

					$to = 'b.rodrguezsuazo@gmail.com';#$informacionAlumno['Rutjefe'];
					$subject = "practice.unb@gmail.com";
					$content = 'Hola, el docente '.$informacionSupervisor['Nombre'].' '.$informacionSupervisor['ApellidoPat'].' no ha revisado sus bitácoras pendientes, consulte y analice esta situación en caso de que '.$informacionSupervisor['Nombre'].' '.$informacionSupervisor['ApellidoPat'].' no siga en Practice!';
					$headers = "From: practice.unb@gmail.com\r\n";

					if (mail($to, $subject, $content, $headers))
						{
							echo "Success !!!";
					} 
					else 
					{
						echo "ERROR";
					}
				}

				

			}else{
				$query = "SELECT estudiantes.*, informacion.*, supervisor.email as emailSupervisor, carrera.*, jefecarrera.email as emailJefe from estudiantes INNER JOIN informacion INNER JOIN supervisor INNER JOIN carrera INNER JOIN jefecarrera where estudiantes.rutEstudiante = '$rutEstudiante' and estudiantes.email = informacion.email and supervisor.rutSupervisor = estudiantes.rutSupervisor and estudiantes.CodigoCarrera = carrera.CodigoCarrera and jefecarrera.rutJefeCarrera = carrera.Rutjefe";
				$consulta = mysqli_query($conexion, $query);
				$informacionAlumno = mysqli_fetch_array($consulta);

				$query = "SELECT * from informacion where email = '$informacionAlumno[emailSupervisor]'";
				$consulta = mysqli_query($conexion, $query);
				$informacionSupervisor = mysqli_fetch_array($consulta);

				$to = 'b.rodrguezsuazo@gmail.com';#$informacionSupervisor['email'];
				$subject = "practice.unb@gmail.com";
				$content = "Hola, tienes bitácoras pendientes a evaluar, ¡ingresa a Practice! para evaluarlas";
				$headers = "From: practice.unb@gmail.com\r\n";

				if (mail($to, $subject, $content, $headers)){
					echo "Success !!!";
				} 
				else{
					echo "ERROR";
				}
			}
		}
	}
	
	
	
}

?>