<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis bitacoras</title>
    <link rel="icon" href="../favicon/bitacora.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/bitacoras.css">
</head>
<body>

    <?php
    
    session_start();
    require '../conexion.php';
    $config = include '../config.php';
    $mail = $_SESSION['Usuarios']['mail'];
    $nombre = $_SESSION['Usuarios']['user'] .' '. $_SESSION['Usuarios']['ApellidoPat'];
    $rut = $_SESSION['Usuarios']['rut'];

    $query = "SELECT COUNT(IdInforme) from (informefinal) where rutEstudiante = '$rut'";
    $consulta = mysqli_query($conexion, $query);
    $array = mysqli_fetch_array($consulta);
    if ($array[0] != 0){
        header('location:finalpractica.php');
    }

	try {
		$dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
		$conect = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
		$consultaSQL = "SELECT * FROM bitacora WHERE rutEstudiante='$rut'";
		$array = $conect->prepare($consultaSQL);
		$array->execute();?>
        <br>


        <div class="d-flex align-items-center justify-content-center text-center pumconn mt-1 " name="subir" id="subir">
            <h2 id="bienvenida" style="color:black;" class="m-4";>Bitacoras de <?php echo $_SESSION['Usuarios']['user'] ,' ', $_SESSION['Usuarios']['ApellidoPat'] ?></h2><br><br>   
        </div>
            
          
        </div>
        <form method="post">
            <br>
            <div class="buttons" >
                <button type="submit" class="btn btn-warning btn-lg" style="font-weight:bold;"role="button"name="informe" >Generar Reporte</button>
                <br>
                <br>    
                <button type="button" class="btn btn-secondary btn-lg" style="font-weight:bold;" target="_blank" onclick="location.href='alumno.php'" >Volver atras</button>
                <a class="btn btn-dark btn-lg butbaj" style="font-weight:bold;" href="#abajo" >Bajar</a>
            </div>
            
        </form>
        <div class="tablass text-center">
            <div class="taba">
        <table border="4" class="table table table-striped table-dark " cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="10%" height="10%">
            <thead class="thead-dark text-center">
                <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Descripcion Bitacora</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Archivo Adjunto</th>
                </tr>
            </thead>
            <tbody>

        
        <?php

        
        $cont = 1;
        foreach ($array as $rd){
            $formatoFecha = date("d/m/Y", strtotime($rd['fechaBitacora']))
            ?>
            <div class="container">
                <div class = 'table'>
                    <tr>
                        <td><?php echo $cont; ?></td>
                        <td><?php echo $rd['descripcionBitacora'] ?></td>
                        <td><?php echo $formatoFecha ?></td>
                        <?php
                        if ($rd['ruta'] === "Sin Archivo"){
                            echo "<script type=text/javascript>
                            function Alert(){
                                alert('El alumno no ha subido una bitacora para el día $formatoFecha'); 
                            }
                            </script>"                          
                            ?>
                            
                            <td><a href='' onclick="Alert()">Descargar</a></td>
                            
                            <?php
                        }else{
                            ?>
                            <td><a href="<?php echo $rd['ruta'];?>">Descargar</a></td>
                            <?php
                        }
                        ?>
                        
                    </tr>
                </div>
            </div>
            
        <?php
        $cont += 1 ; 
        } ?>
        </tbody>
        </table>
        </div>
        
        
    
        </div>
   
        <?php
    if (isset($_POST['informe'])){
        $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
		$conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']);
		$consultaSQL = "SELECT * FROM bitacora WHERE rutEstudiante='$rut'";
		$array = $conexion->prepare($consultaSQL);
		$array->execute();

        require('../fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Reporte bitacoras practica',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,'Nombre del alumno: '.$nombre,0,1,'C');
        $pdf->Cell(0,10,'Correo institucional: '.$mail,0,1,'C');
        $cont = 1;
        foreach ($array as $rd){
            $Leerinforme = fopen("../upload/".$mail."/".$rd['fechaBitacora']."/bitacora.txt" , "rb");
            $pdf->Image('../IMG/logo.png' , 1 ,1, 35 , 38,'PNG', 'https://www.unab.cl/');
            $pdf->Image('../IMG/practice.jpg' , 170 ,1, 35 , 38,'JPG', 'https://portal.unab.cl/');
            $datos = fread($Leerinforme,filesize("../upload/$mail/".$rd['fechaBitacora']."/bitacora.txt"));
            $pdf->Cell(0,10,utf8_decode('Fecha '.$rd['fechaBitacora']),0,1,'C');
            $pdf->Cell(0,10,utf8_decode('Bitacora N° '.$cont),0,1,'C');
            $pdf->Cell(0,10,$datos,0,1,'C');
            $cont += 1;
        }
        $route = "../upload/$mail/";
        $pdf->Output($route.'file.pdf', 'f');

        header ('location: $route.file.pdf');

    /*  exporta un archivo TXT:
        $informe = fopen("upload/".$mail."/InformeGenerado.txt", "w");
        foreach($array as $rd){
            $Leerinforme = fopen("upload/".$rd['mail']."/".$rd['fecha']."/bitacora.txt" , "rb");
            $datos = fread($Leerinforme,filesize("upload/".$rd['mail']."/".$rd['fecha']."/bitacora.txt"));
            fwrite($informe, "informe de ".$_SESSION['Usuarios']['user']."\n\n".$rd['fecha']. "\n". $datos ."\n\n");  
        }
        fclose($informe); */
    }
    
	}catch(PDOException $error){
		$resultado['error']=true;
		$resultado['mensaje']=$error->getMessage();
	}
    
    ?>
    <div class="abajo mb-2" id="abajo" name="abajo">
        <a class="btn btn-dark btn-lg mb-3" style="font-weight:bold;" href="#subir" >Subir</a>
    </div>
</body>
</html>