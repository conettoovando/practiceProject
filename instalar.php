<?php 
$config= include 'config.php';

try {
	$conexion = new PDO('mysql:host='.$config['db']['host'],$config['db']['user'],$config['db']['pass'],$config['db']['option']); 
	$sql=file_get_contents('data/based.sql');
	$conexion->exec($sql); //instalar base de datos
	echo "La base de Datos Estudiantes y la Tabla Login y Usuarios se crearon con Éxito";
} catch(PDOException $error){
	echo $error->getMessage();
}
?>