<?php
    require_once("../Modelo/Prod_mod.php");

    $producto = new Productos_modelo();
    $matrizProductos = $producto->get_productos(); //creacion de matriz de datos

    require_once("../Vista/Prod_vista.php");

?>