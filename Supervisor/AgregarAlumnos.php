
<?php
session_start();
$Usuario = $_SESSION['Usuarios']['user'] . " ".$_SESSION['Usuarios']['ApellidoPat'];
$rutTutor = $_SESSION['Usuarios']['rut'];

$config = include '../config.php';
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);


if (isset($_POST['Enviar'])){
    try{
        $rut = strval($_POST['rut']);
        $consultaSQL = "UPDATE estudiantes SET rutSupervisor='$rutTutor' WHERE rutEstudiante ='$rut'";
        $array = $conexion->prepare($consultaSQL);
        $array->execute();
        ?>
        <script>
            alert("El alumno y usted se han asociado correctamente");
        </script>
        <?php
    }catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
}
?>
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/responder.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <title>Agregar Alumnos</title>
</head>
<body>
<form method="post">
    <div class="container-fluid mt-2">
            <div class="row">
                <div class="card mt-4" style="background-color:rgb(169,4,41); width:80%; margin:0 auto;">
                    <div class="functionsss text-center ">
                    <span><strong style="color:white; font-size:50px" >Ingrese el rut del alumno a supervisar</strong></span><br>
                        <div class="bgimgg mt-3 ">
                                <img src="../IMG/alumno.png" alt="adjunto" class="img-fluid mt-3" style="width:12%;"><br>

                        </div>
                        <div class="rut" style="display:flex; justify-content:center;align-items:center;">
                            <input type="text" name="rut" class="form-control text-center mt-3" style="width:auto;"placeholder="ingrese Rut sin punto ni guion" required><br>

                       </div>
                   
                       
                        <button type="submit" class="btn btn-success mt-3" style="width:30%" name="Enviar" > Enviar</button><br>
                        <button type="button" class="btn btn-warning btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#myModal" style="font-weight:bold;width:30%;">Ver alumnos sin supervisor</button><br>
                        <button type="button" class="btn btn-warning mt-3" style="width:30%" onclick="location.href='Supervisor.php'" >Volver atras</button>
                    </div>
                <br>
                </div>
            </div>
        </div>
</form>
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
        <div class="modal-body" >
            <?php
            $consultaSQL = "SELECT estudiantes.*, informacion.* FROM estudiantes inner join informacion WHERE estudiantes.rutSupervisor = 'NA' and estudiantes.email = informacion.email";
            $estudiantesSinSupervisor = $conexion->prepare($consultaSQL);
            $estudiantesSinSupervisor->execute();
            $estudiantesSinSupervisor = $estudiantesSinSupervisor->fetchAll();
            foreach($estudiantesSinSupervisor as $st){
                ?>
                <table class="table">
                    <tr>
                        <th class="text-center">nombre</th>
                        <th class="text-center">rut</th>
                        <th class="text-center">codigo Carrera</th>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo $st['Nombre'].' '.$st['ApellidoPat'].' '.$st['ApellidoMat'] ?></td>
                        <td class="text-center"><?php echo $st['rutEstudiante'] ?></td>
                        <td class="text-center"><?php echo $st['CodigoCarrera'] ?></td>
                    </tr>

                </table>
                <?php
            }
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



        
</body>
</html>