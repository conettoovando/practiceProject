<?php
session_start();
date_default_timezone_set("America/Santiago");
$config = include "../config.php";
$NombreAlumno = strval($_SESSION['Usuarios']["user"] . " " . $_SESSION['Usuarios']["ApellidoPat"]);
$rutAlumno = strval($_SESSION['Usuarios']['rut']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="../favicon/consulta.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Consulta_Al.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Consultas</title>
</head>
<?php
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$consultaSQL = "SELECT * FROM estudiantes WHERE rutEstudiante= '$rutAlumno'";
$array = $conect->prepare($consultaSQL);
$array->execute();
$array= $array->fetch();
$rutSupervisor = $array['rutSupervisor'];

if ($array['rutSupervisor'] == "NA"){
    echo "<h2>No tiene registrado ningun supervisor</h2>";
    echo "<h4>Por favor pongase en contacto con su supervisor solicitando agregarlo a su lista</h4>";
}else{
    if (isset($_POST['Cerrar'])){
        session_destroy();
        header('location: ../session.php');
    }
    if (isset($_POST['Atras'])){
        header('location: alumno.php');
    }
    if (isset($_POST['Enviar'])){
        $fecha = date("Y-m-d");
        $consulta = $_POST['TextConsulta'];
        $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
        $conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);

        $consultaSQL = "INSERT INTO consultas (descripcionconsulta, fecha, rutEstudiante) VALUES ('$consulta', '$fecha', '$rutAlumno' )";
        $array = $conect->prepare($consultaSQL);
        $array->execute();

        $consultaSQL = "SELECT MAX(idconsultas) as idconsultas FROM consultas WHERE rutEstudiante = '$rutAlumno'";
        $Consulta = $conect->prepare($consultaSQL);
        $Consulta->execute();
        $Consulta = $Consulta->fetch();
        $idConsulta = $Consulta['idconsultas'];

        $consultaSQL = "INSERT INTO respuestas (descripcionrespuestas, fecha, idConsulta) VALUES ('-', '-', '$idConsulta' )";
        $array = $conect->prepare($consultaSQL);
        $array->execute();
        echo "<script type='text/javascript'>alert('Consulta enviada con exito'); window.location='consultasAlumno.php'</script>";
    }
    ?>
    <body>
        <div class="d-flex align-items-center justify-content-around text-center pumcon mt-3">
            <h1>Consultas al Docente Supervisor</h1>
        </div>
        <div class="d-flex align-items-center justify-content-around text-center conoc mt-5">
            <div class="d-flex flex-column justify-content-center">
                <h1 style="font-weight:bold;" >Menu</h1><br>
                <form method="post">
                    <input type="submit" value="Cerrar Sesión" name = "Cerrar" class="btn btn-danger btn-lg" style="font-weight:bold; width:100%;" ><br><br>
                    <button type="submit" value="Atras" name = "Atras" class="btn btn-warning btn-lg" style="font-weight:bold; width:100%;"onclick="location.href='alumno.php'" >Atrás</button><br><br>
                    <button type="button"class="btn btn-secondary btn-lg" onclick="location.href='misConsultasAlumno.php'" style="font-weight:bold; width:100%;" >Mis Consultas</button><br><br>
                </form>
            </div>
            <div class="consus mt-4">
                <?php
                $consultaSQL = "SELECT supervisor.email, informacion.* FROM supervisor inner join informacion WHERE supervisor.RutSupervisor = '$rutSupervisor' and informacion.email = supervisor.email";
                $array = $conect->prepare($consultaSQL);
                $array->execute();
                $array= $array->fetch();
                ?>
                <h4><?=$array['Nombre'].' '.$array['ApellidoPat'].' '.$array['ApellidoMat'] ?></h4>
                <h4 style="color:black;">Escribe tu consulta acá!: </h4><br>
                <form method="post">
                <!--CAMBIAR BITS A 100 EN BASE DE DATOS-->
                    <textarea name="TextConsulta" class="form-control" id="TextConsulta" cols="80" rows="10" style="resize:none" placeholder="Escribe aqui tu consulta..." maxlength="100"  required></textarea>
                    <div id="contador" class="mt-2">0/100</div>
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
                <input type="submit" value="Enviar" class="btn btn-success btn-lg " style="width:50%; font-weight:bold;" name = "Enviar">
                </form>
            </div>
        </div>
    </body>
    </html>
<?php } ?>
