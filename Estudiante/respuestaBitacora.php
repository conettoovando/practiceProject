<?php
$config = include '../config.php';
session_start();
$rutEstudiante = $_SESSION['Usuarios']['rut'];

# Get Information Student
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$consultaSQL = "SELECT * from estudiantes WHERE rutEstudiante = '$rutEstudiante'";
$array = $conexion->prepare($consultaSQL);
$array->execute();
$datosAlumno = $array->fetch(PDO::FETCH_ASSOC);

$consultaSQL = "SELECT informacion.*, bitacora.* from informacion, bitacora where informacion.email = '$datosAlumno[email]' and bitacora.rutEstudiante = '$datosAlumno[rutEstudiante]'";
$array = $conexion->prepare($consultaSQL);
$array->execute();
$newData = $array->fetch(PDO::FETCH_ASSOC);

if ($newData == null){
    $query = "SELECT * from informacion where email = '$datosAlumno[email]'";
    $array = $conexion->prepare($query);
    $array->execute();
    $newData = $array->fetch(PDO::FETCH_ASSOC);
    $datosAlumno+=$newData;
    ?>
    <h1>El alumno <?php echo $datosAlumno['Nombre']. ' '.$datosAlumno['ApellidoPat'] ?> no cuenta con bitacoras</h1>

<?php
}else{
    $datosAlumno+=$newData;    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bitacoraaa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <script src="../js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Bitcaroas Alumno</title>
</head>
<body>

    <?php 
    $consultaSQL = "SELECT bitacora.* from bitacora where rutEstudiante = '$datosAlumno[rutEstudiante]' ORDER BY fechaBitacora DESC";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();

    $consultaSQL = "SELECT COUNT(idBitacora) from bitacora where rutEstudiante = '$datosAlumno[rutEstudiante]'";
    $count = $conexion->prepare($consultaSQL);
    $count->execute();
    $cont = $count->fetch();
    ?>

    

    <div class="d-flex align-items-center justify-content-around text-center conoc mt-4">
        <div class="boton">
            <div class="botonn">
                <button class="btn btn-warning btn-lg" style="font-weight:bold;"  onclick="location.href='alumno.php'">Volver atrás</button>
            </div>
            
        </div>
        
                                                    
        <div class="bgimg">
            <img src="../IMG/ayudar.png" alt="fotoayuda" class="img-fluid imggg">
        </div>
        
        <div class="d-flex flex-column justify-content-center">
            
            <div class="consus mt-1 " style="width:100%">
            <?php
            $consultaSQL = "SELECT estudiantes.rutSupervisor, supervisor.email, informacion.* FROM estudiantes INNER JOIN supervisor INNER JOIN informacion WHERE estudiantes.rutEstudiante = '$datosAlumno[rutEstudiante]' AND supervisor.RutSupervisor = estudiantes.rutSupervisor and informacion.email = supervisor.email";
            $informacionSupervisor = $conexion->prepare($consultaSQL);
            $informacionSupervisor -> execute();
            $informacionSupervisor = $informacionSupervisor->fetch();
            ?>
            <h1 class="text-justify mb-5">
            Docente: <?php echo $informacionSupervisor['Nombre'].' '.$informacionSupervisor['ApellidoPat'] ?></h1> 
                <form method="post">
                        
                        <table class="table">
                            <tr>
                                <th>N° Semana</th>
                                <th>Fechas</th>
                                <th>Acción</th>
                                <th>Estado</th>
                            </tr>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <?php
    
    $SemanasEnTabla = [];
    $SemanasEnTablaCopy= [];
    foreach ($array as $rd){
        $date = $rd['fechaBitacora'];
        $date = new DateTime($date);
        $year = $date -> format('Y');
        $month = $date -> format('m');
        $day = $date -> format('d');

        $semana = date("W", mktime(0,0,0,$month,$day,$year));
        if (!in_array($semana, $SemanasEnTablaCopy)){
            $SemanasEnTablaCopy[] = $semana;
        }
    }
    $consultaSQL = "SELECT bitacora.* from bitacora where rutEstudiante = '$datosAlumno[rutEstudiante]' ORDER BY fechaBitacora DESC";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();

    $maxcont = sizeof($SemanasEnTablaCopy) + 1;
   
    foreach ($array as $rd){
        $date = $rd['fechaBitacora'];
        $date = new DateTime($date);
        $year = $date -> format('Y');
        $month = $date -> format('m');
        $day = $date -> format('d');

        $semana = date("W", mktime(0,0,0,$month,$day,$year));
        $diaSemana = date('w', mktime(0,0,0,$month,$day, $year));

        if ($diaSemana == 0){
            $diaSemana=7;
        }
        $primerDia = date('d-m-Y',mktime(0,0,0, $month,$day-$diaSemana+1, $year));
        $ultimoDia=date("d-m-Y",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
        if (!in_array($semana, $SemanasEnTabla)){
            $SemanasEnTabla[] = $semana;
            $maxcont-=1;
        $dias = array(
            'primerDia' => $primerDia,
            'ultimoDia' => $ultimoDia,
        );
        $dias = serialize($dias);
        $dias = urlencode($dias);
        ?>
        <tr>
            <td><center><?php echo $maxcont ?></center></td>
            <td><center><?php echo $primerDia.' - '. $ultimoDia ?></center></td>
            <td>
                <center><a href="#" data-bs-toggle="modal" data-bs-target="#editaModal" style="font-weight:bold;" data-bs-id="<?= $rd['respuestaBitacora']; ?>">Ver Respuesta</a></center></td>
            <td><center>
                <?php
                if ($rd['respuestaBitacora'] != 'Sin Respuesta' && $rd['respuestaBitacora'] != ''){
                    echo '<i class="fa-solid fa-circle-check lax text-center fa-lg" style="color:green;"></i>';
                }else{
                    echo '<i class="fa-solid fa-circle-xmark lax text-center fa-lg" style="color:red;"></i>';
                }
                ?>
            </center></td>
    </tr>
                        <?php
                            }
                        
                        }
                    }

        ?>
            </form>
        </div>
      
    </div> 
</table>

<?php
include "respuestaModal.php";
?>
<script>
    let editaModal = document.getElementById('editaModal')

    editaModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        console.log(id)
        let inputId = editaModal.querySelector('.modal-body #id')
        let inputRespuesta = editaModal.querySelector('.modal-body #respuesta')

        document.getElementById('id').innerHTML = id;
    })
    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>  


</body>
</html>
