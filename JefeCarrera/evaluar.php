<?php
session_start();
$rutJefeCarrera = $_SESSION['Usuarios']['rut'];
$config = include '../config.php';
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$idAlumno = $_GET['Alumno'];
$consultaSQL = "SELECT * FROM informefinal WHERE IdInforme='$idAlumno'";
$array = $conect->prepare($consultaSQL);
$array->execute();
$resultado= $array->fetch();

$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$consultaSQL = "SELECT informefinal.IdInforme,informefinal.rutJefeCarrera, informefinal.calificacionFinal, informefinal.ruta, informefinal.Size, estudiantes.*, informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat FROM informefinal INNER JOIN estudiantes on informefinal.rutEstudiante = estudiantes.rutEstudiante INNER JOIN informacion on estudiantes.email = informacion.email WHERE informefinal.IdInforme = '$idAlumno'";
$ConsultaInforme = $conexion->prepare($consultaSQL);
$ConsultaInforme->execute();
$ConsultaInforme = $ConsultaInforme ->fetch();
$nombreAlumno = $ConsultaInforme['Nombre']." ".$ConsultaInforme['ApellidoPat']." ".$ConsultaInforme['ApellidoMat'];

$rutAlumno = $resultado['rutEstudiante'];
$consultaSQL = "SELECT COUNT(*) as totalBitacora from bitacora WHERE bitacora.rutEstudiante = '$rutAlumno'";
$totalBitacoras = $conexion->prepare($consultaSQL);
$totalBitacoras -> execute();
$totalBitacoras = $totalBitacoras -> fetch();

if (isset($_POST['cerrar'])){ //Cerrar sesión
    session_destroy();
    header('location: ../session.php');
}

if(isset($_POST['Enviar'])){
    $calificacion = $_POST['calificacion'];
    $observacion = $_POST['Observaciones'];
    $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
    $conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);

    if ($_SESSION['Usuarios']['rol'] == '3'){
        $consultaSQL = "UPDATE informefinal set calificacionSupervisor = '$calificacion', ObservacionSupervisor = '$observacion' WHERE IdInforme='$idAlumno'";
    }
    if ($_SESSION['Usuarios']['rol'] == '4'){
        $consultaSQL = "UPDATE informefinal set calificacionJefeCarrera = '$calificacion', ObservacionJefeCarrera = '$observacion' WHERE IdInforme='$idAlumno'";
    }
    $array = $conect->prepare($consultaSQL);
    $array->execute();

    $consultaSQL = "SELECT * FROM informefinal WHERE IdInforme = '$idAlumno'";
    $calificacionFinal = $conect->prepare($consultaSQL);
    $calificacionFinal->execute();
    $calificacionFinal = $calificacionFinal->fetch();

    if ($calificacionFinal['calificacionSupervisor'] == 'A' && $calificacionFinal['calificacionJefeCarrera'] == 'A'){
        $consultaSQL = "UPDATE informefinal set calificacionFinal = 'A' WHERE IdInforme='$idAlumno'";
        $array = $conect->prepare($consultaSQL);
        $array->execute();
    }elseif($calificacionFinal['calificacionSupervisor'] == 'R' || $calificacionFinal['calificacionJefeCarrera'] == 'R'){
        $consultaSQL = "UPDATE informefinal set calificacionFinal = 'R' WHERE IdInforme='$idAlumno'";
        $array = $conect->prepare($consultaSQL);
        $array->execute();
    }

    if ($_SESSION['Usuarios']['rol'] == '3'){
        header("location: ../Supervisor/supervisor.php");
    }elseif($_SESSION['Usuarios']['rol'] == '4'){
        header("location: jefecarrera.php");
    }else{
        header("location: ../session.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/evaluar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="../java/checkbox.js"></script>
    
    <title>Evaluacion<?php echo " ".$nombreAlumno; ?></title>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center text-center pumconn mt-5">
        <h2>Revision Informes</h2>
    </div>


    <div class="d-flex align-items-center justify-content-around text-center conocc mt-4">
            <div class="d-flex flex-column justify-content-center text-center">
                <h1 style="font-weight:bold;" class="text-center menu" >Menu</h1>
                <?php 
                if ($_SESSION['Usuarios']['rol'] == '3'){
                    $rutaVolver = "../Supervisor/supervisor.php";
                }elseif ($_SESSION['Usuarios']['rol'] == '4'){
                    $rutaVolver = "jefecarrera.php";
                }else{
                    $rutaVolver = "session.php";
                }
                ?>
                <a href="<?=$ConsultaInforme['ruta'] ?>" name = 'Volver' class="btn btn-warning btn-lg mt-2 butto" style="font-weight:bold;font-size:15px; height:60px;width:100%;">Descargar Informe</a>
                <input type="button" value="Volver" name = 'volver' class="btn btn-warning btn-lg mt-4 butto" style="font-weight:bold;font-size:15px; height:60px;width:100%;" onclick="location.href='<?=$rutaVolver?>'">
                <form method="post">              
                    <input type="submit" value="Cerrar Sesíon" name="cerrar" class="btn btn-danger btn-lg mt-4  butto" style="font-weight:bold;font-size:15px;  height:60px;width:100%;"><br> 
                </form>
            </div>
            

            <div class="consus mt-3">
                <form method="post">
                    <div class="row">
                        <div class="col-xs-10">
                            <form method="post">     
                                <div>
                                    <h3>Alumno: <?php echo " ".$nombreAlumno ?> </h3>
                                    
                                    <div class="form-check mt-4" onchange="studCheck()">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" name="check1" id="check1" value="1" required>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Formato acorde al reglamento
                                        </label>
                                    </div>
                                    <div class="form-check mt-4" onchange="studCheck()">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="check2" id="check2" value="2" required>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Minimo de 50 bitacoras enviadas (Total actual: <?php echo $totalBitacoras['totalBitacora'] ?>)
                                        </label>
                                    </div>
                                    <div class="form-check mt-4" onchange="studCheck()">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" name="check[]" id="check3" value="3">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Informe sin faltas ortográficas
                                        </label>
                                    </div>
                                    <div class="form-check mt-4" onchange="studCheck()">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" name="check[]" id="check4" value="4" required>
                                        <label class="form-check-label" for="flexCheckDefault3">
                                            El alumno completó el periodo de 360 horas
                                        </label>
                                    </div>
                                    <div class="form-check mt-4" onchange="studCheck()">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" name="check[]" id="check5" value="5">
                                        <label class="form-check-label" for="flexCheckDefault4">
                                            El alumno adjunta evidencia <br>de su trabajo realizado dentro de el informe final
                                        </label>
                                    </div>
                                    <div class="mt-4" onchange="studCheck()">
                                        <textarea class="form-control" style="resize:none;" name="Observaciones" id="Observaciones" cols="30" rows="10" placeholder="Observaciones..." required></textarea>
                                        <select class="form-control mt-4" name="calificacion" id="inputselect" required>
                                            <option value="" selected disabled hidden>Calificacion</option>
                                            <option value="A" id='requi' style="display: none;">Aprobado</option>
                                            <option value="R">Reprobado</option>
                                            <option value="P">Pendiente</option>
                                        </select>
                                    </div>
                                </div>
                            <input class="mt-4 mb-4 btn btn-success btn-lg" style="font-weight:bold;"type="submit" value="Enviar" name = "Enviar">
                        </form>
                        </div>  
                    </div> 
                </form>
            </div>
        </div>
                            
</div>



























    
    
</body>
</html>