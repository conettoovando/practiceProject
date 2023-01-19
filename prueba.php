<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/prueba.css" rel="stylesheet">
    <title>Practice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="favicon/empleados.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">    <title>Document</title>
</head>
<body>
<?php

require 'conexion.php';
session_start();
$rut = $_SESSION['Usuarios']['rut'];
$usuario = $_SESSION['Usuarios']['mail'];
$query = "SELECT * from informefinal where rutEstudiante= '$rut'";
$consulta = mysqli_query($conexion, $query);
$array = mysqli_fetch_array($consulta);
$fechaEntrega = $array['fechaEntrega'];
$fechaCalificacion = $array['fechaCalificacion'];
$calificacionSupervisor = $array['calificacionSupervisor'];
$ObservacionSupervisor = $array['ObservacionSupervisor'];
$calificacionJefeCarrera = $array['calificacionJefeCarrera'];
$calificacionFinal = $array['calificacionFinal'];
$rutEstudiante = $array['rutEstudiante'];
$ObservacionJefeCarrera = $array['ObservacionJefeCarrera'];

$user = $_SESSION['Usuarios']['mail'];
$query = "SELECT EXISTS (SELECT * from informefinal where rutEstudiante='$rut')";
$consulta = mysqli_query($conexion, $query);
$array = mysqli_fetch_array($consulta);


$query = "SELECT estudiantes.rutEstudiante, estudiantes.email, informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat FROM estudiantes JOIN informacion where informacion.email = estudiantes.email and rutEstudiante ='$rut'";
$consulta = mysqli_query($conexion, $query);
$informacionEstudiante = mysqli_fetch_array($consulta);

if ($array[0] == 0){
header('location:alumno.php');
}
if (isset($_POST['cerrar_session'])){
    session_destroy();
    header('location: session.php');
}
?>

<div class="card mt-4 text-center" style="background-color:rgb(169,4,41); width:50%;margin:0 auto;">
<h1 class="text-center mt-4" style="color:white;">Proceso de validación de Informe Final</h1>
    </div>
<div class="container " style="margin: 0 auto; width:100%;">
    <div class="row mt-2" >
    
        <div class="card mt-1" style="background-color:rgb(169,4,41); width:80%; margin:0 auto;">
      
            
            <div class="bg text-center" id="bgimg">
                <img src="IMG/validacion.png" alt="" srcset="" style="width:150px;margin:0 auto;" class="image-fluid mb-4" >
            </div>
            <div class="bgli">
            <ul>
                <li class="text-center" style="font-weight:bold; font-size:15px;color:white;"><?php echo "Rut:&nbsp".$informacionEstudiante['rutEstudiante']; ?></li>
                <li class="text-center"style="font-weight:bold;color:white;"><?php echo "Email:&nbsp".$informacionEstudiante['email']; ?></li>
                <li class="text-center"style="font-weight:bold; font-size:15px;color:white;"><?php echo "Calificacion Jefe Carrera:&nbsp".$calificacionJefeCarrera; ?></li>
                <li class="text-center"style="font-weight:bold; font-size:15px;color:white;"><?php echo "Calificacion Supervisor:&nbsp".$calificacionSupervisor; ?></li>
                <li class="text-center"style="font-weight:bold; font-size:15px;color:white;"><?php echo "Calificacion Final:&nbsp".$calificacionFinal; ?></li>
                <li class="text-center"style="font-weight:bold; font-size:15px;color:white;"><?php echo "Observacion Supervisor:&nbsp".$ObservacionSupervisor; ?></li>
                <li class="text-center mb-4"style="font-weight:bold; font-size:15px;color:white;"><?php echo "Observacion Jefe Carrera:&nbsp".$ObservacionJefeCarrera; ?></li>
                </ul>
            </div>
        </div>
    </div> 
</div>
<form method="post">
    <div>
        <button type="submit" name="cerrar_session">Cerrar Session</button>
    </div>
</form>




</body>
</html>



