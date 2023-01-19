<?php
date_default_timezone_set("America/Santiago");
session_start();
$config = include "../config.php";

if (isset($_GET['Semana'])){
    $rutEstudiante = $_GET['rut'];
    $dias = unserialize($_GET['Semana']);
    $primerDia = date('Y-m-d', strtotime($dias['primerDia']));
    $utlimoDia =  date('Y-m-d', strtotime($dias['ultimoDia']));
    $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
    $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
    $consultaSQL = "SELECT * from bitacora where fechaBitacora >= '$primerDia' and fechaBitacora <= '$utlimoDia'";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();
    $datosAlumno = $array->fetchAll();
    $consultaSQL = "SELECT * from estudiantes inner join informacion where estudiantes.rutEstudiante = '$rutEstudiante' and informacion.email = estudiantes.email";
    $informacionAlumno = $conexion->prepare($consultaSQL);
    $informacionAlumno -> execute();
    $informacionAlumno = $informacionAlumno->fetch(PDO::FETCH_ASSOC);
  
}
if (isset($_POST["enviar"])){
    $respuesta = $_POST['TextRespuesta'];
    foreach ($datosAlumno as $dt){
        $fecha = $dt['fechaBitacora'];
        $query = "UPDATE bitacora SET respuestaBitacora = '$respuesta' where rutEstudiante = '$rutEstudiante' and fechaBitacora = '$fecha'";
        $query = $conexion->prepare($query);
        $query -> execute();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/evaluarb.css">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Evaluar Bitacoras</title>
</head>
<body>

    <div class="d-flex  col-3 align-items-center container-fluid text-wrap justify-content-around text-center pumcon mt-3">
        <h1 class="text-center tit" style="font-size:25px;" >Evaluación de Bitacoras</h1>
        
    </div>
    <div class="d-flex align-items-center justify-content-around text-center conoc mt-5">
        <div class="d-flex flex-column justify-content-center">
            
  
            <form method="post">
                <table class="table">
                    <tr>
                        <th>fecha</th>
                        <th>descripcion</th>
                        <th>Accion</th>
                    </tr>
                    <h3 class="h3nom mt-4" >Nombre Alumno: <?php echo $informacionAlumno['Nombre'] .' '. $informacionAlumno['ApellidoPat'] ?></h3>
        
                    
                    <?php
                    
                    foreach ($datosAlumno as $dt){
                        $arr = $dt['fechaBitacora'];
                        ?>
                        <tr class="">
                            <td><center><?php echo $dt['fechaBitacora']; ?></center></td>
                            <td><center><?php echo $dt['descripcionBitacora']; ?></center></td>
                            <td><center><a href="<?='$dt[ruta];'?>">Descargar Contenido</a></center></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

                </form>
            </div>
            <div class="consus mt-4">
                <h4 style="color:black;">Escribe tu Respuesta acá!: </h4><br>
                <form method="post">
                    <!--CAMBIAR BITS A 100 EN BASE DE DATOS-->
                    <textarea  name="TextRespuesta" class="form-control" id="TextConsulta" cols="80" rows="10" style="resize:none" placeholder="Escribe aqui tu respuesta..." maxlength="255"  required></textarea>
                    <div id="contador" class="mt-2">0/255</div>
                    <script>
                        const mensaje = document.getElementById('TextConsulta');
                        const contador = document.getElementById('contador');
                        mensaje.addEventListener('input', function(e) {
                            const target = e.target;
                            const longitudMax = target.getAttribute('maxlength');
                            const longitudAct = target.value.length;
                            contador.innerHTML = `${longitudAct}/${longitudMax}`;
                        });

                        
                        function volver(){
                            return location.href = 'bitacoraAlumno.php?rutEstudiante=<?php echo $rutEstudiante ?>';
                        }

                    </script>
                    <button type="button" class="btn btn-danger btn-lg mr-4"  style="font-weight:bold;" onclick='volver()' >Volver atras</button>
                    <input type="submit" value="Enviar" class="btn btn-success btn-lg pl-4" style="width:25%; font-weight:bold;" name = "enviar">
                      <?php
                    if ($datosAlumno[0]['respuestaBitacora'] != 'Sin Respuesta' && $datosAlumno[0]['respuestaBitacora'] != ''){
                    ?>
                    <br>
                    </form>
   
                    <button type="button" class="btn btn-warning btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#myModal" style="font-weight:bold;">Ver Respuesta</button>
                    <!-- Button to Open the Modal -->
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Respuesta enviada</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <?php
                                
                                echo "Tu respuesta es: \n ";?><br><?php
                                echo $datosAlumno[0]['respuestaBitacora'];
                                ?>
                                <!--GET A LA RESPUESTA ENVIADA-->
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>

                            </div>
                        </div>
                    </div>
                    <form method="post">
                    <script>
                        $(document).ready(function() {
                            alert ("LAS BITACORAS DE ESTA SEMANA YA HAN SIDO EVALUADAS \nLos cambios a esta retroalimentacion remplazará los datos enviados previamente."); 
                        });
                    </script>
                    <?php
                    }?>
        
                    
            </form>
                
        </div>
    </div>




































</body>
</html>