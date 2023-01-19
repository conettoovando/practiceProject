<?php
    class Productos_modelo { //creacion de la clase productos donde se consultan los nombres de usuarios creados a partir del administrador.
        private $db;
        private $productos;
        public function __construct(){
            require_once("Conectar.php");
            $this->db=Conectar::conexion();
            $this->productos=array();
        }
        public function get_productos(){
            $consulta=$this->db->query(
                "SELECT informacion.Nombre, informacion.ApellidoPat, informacion.ApellidoMat, roles.nombrerol, usuarios.email, 
                usuarios.PASSWORD, estudiantes.rutEstudiante, supervisor.RutSupervisor, jefecarrera.rutJefeCarrera from 
                informacion INNER JOIN usuarios on informacion.email = usuarios.email INNER JOIN roles 
                on usuarios.idRol = roles.idRoles LEFT JOIN estudiantes on usuarios.email = estudiantes.email 
                LEFT JOIN supervisor on usuarios.email = supervisor.email LEFT JOIN jefecarrera on 
                usuarios.email = jefecarrera.email
            ");
            while ($filas=$consulta->fetch(PDO::FETCH_ASSOC)){
                $this->productos[]=$filas;
            }
            
            return $this->productos;
        }

    }
?>