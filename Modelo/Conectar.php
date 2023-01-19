<?php
class Conectar {
    public static function conexion(){//Conexion de atributos y configuracion de html a phpmyadmin
        $config = include '../config.php';
        try {
            $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
            $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['option']); 
            $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET CHARACTER SET UTF8");
        } catch(Exception $error){
            die("Error ".$error->getMessage());
            echo "Linea de Error ".$error->getLine();
        }
        return $conexion;
    }

}

?>