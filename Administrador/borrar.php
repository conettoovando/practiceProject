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
  $id = $_GET['id'];
  if ($_GET['rol'] == "Jefe de carrera"){
    $consultaSQL = "SELECT rutJefeCarrera FROM jefecarrera WHERE email='$id'"; //eliminar datos de la base de datos
    $array = $conexion->prepare($consultaSQL);
    $array->execute();
    $array = $array->fetch(PDO::FETCH_ASSOC);
    $rutJefe = $array['rutJefeCarrera'];
    $consultaSQL = "UPDATE carrera SET Rutjefe='NAJefe' WHERE Rutjefe = '$rutJefe'"; //eliminar datos de la base de datos
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  }
  $consultaSQL= "DELETE FROM informacion WHERE email='$id'"; //eliminar datos de la base de datos
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();
  if ($_GET['rol'] == "Alumno"){
    $consultaSQL= "DELETE FROM estudiantes WHERE email='$id'"; //eliminar datos de la base de datos
  }
  if ($_GET['rol'] == "Tutor"){
    $consultaSQL= "DELETE FROM supervisor WHERE email='$id'"; //eliminar datos de la base de datos
  }
  if ($_GET['rol'] == "Jefe de carrera"){
    $consultaSQL= "DELETE FROM jefecarrera WHERE email='$id'"; //eliminar datos de la base de datos
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  }
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();
  $consultaSQL= "DELETE FROM usuarios WHERE email='$id'"; //eliminar datos de la base de datos
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  header('Location: index.php');
} catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
?>

<?php include "../templates/header.php"; ?>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger" role="alert">
        <?= $resultado['mensaje'] ?> <!-- Mensaje de alerta de aprobacion o rechazo -->
      </div>
    </div>
  </div>
</div>

<?php include "../templates/footer.php"; ?>