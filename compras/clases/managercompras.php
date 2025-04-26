<?php
// Clase para gestionar las compras
class managercompras {
    private $conexion;
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    // CREATE - Agregar una nueva compra
    public function agregarCompra($proveedor_id, $producto, $cantidad, $precio_unitario, $fecha_compra, $estado) {
        $total = $cantidad * $precio_unitario;
        
        $query = "INSERT INTO compras (proveedor_id, producto, cantidad, precio_unitario, total, fecha_compra, estado) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isddiss", $proveedor_id, $producto, $cantidad, $precio_unitario, $total, $fecha_compra, $estado);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // READ - Obtener todas las compras
    public function obtenerCompras() {
        $query = "SELECT c.*, p.nombre as nombre_proveedor 
                 FROM compras c 
                 JOIN proveedores_compras p ON c.proveedor_id = p.id 
                 ORDER BY c.fecha_compra DESC";
        
        $resultado = $this->conexion->query($query);
        $compras = [];
        
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $compras[] = $fila;
            }
        }
        
        return $compras;
    }
    
    // READ - Obtener una compra específica
    public function obtenerCompra($id) {
        $query = "SELECT c.*, p.nombre as nombre_proveedor 
                 FROM compras c 
                 JOIN proveedores_compras p ON c.proveedor_id = p.id 
                 WHERE c.id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows == 1) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
    }
    
    // UPDATE - Actualizar una compra existente
    public function actualizarCompra($id, $proveedor_id, $producto, $cantidad, $precio_unitario, $fecha_compra, $estado) {
        $total = $cantidad * $precio_unitario;
        
        $query = "UPDATE compras 
                  SET proveedor_id = ?, producto = ?, cantidad = ?, 
                      precio_unitario = ?, total = ?, fecha_compra = ?, estado = ? 
                  WHERE id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isddissi", $proveedor_id, $producto, $cantidad, $precio_unitario, $total, $fecha_compra, $estado, $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // DELETE - Eliminar una compra
    public function eliminarCompra($id) {
        $query = "DELETE FROM compras WHERE id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // Obtener todos los proveedores para el formulario
    public function obtenerProveedores() {
        $query = "SELECT id, nombre FROM proveedores_compras ORDER BY nombre";
        
        $resultado = $this->conexion->query($query);
        $proveedores = [];
        
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $proveedores[] = $fila;
            }
        }
        
        return $proveedores;
    }
}
?>
