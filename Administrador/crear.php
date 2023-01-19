<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/crear.css">
	<link rel="icon" href="../IMG/practice.jpg">
	<title>Creacion de Usuario</title>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
	<?php
	$config = include "../config.php";
	$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
	$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
	$consultaSQL = "SELECT * FROM Carrera";
	$sentencia = $conexion->prepare($consultaSQL);
	$sentencia->execute();
	$Carreras = $sentencia->fetchAll();
	?>
	<div class="container">
		
		<!-- input de los atributos del usuario -->
		<input type="button" class="but2 button-35" value="Regresar al inicio" onclick="location.href='index.php';" />



	<form method="post" class="form-inline">
		<section class="form-register">
		<h1 class="text-center">Formulario Registro</h1>
		<div class="form-group row mb-4">
			<label for="Appeterno" class="col-sm-2 col-form-label">Rol</label>
			<div class="col-sm-10">
			<div class="roles w-33">
				<select  id="rol" name ="rol" onchange="show()" class="form-select">
					<label for="rol">Rol de usuario </label>
					<option name="rol" id="rol" value="1">ADMINISTRADOR</option>
					<option name="rol" id="rol" value="2">ALUMNO</option>
					<option name="rol" id="rol" value="3">TUTOR</option>
					<option name="rol" id="rol" value="4">JEFE DE CARRERA</option>
					<option name="rol" id="rol" value="5">Centro Practica</option>
				</select>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
			<div class="col-sm-10">
				<input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre" required>
			</div>
		</div>
		<div class="form-group row" id='divApellidoPat'>
			<label for="Appeterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
			<div class="col-sm-10">
			<input class="controls" type="text" name="ApellidoPat" id="apellido" placeholder="Apellido Paterno" required>
			</div>
		</div>
		<div class="form-group row" id='divApellidoMat'>
			<label for="Appeterno" class="col-sm-2 col-form-label">Apellido Materno</label>
			<div class="col-sm-10">
			<input class="controls" type="text" name="ApellidoMat" id="apellidomat" placeholder="Apellido Materno" required>
			</div>
		</div>
		<div class="form-group row">
			<label for="Appeterno" class="col-sm-2 col-form-label">Ingrese el rut</label>
			<div class="col-sm-10">
			<input class="controls" type="text" name="rut" id="rut" placeholder="Rut" required> 
			</div>
		</div>
		<div class="form-group row">
			<label for="Appeterno" class="col-sm-2 col-form-label">Ingrese el correo</label>
			<div class="col-sm-10">
			<input class="controls" type="email" name="mail" id="mail" placeholder="Correo" required> 
			</div>
		</div>
		<div class="form-group row" id = 'divPassword'>
			<label for="Appeterno" class="col-sm-2 col-form-label">Ingrese la contraseña</label>
			<div class="col-sm-10">
			<input class="controls" type="password" name="password" id="password" placeholder="Ingrese su Contraseña">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10">
				<div id="Carrera">
					<p>Carrera</p><br>
					<div class="carrera">
						<div class="w-34 text-center">
							<div class="center">
								<select name="idCarrera" id="idCarrera" style="color:black; width:350px;"class="form-select ml-5 pr-3"  >
									<?php
									foreach ($Carreras as $cr){
										echo "<option name=idCarrera value=$cr[idCarrera] style=color:black;width:100%;>$cr[Carrera] </option>";}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row sede" id="sede">
				<label for="SEDE" class="col-sm-2 col-form-label">Sede</label>
				<div class="col-sm-10">
				<input class="controls mt-4 controls__noview" type="text" name="Sede" id="idsede" placeholder="Ingrese la sede correspondiente">
				</div>
			</div> 
			<div class="form-group row " id="facultad">
				<label for="SEDE" class="col-sm-2 col-form-label">Facultad</label>
				<div class="col-sm-10">
				<input class="controls  mt-4 controls__noview" type="text" name="Facultad" id="idFacultad" placeholder="Ingrese la facultad">
				</div>
			</div>
			<div class="form-group row " id="divTelefonoJefe">
				<label for="SEDE" class="col-sm-2 col-form-label">telefono Jefe &nbsp</label>
				<div class="col-sm-10">
				<input class="controls  mt-4 controls__noview" type="text" name="telefonoJefe" id="telefonoJefe" placeholder="Ingrese la facultad">
				</div>
			</div>
			</div> 
				<div class="form-group row " id="divNombreJefe">
				<label for="SEDE" class="col-sm-2 col-form-label">Nombre Jefe</label>
				<div class="col-sm-10">
				<input class="controls  mt-4 controls__noview" type="text" name="nombreJefe" id="nombreJefe" placeholder="Ingrese la facultad">
				</div>
			</div>
			<div class="form-group row " id="divCentroAlumno">
				<label for="SEDE" class="col-sm-2 col-form-label">Rut centro de practica</label>
				<div class="col-sm-10">
				<input class="controls  mt-4 controls__noview" type="text" name="centroAlumno" id="centroAlumno" placeholder="Ingrese la facultad">
				</div>
			</div>
					
	</div>
	<script src="../java/funciones.js"></script>
	<div class="w-33">
		<div class="center">
			<button type="submit" class="button-35 mt-4" name="submit" value="Enviar">Enviar</button>
		</div>
	</div>
	</form>	
</body>
</html>

<?php 
if (isset($_POST['submit'])){
	$resultado =[
		'error' =>false,
		'mensaje'=>'El usuario '.$_POST['nombre'].' ha sido creado con éxito'  //mensaje de creacion del usuario 
	];
	
	
	$config = include '../config.php';
	try {
		if(($_POST['rol'] == "1")){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => $_POST['rol']
			];
			$consultaSQL = "INSERT INTO usuarios (email,PASSWORD,idRol)";
			$consultaSQL .= "values (:".implode(", :", array_keys($usuarios)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);

		}if (($_POST['rol'] == "2")){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$CodigoCarrera = $_POST['idCarrera'];
			// Obtener Codigo Carrera Estudiante
			$consultaSQL = "SELECT CodigoCarrera FROM carrera WHERE idCarrera = '$CodigoCarrera'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute();
			$CodigoCarrera = $sentencia->fetch();
			$CodigoCarrera = $CodigoCarrera['CodigoCarrera'];
			 
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => $_POST['rol']
			];
			$informacion = [
				"email" => $_POST['mail'],
				"Nombre" => $_POST['nombre'],
				"ApellidoPat" => $_POST['ApellidoPat'],
				"ApellidoMat" => $_POST['ApellidoMat']
			];
			$estudiante = [
				"rutEstudiante" => $_POST['rut'],
				"rutSupervisor" => 'NA',
				"rutEmpresa" => $_POST['centroAlumno'],
				"email" => $_POST['mail'],
				"CodigoCarrera" => $CodigoCarrera

			];
			// Ingresar datos en Usuarios
			$consultaSQL = "INSERT INTO usuarios (email,PASSWORD,idRol)";
			$consultaSQL .= "values (:".implode(", :", array_keys($usuarios)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);
			// Ingresar datos en INFORMACION
			$consultaSQL = "INSERT INTO informacion (email,Nombre,ApellidoPat, ApellidoMat)";
			$consultaSQL .= "values (:".implode(", :", array_keys($informacion)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($informacion);
			// Consultar Codigo Carrera
			$consultaSQL = "INSERT INTO estudiantes (rutEstudiante,rutSupervisor,rutEmpresa,email,CodigoCarrera)";
			$consultaSQL .= "values (:".implode(", :", array_keys($estudiante)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($estudiante);
			
		}if (($_POST['rol'] == "3")){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => $_POST['rol']
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
			$consultaSQL = "INSERT INTO usuarios (email,PASSWORD,idRol)";
			$consultaSQL .= "values (:".implode(", :", array_keys($usuarios)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);
			// Ingresar datos en INFORMACION
			$consultaSQL = "INSERT INTO informacion (email,Nombre,ApellidoPat, ApellidoMat)";
			$consultaSQL .= "values (:".implode(", :", array_keys($informacion)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($informacion);
			// Ingresar datos en SUPERVISOR
			$consultaSQL = "INSERT INTO supervisor (rutSupervisor,email)";
			$consultaSQL .= "values (:".implode(", :", array_keys($supervisor)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($supervisor);
		}if (($_POST['rol']) == "4"){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$usuarios = [  //variable usuario junto a sus atributos
				"email" => $_POST['mail'],
				"PASSWORD" => $_POST['password'],
				"idRol" => $_POST['rol']
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
			// Ingresar datos en Usuarios
			$consultaSQL = "INSERT INTO usuarios (email,PASSWORD,idRol)";
			$consultaSQL .= "values (:".implode(", :", array_keys($usuarios)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($usuarios);
			// Ingresar datos en INFORMACION
			$consultaSQL = "INSERT INTO informacion (email,Nombre,ApellidoPat, ApellidoMat)";
			$consultaSQL .= "values (:".implode(", :", array_keys($informacion)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($informacion);
			// Ingresar datos en jefecarrera
			$consultaSQL = "INSERT INTO jefecarrera (rutJefeCarrera, sede, Facultad, email)";
			$consultaSQL .= "values (:".implode(", :", array_keys($jefecarrera)).")";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute($jefecarrera);

			// Actualizar tabla carrera al rut jefe
			$rutJefeCarrera = $jefecarrera['rutJefeCarrera'];
			$CarreraJefe = $_POST['idCarrera'];
			$consultaSQL = "UPDATE carrera SET Rutjefe='$rutJefeCarrera' WHERE idCarrera = '$CarreraJefe'";
			$sentencia = $conexion->prepare($consultaSQL);
			$sentencia->execute();
		}if (($_POST['rol']) == '5'){
			$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
			$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
			$centro = [  //variable usuario junto a sus atributos
				"rut_empresa" => $_POST['rut'],
				"email_empresa" => $_POST['mail'],
				"descripcion_empresa" => $_POST['nombre'],
				"telefonoJefe" => $_POST['telefonoJefe'],
				"nombreJefe" => $_POST['nombreJefe'],
				"idrol" => $_POST['rol']
			];
			$query = "INSERT INTO centro (rut_empresa, email_empresa, descripcion_empresa, telefonoJefe, nombreJefe, idrol)";
			$query .= "VALUES (:".implode(", :", array_keys($centro)).")";
			$sentencia = $conexion -> prepare ($query);
			$sentencia->execute($centro);
		}
	} catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
}
?>

<?php include "../templates/header.php"; ?>
<?php  
if (isset($resultado)){
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



<?php include "../templates/footer.php"; ?>