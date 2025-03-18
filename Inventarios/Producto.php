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

        //Método get para obtener el valor de nombre
        public function getNombre(){
            return $this->nombre;
        }

        //Método set para cambiar el valor de nombre
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        //Método get para obtener el valor de tipo
        public function getTipo(){
            return $this->tipo;
        }

        //Método set para cambiar el valor de tipo
        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

        //Método get para obtener el valor de descripcion
        public function getDescripcion(){
            return $this->descripcion;
        }

        //Método set para cambiar el valor de descripcion
        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        //Método get para obtener el valor de foto
        public function getFoto(){
            return $this->foto;
        }

        //Método set para cambiar el valor de foto
        public function setFoto($foto){
            $this->foto = $foto;
        }

    }
?>