<?php
session_start();
require '../conexion.php';
date_default_timezone_set("America/Santiago");
$fechaActual = date("Y-m-d");
$mail = $_SESSION['Usuarios']['mail'];
$query = "SELECT CodigoCarrera from estudiantes where email = '$mail'";
$consulta = mysqli_query($conexion, $query);
$CodigoCarrera = mysqli_fetch_array($consulta);
$CodigoCarrera = $CodigoCarrera['CodigoCarrera'];

$query = "SELECT Rutjefe from carrera where CodigoCarrera = '$CodigoCarrera'";
$consulta = mysqli_query($conexion, $query);
$Rutjefe = mysqli_fetch_array($consulta);
$Rutjefe = $Rutjefe['Rutjefe'];

$query = "SELECT rutSupervisor from estudiantes where CodigoCarrera = '$CodigoCarrera'";
$consulta = mysqli_query($conexion, $query);
$rutSupervisor = mysqli_fetch_array($consulta);
$rutSupervisor = $rutSupervisor['rutSupervisor'];

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis bitacoras</title>
    <link rel="icon" href="../favicon/bitacora.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/tabla.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <?php
        $mail = $_SESSION['Usuarios']['mail'];
        $rut = $_SESSION['Usuarios']['rut'];
               
        if (isset($_POST['enviar'])){
            if ($rutSupervisor == 'NA' || $Rutjefe == 'NAJefe'){
                header('location: finalpractica.php');
            }else{
                $usuario = $_SESSION['Usuarios']['mail'];
                $query = "SELECT CodigoCarrera from estudiantes where email = '$mail'";
                $consulta = mysqli_query($conexion, $query);
                $CodigoCarrera = mysqli_fetch_array($consulta);
                $CodigoCarrera = $CodigoCarrera['CodigoCarrera'];
                
                $query = "SELECT Rutjefe from carrera where CodigoCarrera = '$CodigoCarrera'";
                $consulta = mysqli_query($conexion, $query);
                $Rutjefe = mysqli_fetch_array($consulta);
                $Rutjefe = $Rutjefe['Rutjefe'];

                $query = "SELECT rutSupervisor from estudiantes where CodigoCarrera = '$CodigoCarrera'";
                $consulta = mysqli_query($conexion, $query);
                $rutSupervisor = mysqli_fetch_array($consulta);
                $rutSupervisor = $rutSupervisor['rutSupervisor'];
                
                $ruta = "../upload/".$mail."/Informe_Completo/".$_FILES['fichero']['name'];
                if(is_uploaded_file($_FILES['fichero']['tmp_name'])){
                    if(file_exists("../upload/".$mail) == false){
                        mkdir("../upload/".$mail);
                    }
                    if(file_exists("../upload/".$mail."/Informe_Completo") == false){
                        mkdir("../upload/".$mail."/Informe_Completo");
                    }
                    if (move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta)){
                        $size = $_FILES['fichero']['size'];
                        $query = "INSERT INTO informefinal (fechaEntrega, fechaCalificacion, calificacionSupervisor, ObservacionSupervisor,ObservacionJefeCarrera, calificacionJefeCarrera, calificacionFinal, rutEstudiante, rutJefeCarrera, ruta, size) VALUES ('$fechaActual', 'P', 'P', 'P', 'P', 'P','P', '$rut', '$Rutjefe', '$ruta','$size')";
                        $sentencia = $conexion->prepare($query);
                        $sentencia->execute();
                    }
                }
            }
            }                  
   
        if (isset($_POST['cerrar'])){ //Cerrar sesión
            session_destroy();
            header('location: ../session.php');
        }
        if (isset($_POST['atras'])){ //Cerrar sesión
            header('location: alumno.php');
        }
        
        ?>
        <?php
        $usuario = $_SESSION['Usuarios']['mail'];
        $query = "SELECT count(idInforme) from informefinal where rutEstudiante= '$rut'";
        $consulta = mysqli_query($conexion, $query);
        $array = mysqli_fetch_array($consulta);

?>
    <div class="container mt-2">
        <div class="row" style="margin-top:9%;">
            <div class="card mt-4" style="background-color:rgb(169,4,41);">
                <?php
                    if (intval($array[0]) == 0){
                        ?> 
                        <div class="functionsss text-center">
                        <span><strong>Adjunta tu Informe Final Acá </strong></span><br>
                            <div class="bgimgg mt-3 ">
                                    <img src="../IMG/adjunto-archivo.png" alt="adjunto" class="img-fluid mt-3" style="width:50%;"><br>

                            </div>
                            <input name=fichero type=file class="form-control btn btn-warning mt-4 ml-4 text-center " style="width:40%;" accept=.pdf> <br>
                            <?php echo "
                            <script type=text/javascript>
                            function sb(){
                                if ('$rutSupervisor' == 'NA' || '$Rutjefe' == 'NAJefe'){
                                    if('$rutSupervisor' == 'NA'){
                                        window.alert('No cuenta con supervisor registrado');
                                    }else{
                                        window.alert('Su carrera no tiene un jefe de carrera asignado');
                                    }
                                }                                
                            }
                            </script>"
                            ?>
                            <button onclick="sb()" id="enviar" name="enviar"  class="btn btn-success btn-lg  mt-4 ml-4 mr-4 text-center">Enviar</button><br>
                            <button name="atras"  class="btn btn-primary btn-lg mt-4 text-center" style="width:140px" >Atrás</button>
                            <button name="cerrar" class="btn btn-dark btn-lg mt-4 text-center">Cerrar Sesión</button>
                        </div>
                        
                        <br>
                        <?php
                    }
                        if (intval($array[0]) > 0){
            
                            header('Location:../prueba.php');
                        }
                        ?>
                 
            
            
                    <br>
            </div>
           
        </div>

   
    </div>
      
        
    </form>
</body>
</html>