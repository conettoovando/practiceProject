<?php
session_start();
$config = include "../config.php";
$rutTutor = $_SESSION['Usuarios']['rut'];

if(isset($_POST['cerrarSession'])){
    session_destroy();
    header('location: session.php');
}
if(isset($_POST['volver'])){
    header("location:Supervisor.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" href="../css/consultas2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Mis alumnos</title>
</head>
<body>


<div class="d-flex align-items-center justify-content-around text-center conoc mt-4">
    
<div class="botonn mt-4">
        <button class="btn btn-danger btn-mg"style="font-weight:bold;"onclick="location.href='Supervisor.php'">Volver atrás</button>
    </div>
    
    <br>    
    
    <div class="Consultas mt-4 mb-4 table-responsive">
        <h2 class="mb-2"style="color:black;font-weight:bold;margin-bottom:15px;">Mis Alumnos</h2>
    <table class="table mt-4 mr-3">
        <tr>
            <th>Rut</th>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Bitacoras</th>
            <th>Evaluar</th>
            <th>Accion</th>
        </tr>
        <?php
        $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
        $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
        $consultaSQL = "SELECT estudiantes.rutEstudiante, estudiantes.email, informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat, informefinal.IdInforme, case when informefinal.rutEstudiante is null then 0 else 1 end as flag, informefinal.calificacionSupervisor FROM estudiantes left JOIN informefinal on estudiantes.rutEstudiante= informefinal.rutEstudiante JOIN informacion WHERE estudiantes.rutSupervisor ='$rutTutor' and estudiantes.email = informacion.email";
        $array = $conexion->prepare($consultaSQL);
        $array->execute();

        foreach ($array as $alumnos){?>
        
        <tr>
            <td><center><?php echo $alumnos['rutEstudiante']?></center></td>
            <td><center><?php echo $alumnos['email'] ?></center></td>
            <td><center><?php echo $alumnos['Nombre'] ?></center></td>
            <td><center><?php echo $alumnos['ApellidoPat'] ?></center></td>
            <td><center><?php echo $alumnos['ApellidoMat'] ?></center></td>
            <td><center><a href="<?='bitacoraAlumno.php?rutEstudiante='.$alumnos['rutEstudiante'] ?>" style="text-decoration:none; color:black; font-weight:bold;"><i class="fa-solid fa-eye" style="color:black"></i>&nbspVer Bitacoras</a></center></td>
            
            <?php
            if($alumnos["calificacionSupervisor"] == 'A' || $alumnos["calificacionSupervisor"] == 'R'){
                ?>
                <form method="get">
                <td><a href="<?='../JefeCarrera/evaluar.php?Alumno='.$alumnos["IdInforme"]?>" style="text-decoration:none; color:black; font-weight:bold;">📒 Ya evaluado</a></td>
                <?php
            }
            elseif ($alumnos['flag'] === 1){
                ?>
                
                <form method="get">
                <td><a href="<?='../JefeCarrera/evaluar.php?Alumno='.$alumnos["IdInforme"]?>" style="text-decoration:none; color:black; font-weight:bold;">📒 Evaluar</a></td>
            </form>
            <?php 
            }else{
                echo "<td style='text-decoration:none; color:black; font-weight:bold;'><i class='fa-solid fa-circle-xmark' style='color:red;'></i>&nbspSin informe</td>";
            }
            ?>
            <td><a onclick="return confirm('Seguro que desea eliminar?');" href="<?='DesvincularAlumno.php?email='.$alumnos["email"]?>'" style="text-decoration:none; color:black; font-weight:bold;"><i class="fa-solid fa-trash" style="color:gray"></i>&nbspBorrar</a></td>
        </tr>
    <?php
    }?>
    </table>
</body>
</html>