<?php
    class Ticket extends Conectar {
        public function insert_ticket($t_num, $t_tit, $area_id, $emp_id, $t_phone, $cat_id, $scat_id, $niv_id, $est_id, $sest_id, $t_desc, $t_crea, $t_upd) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tickets (t_num, t_tit, area_id, emp_id, t_phone, cat_id, scat_id, niv_id, est_id, sest_id, t_desc, t_crea, t_upd) VALUES (?, ?, ?, ?, ?, ?, ?, 4, 1, 1, ?, NOW(), NOW();";
            $sql = $conectar->prepare($sql);
            $sql -> bindValue(1, $t_num);
            $sql -> bindValue(2, $t_tit);
            $sql -> bindValue(3, $area_id);
            $sql -> bindValue(4, $emp_id);
            $sql -> bindValue(5, $t_phone);
            $sql -> bindValue(6, $cat_id);
            $sql -> bindValue(7, $scat_id);
            $sql -> bindValue(8, $niv_id);
            $sql -> bindValue(9, $est_id);
            $sql -> bindValue(10, $sest_id);
            $sql -> bindValue(11, $t_desc);
            $sql -> bindValue(12, $t_crea);
            $sql -> bindValue(13, $t_upd);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    }

?>
