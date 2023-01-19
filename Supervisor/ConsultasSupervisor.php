<?php
session_start();
$Usuario = $_SESSION['Usuarios']['user'] . " " . $_SESSION['Usuarios']['ApellidoPat'];
$config = include '../config.php';
$rutSupervisor = $_SESSION['Usuarios']['rut'];
$mail = $_SESSION['Usuarios']['mail'];


if(isset($_POST['VolverAtras'])){
    header("location:Supervisor.php");
}

if (isset($_POST['CerrarSession'])){
    session_destroy();
    header('location: session.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Potta+One&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/consultas2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="bgbotones">
        <div class="botones-izquierda">
        </div>
            <div class="Titulo-menu"> 
                <h2>Consultas</h1>
            </div>
                <button class="btn btn-secondary btn-lg mt-4" style="width:80%;" type="submit" name="MisConsultas" onclick="location.href='Supervisor.php'">Volver atrás</button>
                <form  method="post">
                    <button type="submit" class="btn btn-warning btn-lg mt-4"style="width:80%;"name="CerrarSession">Cerrar Sesión</button>     
                </form>
    </div>      


<div class="d-flex align-items-center justify-content-around text-center conoc mt-4">

    <div class="Consultas  mt-4 mb-4 table-responsive">
    <h1 class="desliz mb-4" style="color:black; font-family: 'Potta One', cursive;">Deslize hacia la derecha para mas informacion</h1>
        <table class="table">
            <tr>
                <th>Rut Estudiante</th>
                <!-- NOMBRE ESTUDIANTE-->
                <th>Consulta</th>
                <th>Accion</th>
            </tr>
            <?php
            require "../conexion.php";
            $query = "SELECT RutSupervisor from supervisor WHERE email ='$mail'";
            $consulta=mysqli_query($conexion,$query);
            $rutEstudiante=mysqli_fetch_array($consulta); 
            $_SESSION['Usuarios']['rut'] = $rutEstudiante['RutSupervisor'];
            $rut = $_SESSION['Usuarios']['rut'];
            $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
            $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
            $consultaSQL = "SELECT estudiantes.rutEstudiante, consultas.idconsultas,consultas.descripcionconsulta,consultas.fecha FROM estudiantes INNER JOIN consultas WHERE consultas.rutEstudiante = estudiantes.rutEstudiante AND estudiantes.rutSupervisor='$rut'";
            $array = $conexion->prepare($consultaSQL);
            $array->execute();
            $array = $array -> fetchAll();

            foreach ($array as $alumnos){?>
            <tr>
                <td><?php echo $alumnos['rutEstudiante']; $idAlumno = $alumnos['idconsultas']; ?></td>
                <td><?php echo $alumnos['descripcionconsulta'] ?></td>  
                <form action="responderConsulta.php" method="get">
                    <td>
                        <input type="hidden" name = "Alumno" value=<?php echo $alumnos['idconsultas'] ?>>
                        <button type="submit" class="btn btn-success btn-sm" value="Calificar"><i class="fa-solid fa-pen-to-square">&nbspCalificar</i></button>             
                    </td>
                </form>
            </tr>
            
        <?php
        }?>
        </table>
    </div>
</div>

</body>
</html>