<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="IMG/practice.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>🔒Inicio de Sesión🔒</title>
</head>
<body>
    <!-- Just an image -->
<nav class="navbar ">
<div class="container ">
    <a class="navbar-brand ">
      <div class="logo-image ">
      <img src="IMG/logo.png" class="img-fluid text-center navbar-brand-center">
      </div>
    </a>
</div>
</nav>

    <div class="text-center">
    <div class="Caja">
        <div class="imagen">
            <img src="IMG/practice.jpg" alt="" srcset="" class="img-fluid">
        </div>
        <br>
   <form method="post">
    
   <h1 class="animate__animated animate__backInLeft inicio">Inicio de Sesión🔒</h1>
   <p class="blanco">Ingrese su email<input type="text" placeholder="Ingrese su email" name="mail" ></p> <!--input de inicio de sesion-->
   
   <p class="blanco">Contraseña <input type="password" minlength="8" placeholder="Ingrese su contraseña" name="password"></p> <!--contraseña-->
   <br>
   <input class="btn btn-light" type="submit" name="submit" value="Ingresar">
   </form>
    </div> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>

<?php
if(isset($_POST['submit'])){
    require 'conexion.php';
    session_start();

    $usuario = $_POST['mail'];
    $contraseña = $_POST['password'];
    $query = "SELECT COUNT(*) as contar from usuarios where email= '$usuario' and PASSWORD = '$contraseña' ";
    $consulta = mysqli_query($conexion, $query);
    $array = mysqli_fetch_array($consulta);
    if($array['contar']>0){
        $_SESSION['Usuarios']['mail'] = $usuario;
        $query= "SELECT idRol as rol from usuarios where email='$usuario'";
        $consulta=mysqli_query($conexion,$query);
        $roles=mysqli_fetch_array($consulta);
        $rol = $roles['rol'];

        $query= "SELECT Nombre, ApellidoPat, ApellidoMat from informacion where email='$usuario'";
        $consulta=mysqli_query($conexion,$query);
        $user=mysqli_fetch_array($consulta);    
        $nombreusuario = $user['Nombre'];
        $_SESSION['Usuarios']['user'] = $nombreusuario;
        $_SESSION['Usuarios']['ApellidoPat'] = $user['ApellidoPat'];

        if ($rol=='1'){
            $_SESSION['Usuarios']['rol'] = $rol;
            header("location: Administrador/index.php");
            die();
        }
        if ($rol == "2"){
            $_SESSION['Usuarios']['rol'] = $rol;
            $query= "SELECT rutEstudiante from estudiantes where email='$usuario'";
            $consulta=mysqli_query($conexion,$query);
            $rut=mysqli_fetch_array($consulta);
            $rut = $rut['rutEstudiante'];
            $_SESSION['Usuarios']['rut'] = $rut;
            header("location: Estudiante/alumno.php");
            die();
        }
                
        if ($rol == "3"){
            $_SESSION['Usuarios']['rol'] = $rol;
            $query= "SELECT RutSupervisor from supervisor where email='$usuario'";
            $consulta=mysqli_query($conexion,$query);
            $rut=mysqli_fetch_array($consulta);
            $rut = $rut['RutSupervisor'];
            $_SESSION['Usuarios']['rut'] = $rut;
            header("location: Supervisor/Supervisor.php");
        }
        if ($rol == "4"){
            $_SESSION['Usuarios']['rol'] = $rol;
            $query= "SELECT rutJefeCarrera from jefecarrera where email='$usuario'";
            $consulta=mysqli_query($conexion,$query);
            $rut=mysqli_fetch_array($consulta);
            $rut = $rut['rutJefeCarrera'];
            $_SESSION['Usuarios']['rut'] = $rut;
            header("location: JefeCarrera/jefecarrera.php");
            die();
        }
        if ($rol !=1 || $rol !=2 || $rol !=3 || $rol !=4){
                    
        }
    die();

    
}else{
    ?>
    <script> alert("El usuario o contraseña son incorrectos, intente nuevamente"); </script>
    <?php
    die();
}

}