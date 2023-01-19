<?php  
include '../funciones.php';

$config = include '../config.php';
$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
$consultaSQL = "SELECT * FROM Carrera";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();
$Carreras = $sentencia->fetchAll();

$resultado = [
	'error'=>false,
	'mensaje'=>''
];

if (!isset($_GET['id'])){
	$resultado['error'] =true;
	$resultado['mensaje'] ='El usuario no existe';
}

if (isset($_POST['submit'])){
	$resultado =[
		'error' =>false,
		'mensaje'=>'El usuario '.$_POST['nombre'].' ha sido modificado con éxito'//editar datos del alumno creado
	];
	try {
		$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
		$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
		$mail = $_POST['mail'];
		if (($_POST['rol'] == "Alumno")){
			try{
				$CodigoCarrera = $_POST['idCarrera'];
				$consultaSQL = "SELECT CodigoCarrera FROM carrera WHERE idCarrera = '$CodigoCarrera'";
				$sentencia = $conexion->prepare($consultaSQL);
				$sentencia->execute();
				$CodigoCarrera = $sentencia->fetch();
				$CodigoCarrera = $CodigoCarrera['CodigoCarrera'];
	
				$usuarios = [  //variable usuario junto a sus atributos
					"email" => $_POST['mail'],
					"PASSWORD" => $_POST['password'],
					"idRol" => "2"
				];
				
				$informacion = [
					"email" => $_POST['mail'],
					"Nombre" => $_POST['nombre'],
					"ApellidoPat" => $_POST['ApellidoPat'],
					"ApellidoMat" => $_POST['ApellidoMat']
				];
				
				$estudiante = [
					"rutEstudiante" => $_POST['rut'],
					"email" => $_POST['mail'],
					"CodigoCarrera" => $CodigoCarrera,
					"rutEmpresa" => $_POST['rutEmpresa']
	
				];
				
				// Ingresar datos en Usuarios
				$consultaSQL = "UPDATE usuarios SET
					email = :email,
					PASSWORD = :PASSWORD,
					idRol = :idRol 
					WHERE email = '$mail'";
				$sentencia = $conexion->prepare($consultaSQL);
				$sentencia->execute($usuarios);
				
				// Ingresar datos en INFORMACION
				$consultaSQL = "UPDATE informacion SET
					email = :email,
					Nombre = :Nombre,
					ApellidoPat = :ApellidoPat,
					ApellidoMat = :ApellidoMat
					WHERE email = '$mail'";
				$sentencia = $conexion->prepare($consultaSQL);
				$sentencia->execute($informacion);
				// Ingresar datos en ESTUDIANTE
				$consultaSQL = "UPDATE estudiantes SET
					rutEstudiante = :rutEstudiante,
					email = :email,
					CodigoCarrera =:CodigoCarrera
					WHERE email = '$mail'";
				$sentencia = $conexion->prepare($consultaSQL);
				$sentencia->execute($estudiante);
				?>
				
				<Script>
					alert("Actualizacion de datos exitosa, redirigiendo a home...");
					window.location.replace('index.php');
				</script><?php
			}catch(PDOException $error){
				?>
				<Script>
					alert("No se han podido actualizar los datos");
				</script><?php
			}
						


		}if (($_POST['rol'] == "Tutor")){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => "3"
			];
			$informacion = [
				"email" => $_POST['mail'],
				"Nombre" => $_POST['nombre'],
				"ApellidoPat" => $_POST['ApellidoPat'],
				"ApellidoMat" => $_POST['ApellidoMat']
			];
			$supervisor = [
				"rutSupervisor" => $_POST['rut'],
				"email" => $_POST['mail'],

			];
			// Ingresar datos en Usuarios
			$consultaSQL = "UPDATE usuarios SET 
				email = :email,
				PASSWORD = :PASSWORD,
				idRol = :idRol 
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);
			// Ingresar datos en INFORMACION
			$consultaSQL = "UPDATE informacion SET
				email = :email,
				Nombre = :Nombre,
				ApellidoPat = :ApellidoPat,
				ApellidoMat = :ApellidoMat
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($informacion);
			// Ingresar datos en SUPERVISOR
			$consultaSQL = "UPDATE supervisor SET
				rutSupervisor = :rutSupervisor,
				email = :email
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($supervisor);
			?>
			
			<Script>
				alert("Actualizacion de datos exitosa, redirigiendo a home...");
				window.location.replace('index.php');
			</script>
			<?php

		}if (($_POST['rol']) == "Jefe de carrera"){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => "4"
			];
			$informacion = [
				"email" => $_POST['mail'],
				"Nombre" => $_POST['nombre'],
				"ApellidoPat" => $_POST['ApellidoPat'],
				"ApellidoMat" => $_POST['ApellidoMat']
			];
			$jefecarrera = [
				"rutJefeCarrera" => $_POST['rut'],
				"sede" => $_POST['Sede'],
				"Facultad" => $_POST['Facultad'],
				"email" => $_POST['mail']
			];
			$UpdateCarrera = [
				"RutJefe" => $_POST['rut']
			];

			// Ingresar datos en Usuarios
			$consultaSQL = "UPDATE usuarios SET 
				email = :email,
				PASSWORD = :PASSWORD,
				idRol = :idRol 
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);
			// Ingresar datos en INFORMACION
			$consultaSQL = "UPDATE informacion SET
				email = :email,
				Nombre = :Nombre,
				ApellidoPat = :ApellidoPat,
				ApellidoMat = :ApellidoMat
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($informacion);
			// Ingresar datos en jefecarrera
			$consultaSQL = "UPDATE jefecarrera SET
				rutJefeCarrera = :rutJefeCarrera,
				sede = :sede,
				Facultad = :Facultad,
				email = :email
				WHERE email = '$mail'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($jefecarrera);
			// Actualizar Carrera
			$consultaSQL = "UPDATE carrera SET
				Rutjefe = 'NAJefe'
				WHERE RutJefe = '$_POST[rut]'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute();

			$consultaSQL = "UPDATE carrera SET
				Rutjefe = :RutJefe
				WHERE idCarrera = '$_POST[idCarrera]'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($UpdateCarrera);
			?>
			
			<Script>
				alert("Actualizacion de datos exitosa, redirigiendo a home...");
				window.location.replace('index.php');
			</script>
			<?php

		}
	} catch(PDOException $error){
		$resultado['error']=true;//mensaje de error o aprobacion
		$resultado['mensaje']=$error->getMessage();
	}
}

try {
	$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
	$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
	$id = $_GET['id'];
	$consultaSQL = "SELECT informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat, roles.nombrerol,usuarios.email, 
	usuarios.PASSWORD, estudiantes.rutEstudiante,estudiantes.rutEmpresa,estudiantes.CodigoCarrera, supervisor.RutSupervisor, jefecarrera.rutJefeCarrera from 
	informacion INNER JOIN usuarios on informacion.email = usuarios.email INNER JOIN roles 
	on usuarios.idRol = roles.idRoles LEFT JOIN estudiantes on usuarios.email = estudiantes.email 
	LEFT JOIN supervisor on usuarios.email = supervisor.email LEFT JOIN jefecarrera on 
	usuarios.email = jefecarrera.email WHERE usuarios.email='$id'";
	$sentencia = $conexion->prepare($consultaSQL);
	$sentencia->execute();
	$usuario =$sentencia->fetch(PDO::FETCH_ASSOC);

	if ($_GET['rol'] == "Alumno"){
		$consultaSQL = "SELECT carrera.CodigoCarrera FROM carrera, estudiantes WHERE carrera.CodigoCarrera = estudiantes.CodigoCarrera AND estudiantes.email = '$id'";
		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();
		$estudianteCarrera = $sentencia->fetch();
		$estudianteCarrera = $estudianteCarrera['CodigoCarrera'];
	}
	
	if ($usuario['nombrerol'] == "Jefe de carrera"){
		$consultaSQL = "SELECT carrera.Carrera, jefecarrera.sede, jefecarrera.Facultad, jefecarrera.rutJefeCarrera FROM jefecarrera INNER JOIN carrera WHERE jefecarrera.email = '$id' AND carrera.Rutjefe = jefecarrera.rutJefeCarrera;";
		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();
		$DatosCarrera = $sentencia->fetch(PDO::FETCH_ASSOC);

		$consultaSQL = "SELECT carrera.idCarrera FROM carrera, jefecarrera where jefecarrera.email = '$id' AND jefecarrera.rutJefeCarrera = Carrera.Rutjefe";
		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();
		$estudianteCarrera = $sentencia->fetch();
		$estudianteCarrera = $estudianteCarrera['idCarrera'];
	}

	if(!$usuario){
		$resultado['error'] =true;
		$resultado['mensaje'] ='El alumno no se ha encontrado';
	}
}catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="../css/editar.css">
	<link rel="icon" href="../IMG/practice.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<?php require "../templates/header.php"; ?>
<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
if (!isset($resultado)){
	?>
	<div class="container">
 	 <div class="row">
  	  <div class="col-md-12">
  	   <div class="alert alert-<?= $resultado['error'] ? ' danger' : 'success' ?> " role="alert">
  	   		<?= $resultado['mensaje'] ?>
  	   	</div>
  	   </div>
  	</div>
  </div>
  <?php
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
<div class="container" style="height:64rem;">
     	<div class="text-center">
      		<div class="col-md-12"><!--inputs de datos del alumno-->
      			<h2 class="mt-3"><br>Editando el usuario <?= escapar($usuario['Nombre']) . ' ' . escapar($usuario['ApellidoPat'])  ?></h2>
        		<hr>
        <form method="post">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['Nombre']) ?>" class="form-control">
			</div>

			<div class="form-group">
				<label for="apellido">Apellido Paterno</label>
				<input type="text" name="ApellidoPat" id="apellido" value="<?= escapar($usuario['ApellidoPat']) ?>" class="form-control">
			</div>
			<div class="form-group">
				<label for="apellido">Apellido Materno</label>
				<input type="text" name="ApellidoMat" id="apellido" value="<?= escapar($usuario['ApellidoMat']) ?>" class="form-control">
			</div>
			<div class="form-group">
				<label for="rut">Rut</label>
				<?php
				if ($usuario['nombrerol'] == "Tutor"){
					?><input type="rut" name="rut" id="rut" value="<?= escapar($usuario['RutSupervisor']) ?>" class="form-control"><?php
				}
				?>
				<?php
				if ($usuario['nombrerol'] == "Alumno"){
					?><input type="rut" name="rut" id="rut" value="<?= escapar($usuario['rutEstudiante']) ?>" class="form-control"><?php
				}
				?>
				<?php
				if ($usuario['nombrerol'] == "Jefe de carrera"){
					?><input type="rut" name="rut" id="rut" value="<?= escapar($usuario['rutJefeCarrera']) ?>" class="form-control"><?php
				}
				?>
			</div>
			
			<div class="form-group">
				<label for="mail">Mail</label>
				<input type="text" name="mail" id="mail" value ="<?=escapar($usuario['email']) ?>" class="form-control" readonly='readonly' style="background-color:RGBA(127,112,112,0.5); color:white; font-weight:bold;">
			</div>
			<div class="form-group">
				<label for="password">Contraseña</label>
				<input type="password" name="password" id="password" value ="<?=escapar($usuario['PASSWORD']) ?>" class="form-control" minlength="8">
			</div>
			<label>Rol de usuario </label>
			<br>
			<div class="input-group ">
			<input type="text" name="rol" id="rol" value="<?= escapar($usuario['nombrerol']) ?>" readonly='readonly' class="form-control" style="background-color:RGBA(127,112,112,0.5); color:white; font-weight:bold;">
			</div>
			<div id="Carrera" class="mr-4">
		
			<p>Carrera</p>
			<select name="idCarrera" id="idCarrera" style="color:black;" class="form-select">
				<?php
				foreach ($Carreras as $cr){
					if ($estudianteCarrera == $cr['CodigoCarrera'] || $estudianteCarrera == $cr['idCarrera']){
						echo "<option name=idCarrera value=$cr[idCarrera] selected style=color:black;>$cr[Carrera] </option>";
					}else{
						echo "<option name=idCarrera value=$cr[idCarrera] style=color:black;>$cr[Carrera] </option>";}
					}
					
				?>
			</select>
			<div class="container1 form-group" id="sede" style="display: none;">
				<label>Sede</label>
				<input type="text" id="idSede" name="Sede" class="form-control" value="<?= escapar($DatosCarrera['sede']) ?>">
			</div>
			<div class="form-group" id="facultad" style="display: none;">
				<label>Facultad</label>
				<input type="text" id="idFacultad" name="Facultad" class="form-control" value="<?= escapar($DatosCarrera['Facultad']) ?>">
			</div>
			<div class="form-group mt-2">
				<label >Rut Empresa</label>
				<input type="text" name="rutEmpresa" id="rutEmpresa" value="<?= escapar($usuario['rutEmpresa']) ?>" class="form-control">
			</div>
			</div>
			</div>
			</div>			
			<script src="../java/funciones.js"></script>
			<div class="botonesabajo mt-4">
				<div class="butbg">
					<input type="submit" value="Actualizar" class=" button-35 boton1 mb-4" name="submit">
					<input type="button" class=" button-35 boton2" onclick="location.href='index.php'" value="Volver"/>
					
				</div>
			
			</div>
		</form>
	</div>	
	
</div>
			
	


<?php
}
?>
<?php require "../templates/footer.php"; ?>

<body>
 
<!--Scripts de boostrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>