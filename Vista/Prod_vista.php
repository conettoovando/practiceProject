<?php include '../funciones.php'?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="../css/Newstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    
    <title>inicio de sesión🔒</title>
    <style>
        td {
            text-align: center;
        }
    </style>
</head>

<
<body>

    <?php
    session_start();
    if (isset($_SESSION['Usuarios']['mail'])){ //bienvenida al usuario logueado
        ?>
        <?php
        $rol = $_SESSION['Usuarios']['rol'];
    }else{
        header('location: session.php');
    } 
    if (isset($_POST['cerrar'])){ //Cerrar sesión
        session_destroy();
        header('location: ../session.php');
    }
    if (isset($_POST['agregar'])){//Crear nuevo usuario para loguear
        header('location: crear.php');
    }
    ?>

<div class="divcontainerd">
 
    <div class="botones-izquierda">
                <div class="Titulo-menu"> 
                    <h1>MENU</h1>
                </div>
                <form method="POST">
                    <div class="cuadroboton"> 
                        <button type="submit" value="Agregar Usuario"  class="button button-35" name="agregar" href="crear.php">Agregar Usuario</button>
                </div>
                <div class="cuadroboton">
                    <button type="submit" name="cerrar" class="button button-35"  value="Cerrar sesión">Cerrar Sesión</button>
                </div>

                </form>    
            </div>
            <table class="table table-responsibe table-dark text-center mt-4 ">
            <thead >
                <tr>
                <th scope="col" class="text-white bg-dark">Nombre</th>
                <th scope="col" class="text-white bg-dark" >Apellido Paterno</th>
                <th scope="col" class="text-white bg-dark" >Apellido Materno</th>
                <th scope="col" class="text-white bg-dark" >Rut</th>
                <th scope="col" class="text-white bg-dark" >Mail</th>
                <th scope="col" class="text-white bg-dark" >ROL</th>
                <th scope="col" class="text-white bg-dark" >Contraseña</th>
                <th scope="col" class="text-white bg-dark" >-</th>
                <th scope="col" class="text-white bg-dark" >-</th>
                </tr>
            </thead>
        <?php
            foreach($matrizProductos as $registro){  ?>  <!-- consulta de datos segun su parametro -->
            <tr>
              
            <?php 
          
         

            echo "<td>". $registro["Nombre"]. "</td>";
            echo "<td>". $registro["ApellidoPat"]. "</td>";
            echo "<td>". $registro["ApellidoMat"]. "</td>";
            if ($registro['nombrerol'] == "Alumno"){
                echo "<td>". $registro["rutEstudiante"]. "</td>";
            }
            if ($registro['nombrerol'] == "Tutor"){
                echo "<td>". $registro["RutSupervisor"]. "</td>";
            }
            if ($registro['nombrerol'] == "Jefe de carrera"){
                echo "<td>". $registro["rutJefeCarrera"]. "</td>";
            }
            echo "<td>". $registro["email"]. "</td>";
            echo "<td>". $registro["nombrerol"]. "</td>";
            echo "<td>". $registro["PASSWORD"]. "</td>"; ?> <!-- Esto lo quitaria --> 
            <td><a class="editar" href="<?= 'editar.php?id='.escapar($registro["email"]).'&rol='.escapar($registro['nombrerol'])?>">✏️ Editar</a></td>
            <td><a class="borrar" onclick="return confirm('Seguro que desea eliminar?');" href="<?='borrar.php?id='.escapar($registro["email"]).'&rol='.escapar($registro['nombrerol'])?>">🗑️ Borrar</a></td>
            </tr>        
            <?php
            }
        ?>

        </table>
    </div>
    </div>
    
</div>
</body>
</html>