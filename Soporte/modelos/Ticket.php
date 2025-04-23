<?php
    class Ticket extends Conectar {
        
        // Función para generar número de ticket único
        private function generarTicketID($conectar) {
            $fecha = date("Ymd");
            $maxIntentos = 10;
    
            for ($i = 0; $i < $maxIntentos; $i++) {
                $sql = "SELECT COUNT(*) as total FROM tickets WHERE DATE(t_crea) = CURDATE()";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $conteo = $row['total'] + 1 + $i; // se suma $i para evitar duplicado en intentos
    
                $codigo = str_pad($conteo, 6, "0", STR_PAD_LEFT);
                $t_num = "TCK-$fecha-$codigo";
    
                // Verificamos si ya existe ese número
                $check = $conectar->prepare("SELECT COUNT(*) FROM tickets WHERE t_num = ?");
                $check->execute([$t_num]);
                $existe = $check->fetchColumn();
    
                if ($existe == 0) {
                    return $t_num;
                }
            }
    
            throw new Exception("No fue posible generar un número de ticket único después de varios intentos.");
        }

        public function insert_ticket($t_tit, $area_id, $emp_id, $t_phone, $cat_id, $scat_id, $t_desc) {
            $conectar = parent::conexion();
            parent::set_names();

            // Obtener número de ticket único
            $t_num = $this -> generarTicketID($conectar);
            
            $sql = "INSERT INTO tickets (t_num, t_tit, area_id, emp_id, t_phone, cat_id, scat_id, niv_id, est_id, sest_id, t_desc, t_crea, t_upd) VALUES (?, ?, ?, ?, ?, ?, ?, 4, 1, 1, ?, NOW(), NOW());";
            
            $sql = $conectar->prepare($sql);
            
            $sql -> bindValue(1, $t_num);
            $sql -> bindValue(2, $t_tit);
            $sql -> bindValue(3, $area_id);
            $sql -> bindValue(4, $emp_id);
            $sql -> bindValue(5, $t_phone);
            $sql -> bindValue(6, $cat_id);
            $sql -> bindValue(7, $scat_id);
            $sql -> bindValue(8, $t_desc);
            $sql -> execute();
            return $t_num;
        }
    }

?>
