<?php
    class Administrador{
        //Atributos
        private $id;
        private $nombre;
        private $tipo;
        private $descripcion;
        private $foto;

        //Constructor para inicializar los atributos 
        public function  __construct($id, $nombre, $tipo, $descripcion, $foto){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->descripcion = $descripcion;
            $this->foto = $foto;
        }

        //Método get para obtener el valor de id
        public function getId(){
            return $this->id;
        }

        //Método set para cambiar el valor de id
        public function setId($id){
            $this->id = $id;
        }

        //Método get para obtener el valor de usuario
        public function getUsuario(){
            return $this->usuario;
        }

        //Método set para cambiar el valor de usuario
        public function setUsuario($usuario){
            $this->usuario = $usuario;
        }

        //Método get para obtener el valor de contrasena
        public function getContrasena(){
            return $this->contrasena;
        }

        //Método set para cambiar el valor de id
        public function setContrasena($contrasena){
            $this->contrasena = $contrasena;
        }

        public function verificarDatos($usuario, $contrasena) {
            if ($this->usuario == $usuario && $this->contrasena == $contrasena) {
                    header("Location: paginaPrincipalAdministrador.php?id=" . $this->id);
                    exit;
                }else{
                    return false;
                }        
        }

        public function verificarId($idObtenido, $archivoDestino){
            if($this->id == $idObtenido){
                // Redirigir a mostrarCamposAdmin.php y pasar el id por la URL
                header("Location: " . $archivoDestino . "?id=" . $this->id);
                exit;
            }
            return false;
        }

    }
?>