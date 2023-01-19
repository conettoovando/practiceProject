<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice-Alumno</title>
    <link rel="icon" href="../favicon/empleados.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <nav class="mt-4">
    <link rel="stylesheet" href="../css/cerrar.css">
    <a href="https://facultades.unab.cl/ingenieria/">
    <div class="bloque">
        <IMG class="Imagen" SRC="../favicon/unab.png" width="150" height="60" >
    </div>
    </a>
    <a href="https://www.facebook.com/unab.cl">
        <div class="bloque">
        <IMG class="Imagen" SRC="../favicon/facebook.png" width="40" height="30" >
    </div>
    </a>
    <a href="https://twitter.com/uandresbello">
        <div class="bloque">
        <IMG class="Imagen twit" SRC="../favicon/Twitter.png" width="40" height="30" >
    </div>
    </a>
 
            

    </nav>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<br>
<br>
<br>
<body style="margin: 10px; background-color: black;">
<?php
session_start();
require "../conexion.php";
$config = include '../config.php';

$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
date_default_timezone_set("America/Santiago");
$fechaActual = date("Y-m-d");
$rutEstudiante = $_SESSION['Usuarios']['rut'];

$query = "SELECT rutSupervisor FROM estudiantes WHERE rutEstudiante = '$rutEstudiante'";
$rutSupervisor = mysqli_query($conexion,$query);
$rutSupervisor = mysqli_fetch_array($rutSupervisor);
$rutSupervisor = $rutSupervisor['rutSupervisor'];
?>
<?php
require '../conexion.php';
$query = "SELECT COUNT(IdInforme) from (informefinal) where rutEstudiante = '$rutEstudiante'";
$consulta = mysqli_query($conexion, $query);
$array = mysqli_fetch_array($consulta);
if ($array[0] != 0){
    header('location: finalpractica.php');
}
?>

    <div class="-body">
        <div class="botones-izquierda">
            <div class="Titulo-menu"> 
                <h1>MENU</h1>
            </div>
            <div class="cuadroboton"> 
            <button type="button" class="btn btn-warning btn-lg" style="font-weight:bold" onclick="window.open('../EJEMS/Reglamento.pdf');window.location.href = 'alumno.php'">Reglamento<br>Practica Profesional </button>
            </div>
            <div class="cuadroboton">
            <button type="button" class="btn btn-warning btn-lg" style="font-weight:bold" onclick="window.open('../EJEMS/Ejemplo.pdf');window.location.href = 'alumno.php'">Formato <br> informe</button>
            </div>
            <div class="cuadroboton">
            <?php
            echo "
            <script type=text/javascript>
            function misbitacoras(){
                if ('$rutSupervisor' == 'NA'){
                    window.alert('No tiene supervisor asignado');
                }else{
                    window.location.href = 'misbitacoras.php';
                }
            }
            </script>
            ";
            ?>
            <button type="button" class="btn btn-secondary btn-lg"  style="font-weight:bold" onclick="misbitacoras()">Mis bitacoras</button>
            </div>
            <div class="cuadroboton">
            <?php
            echo "
            <script type=text/javascript>
            function respuestasBitacoras(){
                if ('$rutSupervisor' == 'NA'){
                    window.alert('No tiene supervisor asignado');
                }else{
                    window.location.href = 'respuestaBitacora.php';
                }
            }
            </script>
            ";
            ?>
            <button type="button" class="btn btn-secondary btn-lg"  style="font-weight:bold" onclick="respuestasBitacoras()">Mis Respuestas</button>
            </div>
            <div class="cuadroboton"> 
            <button type="button" class="btn btn-secondary btn-lg"   style="font-weight:bold" onclick="location.href='consultasAlumno.php'">Mis Consultas</button>
            </div>
            <div class="cuadroboton"> 
            <button type="button" class="btn btn-success btn-lg mb-4" style="font-weight:bold" onclick="location.href='finalpractica.php'">Finalizar <br> Practica Profesional</button>
            </div>
         
        </div>       
        <?php
        if (isset($_SESSION['Usuarios']['mail'])){ //bienvenida al usuario logueado
            $usuario = $_SESSION['Usuarios']['user'];
            $rol = $_SESSION['Usuarios']['rol'];
            $mail = $_SESSION['Usuarios']['mail'];
            
            
            $query = "SELECT rutEstudiante from estudiantes WHERE email ='$mail'";
            $consulta=mysqli_query($conexion,$query);
            $rutEstudiante=mysqli_fetch_array($consulta); 
            $_SESSION['Usuarios']['rut'] = $rutEstudiante['rutEstudiante'];
            $rut = $_SESSION['Usuarios']['rut'];
            if ($rol == '1'){
                header('location: index.php');
                die();
            }
            if ($rol == '2'){
                $rolito = "Usuario";
            }
        }else{
            header('location: ../session.php');
        }
     
        if (isset($_POST['enviar'])){
            $fecha  = $_POST['fecha'];
            if(is_uploaded_file($_FILES['fichero']['tmp_name'])){
                if(file_exists("../upload/".$mail) == false){
                    mkdir("../upload/".$mail);
                }
                if(file_exists("../upload/".$mail."/".$_POST['fecha']) == false){
                    mkdir("../upload/".$mail."/".$_POST['fecha']);
                }else{
                    $archivos = scandir("../upload/".$mail."/".$_POST['fecha']);
                    foreach ($archivos as $delete){
                        if ($delete == '.' || $delete == '..'){
                            continue;
                        }else{
                            unlink("../upload/".$mail."/".$_POST['fecha'].'/'.$delete);
                        }
                    }
                }
                $filetxt = fopen("../upload/".$mail."/".$_POST['fecha']."/bitacora.txt" , "w");
                $txt = $_POST['textobitacora'];
                fwrite($filetxt,$txt);
                fclose($filetxt);
                $ruta = "../upload/".$mail."/".$_POST['fecha']."/".$_FILES['fichero']['name'];
                $nombre = $_FILES['fichero']['name'];
                $size = $_FILES['fichero']['size'];
                $fecha  = $_POST['fecha'];
                $bitacora = $_POST['textobitacora'];
               

                if (move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta)){
                    $query = "SELECT EXISTS (SELECT * FROM bitacora WHERE fechaBitacora = '$fecha' and rutEstudiante = '$rut')";
                    $comprobarRuta = $conect->prepare($query);
                    $comprobarRuta->execute();
                    $comprobarRuta = $comprobarRuta->fetch();
                    
                    if ($comprobarRuta[0] == "1"){
                        $query = "UPDATE bitacora SET descripcionBitacora = '$bitacora',fechaCreacion = '$fechaActual',ruta ='$ruta',Size = '$size',respuestaBitacora = 'Sin Respuesta',fechaBitacora = '$fecha',rutEstudiante = '$rut' WHERE fechaBitacora = '$fecha' and rutEstudiante = '$rut'";
                    }else{
                        $query = "INSERT INTO bitacora (descripcionBitacora,fechaCreacion,ruta,Size,respuestaBitacora,fechaBitacora,rutEstudiante) VALUES ('$bitacora','$fechaActual','$ruta','$size' ,'Sin Respuesta','$fecha','$rut')";
                        
                    }
                    $sentencia = $conect->prepare($query);
                    $sentencia->execute();
                    ?>
    
                    <?php                   
                }
            }else{
                $query = "SELECT EXISTS (SELECT * FROM bitacora WHERE fechaBitacora = '$fecha' and rutEstudiante = '$rut')";
                $comprobarRuta = $conect->prepare($query);
                $comprobarRuta->execute();
                $comprobarRuta = $comprobarRuta->fetch();
                print_r($comprobarRuta[0]);
                if ($comprobarRuta[0] == "1"){
                    echo "el if papito";
                    if(file_exists("../upload/".$mail) == false){
                        mkdir("../upload/".$mail);  
                    }
                    if(file_exists("../upload/".$mail."/".$_POST['fecha']) == false){
                        mkdir("../upload/".$mail."/".$_POST['fecha']);
                    }else{
                        $archivos = scandir("../upload/".$mail."/".$_POST['fecha'].'/');
                        foreach ($archivos as $delete){
                            if ($delete == '.' || $delete == '..'){
                                continue;
                            }else{
                                unlink("../upload/".$mail."/".$_POST['fecha'].'/'.$delete);
                            }
                        }
                    }
                    $fecha  = $_POST['fecha'];
                    $bitacora = $_POST['textobitacora'];
                    $txt = $_POST['textobitacora'];
                    
                    $query = "UPDATE bitacora SET descripcionBitacora = '$bitacora',fechaCreacion = '$fechaActual',ruta ='Sin Archivo',Size = 'Sin Archivo',respuestaBitacora = 'Sin Respuesta',fechaBitacora = '$fecha',rutEstudiante = '$rut' WHERE fechaBitacora = '$fecha' and rutEstudiante = '$rut'";
                    $sentencia = $conect->prepare($query);
                    $sentencia->execute();

                    $filetxt = fopen("../upload/".$mail."/".$_POST['fecha']."/bitacora.txt" , "w");
                    $txt = $_POST['textobitacora'];
                    fwrite($filetxt,$txt);
                    fclose($filetxt);
                }else{
                    echo "Entre en el elseeee";
                    if(file_exists("../upload/".$mail) == false){
                        mkdir("../upload/".$mail);  
                    }
                    if(file_exists("../upload/".$mail."/".$_POST['fecha']) == false){
                        mkdir("../upload/".$mail."/".$_POST['fecha']);
                    }else{
                        $archivos = scandir("../upload/".$mail."/".$_POST['fecha']);
                        foreach ($archivos as $delete){
                            unlink("../upload/".$mail."/".$_POST['fecha'].'/'.$delete);
                        }
                    }
                    $fecha  = $_POST['fecha'];
                    $bitacora = $_POST['textobitacora'];
                    $txt = $_POST['textobitacora'];
                    
                    $query = "INSERT INTO bitacora (descripcionBitacora,fechaCreacion,ruta,Size,respuestaBitacora,fechaBitacora,rutEstudiante) VALUES ('$bitacora','$fechaActual','Sin Archivo','Sin Archivo' ,'Sin Respuesta','$fecha','$rut')";
                    $sentencia = $conect->prepare($query);
                    $sentencia->execute();

                    $filetxt = fopen("../upload/".$mail."/".$_POST['fecha']."/bitacora.txt" , "w");
                    $txt = $_POST['textobitacora'];
                    fwrite($filetxt,$txt);
                    fclose($filetxt);
                }
                header('location:alumno.php'); 
            }
            
        }

        if (isset($_POST['cerrar'])){
            header('location: ../session.php');
        }
        ?>
        <div class="contenido">
            <form method="POST">
                <div class="cerrar_session">
                    <button name="cerrar" class="btn btn-danger" style="font-weight:bold;" >Cerrar Sesión</button>
                </div>
            </form>
            
            <div class="Titulo">
                <p class="text-center">Bienvenido/a <?php echo $usuario; ?></p>
            </div>
            <form method="POST" enctype="multipart/form-data" >
                <div class="bitacora">
                    <p>Ingrese el dia de su bitacora <input type="date" name="fecha" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d")?>" ></p> 
                </div>
                <div class="cuadro-texto">
                    <form>
                        <textarea style="resize: none;" name="textobitacora" class="text form-control mt-4" placeholder="Este día configure un proyecto..." require></textarea>
                        <br>
                        <button name="enviar" type="submit" class="btn btn-success btn-lg mt-4" onclick="myFunction();" style="float:right; font-weight:bold;">Enviar</button>
                    </form>
                    <script type="text/javascript">
                        function myFunction() {
                            alert("Se ha enviado con exito");
                        }
                    </script>
                    <br>
                    <input name="fichero" type="file" class="btn btn-warning fich mt-4" >
                    <script type="text/javascript" src="java/funciones.js"></script>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


