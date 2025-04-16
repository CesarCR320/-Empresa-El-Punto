<?php
    class Usuarios extends Conectar {
        public function get_usuario() {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM empleados WHERE stat=1;";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    }

?>
