<?php
$config = include 'config.php';

$conexion = mysqli_connect($config['db']["host"],$config['db']["user"],$config['db']["pass"],$config['db']["name"]);
?>