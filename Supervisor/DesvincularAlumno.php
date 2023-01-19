<?php  
include '../funciones.php';

$config = include '../config.php';
$resultado = [
	'error'=>false,
	'mensaje'=>''
];
try{
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['option']); //conexion a bdd con root
  $emailAlumno = $_GET['email'];
  $consultaSQL= "UPDATE estudiantes SET rutSupervisor = 'NA' WHERE email = '$emailAlumno"; //eliminar datos de la base de datos
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();
  header('Location: AlumnosSupervisor.php');
} catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
?>