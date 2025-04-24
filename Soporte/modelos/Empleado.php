<?php
    class Empleado extends Conectar {

        public function insert_empleado($e_name, $e_last1, $e_last2, $e_mail, $e_phone, $e_pass, $pue_id, $area_id) {
            $conectar = parent::conexion();
            parent::set_names();

            // Obtener número de ticket único
            /* $t_num = $this -> generarTicketID($conectar); */
            
            $sql = "INSERT INTO empleados (e_name, e_last1, e_last2, e_mail, e_phone, e_pass, pue_id, area_id, e_stat, e_crea, e_mod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW());";
            
            $sql = $conectar->prepare($sql);
            
            $sql -> bindValue(1, $e_name);
            $sql -> bindValue(2, $e_last1);
            $sql -> bindValue(3, $e_last2);
            $sql -> bindValue(4, $e_mail);
            $sql -> bindValue(5, $e_phone);
            $sql -> bindValue(6, $e_pass);
            $sql -> bindValue(7, $pue_id);
            $sql -> bindValue(8, $area_id);
            $sql -> execute();
            return $resultado = $sql->fetchAll();
        }

    }

?>
