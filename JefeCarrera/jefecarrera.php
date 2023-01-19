<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/jefe.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Sistema de practica</title>
</head>
<body>
    <style>
        table, tr,th{
            border: 1px solid ;
            width: 800px;
            text-align: center;
        }
        td{
            border-bottom: 1px solid;
        }
    </style>
  
    <?php
    session_start();
    $rutJefeCarrera = $_SESSION['Usuarios']['rut'];
    $config = include '../config.php';
    $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
    $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
    $consultaSQL = "SELECT COUNT(*) FROM informefinal";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();
    $array = $array ->fetch();
    if ($array['COUNT(*)'] == 0){
        echo "<h2>No existen Estudiantes con practica finalizada</h2>";
    }else{
        $consultaSQL = "SELECT informefinal.IdInforme,informefinal.rutJefeCarrera, informefinal.calificacionFinal, estudiantes.*, informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat, informefinal.calificacionJefeCarrera FROM informefinal INNER JOIN estudiantes on informefinal.rutEstudiante = estudiantes.rutEstudiante INNER JOIN informacion on estudiantes.email = informacion.email WHERE informefinal.rutJefeCarrera = '$rutJefeCarrera'";
        $array = $conexion->prepare($consultaSQL);
        $array->execute();
        $array = $array ->fetchAll();
?>
<nav class="navbar ">
<div class="container ">
    <a class="navbar-brand ">
      <div class="logo-image ">
      <img src="../IMG/logo.png" class="img-fluid text-center navbar-brand-center" style="width:10%;">
      </div>
    </a>
</div>
</nav>


        <div class="d-flex align-items-center justify-content-around text-center pumcon mt-3" >
            <h1>Sistema de validación de Practica</h1>
        </div>
        <div class="d-flex align-items-center justify-content-around text-center conoc mt-5">
            <div class="d-flex flex-column justify-content-center table-responsive">
            <h1 class="movil">Mueve hacia la derecha para ver mas información</h1>
                <h1 style="color:white">Alumnos</h1>
                <i class="fa-solid fa-graduation-cap" style="width:50px; margin:0 auto;"></i>
                <table class="table-striped mt-4">
                <tr>
                    <th>Estudiante</th>
                    <th>Rut</th>
                    <th>Mail</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
                    <?php
                    foreach ($array as $alumnos){
                        if ($alumnos['calificacionJefeCarrera'] == "P"){
                        ?>
                        <tr>
                            <td><?php echo $alumnos['Nombre']." ".$alumnos['ApellidoPat']." ".$alumnos['ApellidoMat'] ?></td>
                            <td><?php echo $alumnos['rutEstudiante'] ?></td>
                            <td><?php echo $alumnos['email'] ?></td>
                            <td><?php echo $alumnos['calificacionJefeCarrera'] ?></td>
                            <form action="evaluar.php" method="get">
                                <td>
                                    <input type="hidden" name = "Alumno" value=<?php echo $alumnos['IdInforme'] ?>>
                                    <button type="submit" value="Calificar" class="btn btn-warning"  style="width:100%"><i class="fa-solid fa-check"> &nbspCalificar</i></button>
                                </td>
                            </form>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                </table>
                <form method="post">
                    <input type="submit" name="Cerrar" class="mt-4 mb-4  btn btn-dark" value="Cerrar Sesión">
                </form>
            </div>
        </div>


    <?php
        if(isset($_POST['Cerrar'])){
            session_destroy();
            header('location: ../session.php');
        }
        ?>
       
    </body>
    </html><?php
    }
?>
    