<?php
session_start();
$config = include "../config.php";
$nombreUsuario = $_SESSION['Usuarios']['user']. " ".$_SESSION['Usuarios']['ApellidoPat'];
require "../conexion.php";
$mail = $_SESSION['Usuarios']['mail'];
$query = "SELECT RutSupervisor from supervisor WHERE email ='$mail'";
$consulta=mysqli_query($conexion,$query);
$rutTutor=mysqli_fetch_array($consulta); 
$_SESSION['Usuarios']['rut'] = $rutTutor['RutSupervisor'];


if (isset($_POST['CerrarSession'])){
    session_destroy();
    header('location: ../session.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sup.css">
    <title>Supervisor</title>
</head>
<body>
    <div class="bg">
        <img src="images/bg.jpg" alt="">
    </div>

    <div class="d-flex align-items-center justify-content-around text-center pumcon mt-3">
        <h1 class="tit">Bienvenid@ <?php echo " ".$nombreUsuario ?></h1>
    </div>


    <div class="bgbotones container-fluid">
            <div class="Titulo-menu" style="width:100%"> 
                <h1 class="mt-3">MENU</h1>
            </div>
            <div class="bgimgg mt-4">
                <img src="../IMG/profesor.png" class="imgg" alt="" srcset="">    
            </div>
            
                <button class="btn btn-success btn-lg mt-3 " style="font-weight:bold" type="submit" name="MisConsultas" onclick="location.href='ConsultasSupervisor.php'">Mis Consultas</button><br>
                <button type= "submit" class="btn btn-success btn-lg mt-3" style="font-weight:bold" name="MisAlumnos" onclick="location.href='AlumnosSupervisor.php'">Mis Alumnos</button><br>


                <button type= "submit"class="btn btn-success btn-lg mt-3" style="font-weight:bold"name="AgregarAlumnos" onclick="location.href='AgregarAlumnos.php'">Agregar Alumnos</button><br>

     
                <form action="" method="post">
                    <button type="submit"class="btn btn-warning btn-lg mt-3 mb-2 style="font-weight:bold" name="CerrarSession">Cerrar Sesión</button>     
                </form>

    </div>      
    
</body>
</html>

