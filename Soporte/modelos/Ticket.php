<?php
    class Ticket extends Conectar {
        public function insert_ticket($t_num, $t_tit, $area_id, $emp_id, $t_phone, $cat_id, $scat_id, $niv_id, $est_id, $sest_id, $t_desc, $t_crea, $t_upd) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM categorias WHERE c_stat=1;";
            $sql = $conectar->prepare($sql);
            
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    }

?>
