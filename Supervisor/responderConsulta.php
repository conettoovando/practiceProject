<?php
session_start();
$config = include "../config.php";
$idConsulta = $_GET["Alumno"];
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$consultaSQL = "SELECT * FROM consultas WHERE idconsultas='$idConsulta'";
$array = $conexion->prepare($consultaSQL);
$array->execute();
$array = $array->fetch();
$RutAlumno = $array['rutEstudiante'];
$DudaAlumno = $array['descripcionconsulta'];
date_default_timezone_set("America/Santiago");
$fechaActual = date("Y-m-d");


if (isset($_POST['Volver'])){
    header("location:ConsultasSupervisor.php");
}
if(isset($_POST['CerrarSession'])){
    session_destroy();
    header('location: session.php');
}
if(isset($_POST['Enviar'])){
    $texto=$_POST['TextRespuesta'];
    $consultaSQL = "UPDATE respuestas SET descripcionrespuestas='$texto', fecha='$fechaActual' WHERE idConsulta='$idConsulta'";
    $array = $conexion->prepare($consultaSQL);
    $array->execute();
    header("location: ConsultasSupervisor.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/agregar.css">
    <link rel="stylesheet" href="../css/Consulta_Al.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Responder Consulta</title>
</head>
<body>
    <div class="d-flex align-items-center justify-content-around text-center pumcon mt-3">
        <h1>Consultas</h1>
    </div>
    <div class="d-flex align-items-center justify-content-around text-center conoc mt-5">
        <div class="d-flex flex-column justify-content-center">
            <form method="post">
                <p><span> <?php echo "La duda es: <br>".$DudaAlumno?></span></p>
                <p>Respuesta a: <?php echo " ".$RutAlumno?></p>
                    
                <div class="bgimg">
                    <img src="../IMG/ayudar.png" alt="fotoayuda" class="img-fluid imggg">
                </div>
                    
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
                </script>
                <button type="button" class="btn btn-danger btn-lg mr-4"  onclick="location.href='Supervisor.php'" >Volver atras</button>
                <input type="submit" value="Enviar" class="btn btn-success btn-lg pl-4 " style="width:50%; font-weight:bold;" name = "Enviar">
            </form>
                
        </div>
    </div>

  






</body>
</html>