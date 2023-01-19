<?php
session_start();
$Usuario = $_SESSION['Usuarios']['user'] . " ".$_SESSION['Usuarios']['ApellidoPat'];

if (isset($_POST['Volver']) || isset($_POST['EnviarNuevaConsulta'])){
    header("location:consultasAlumno.php");
}
if (isset($_POST['cerrarSession'])){
    session_destroy();
    header('location: ../session.php');
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Consultas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/Consulta_All.css">
</head>
<body>
    <div>
        
    </div>
        
    <?php
    $rutAlumno = $_SESSION['Usuarios']['rut'];
    $config = include '../config.php';
    $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
    $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
    $consultaSQL = "SELECT * FROM consultas WHERE RutEstudiante= '$rutAlumno' ";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();
    ?>

<!--<?php /*
                                $idConsulta = $_GET['id'];
                                $consultaSQL = "SELECT * FROM respuestas WHERE idConsulta= '$idConsulta' ";
                                $array = $conexion->prepare($consultaSQL);
                                $array->execute();
                                $array = $array->fetch();
                                if ($array['descripcionrespuestas'] == "-"){
                                    echo "<h2>Consulta aun no ha sido respondida</h2>";
                                }else{
                                    echo $array['descripcionrespuestas'];
                                    echo "<br>";   
                                    echo $array['fecha'];
                                }
                                ?>

*/?>-->


    <div class="d-flex align-items-center justify-content-center text-center pumconn mt-5">
        <h2 id="bienvenida" style="font-size:15px;" class="m-4";>Bienvenido <?php echo " ".$Usuario?></h2><br><br>   
        <h2>Consultas al Docente Supervisor</h2>
        </div>
        <div class="d-flex align-items-center justify-content-around text-center conocc mt-4">
            <div class="d-flex flex-column justify-content-center text-center">
                <h1 style="font-weight:bold;" class="text-center menu" >Menu</h1><br>
                <form method="post">
                    
                    <input type="submit" name="EnviarNuevaConsulta" class="mt-4 btn btn-success btn-lg butto" style="font-weight:bold;font-size:15px;height:60px;width:100%" value="Enviar Nueva Consulta">
                    <input type="submit" value="Volver Atras" name="Volver" class="btn btn-warning btn-lg mt-4 butto" style="font-weight:bold;font-size:15px; height:60px;width:100%;"><br>
                    <input type="submit" value="Cerrar Sesíon" name="cerrarSession" class="btn btn-danger btn-lg mt-4 butto" style="font-weight:bold;font-size:15px;  height:60px;width:100%;"><br> 
                    
                </form>
                
            </div>

       

            <div class="consus mt-2">
                <form method="post">
                    <div class="row">
                        <div class="col-xs-10">
                        <h1 style="font-weight:bold;" class="text-center" >Mis Consultas</h1><br>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Consulta</th>
                                    <th>Fecha</th>
                                    <th>Respuesta</th>
                                </tr>
                                </thead>
                                <?php            
                                
                                foreach ($array as $alumnos){
                                    $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
                                    $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
                                    $consultaSQL = "SELECT * FROM respuestas WHERE idConsulta= '$alumnos[idconsultas]' ";
                                    $respuesta = $conexion->prepare($consultaSQL);
                                    $respuesta->execute();
                                    $respuesta = $respuesta->fetch();
                                ?>
                                
                                    <tr>
                                        <td><?php echo $alumnos['descripcionconsulta'] ?></td>
                                        <td><?php echo $alumnos['fecha'] ?></td>
                                        <td> 
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editaModal" id="sendModal" data-bs-id="<?= $respuesta['descripcionrespuestas'] ?>"><i class="fa-solid fa-eye"  ></i> &nbspVer respuesta</button>
                                        </td>
                                    </tr>
                                <?php
                                }?>  
                            </table> 
                        </div>  
                    </div> 
                </form>
            </div>
        </div>             
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <?php
                    if ($respuesta['descripcionrespuestas'] == "-" || $respuesta['descripcionrespuestas'] == ''){
                        echo "<h2>Consulta aun no ha sido respondida</h2>";
                    }else{
                        echo $respuesta['descripcionrespuestas'];
                        echo "<br>";   
                        echo $respuesta['fecha'];
                    }
                    ?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
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

</body>
</html>