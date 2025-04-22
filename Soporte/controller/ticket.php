<?php
    require_once "../config/conexion.php";
    require_once "../modelos/Ticket.php";
    $ticket = new Ticket();
    
    if (isset($_GET["op"])) {
        switch ($_GET["op"]) {
            case "insert":
                $ticket->insert_ticket();
            break;
        }
    }
?>
