<?php
class Conexion {
    // Atributos
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    // Constructor para inicializar los atributos
    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    // Método get para obtener el valor de servername
    public function getServername() {
        return $this->servername;
    }

    // Método set para cambiar el valor de servername
    public function setServername($servername) {
        $this->servername = $servername;
    }

    // Método get para obtener el valor de username
    public function getUsername() {
        return $this->username;
    }

    // Método set para cambiar el valor de username
    public function setUsername($username) {
        $this->username = $username;
    }

    // Método get para obtener el valor de password
    public function getPassword() {
        return $this->password;
    }

    // Método set para cambiar el valor de password
    public function setPassword($password) {
        $this->password = $password;
    }

    // Método get para obtener el valor de dbname
    public function getDbname() {
        return $this->dbname;
    }

    // Método set para cambiar el valor de dbname
    public function setDbname($dbname) {
        $this->dbname = $dbname;
    }

    // Método para conectar a la base de datos
    public function conectar() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->servername . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }

    // Método para desconectar de la base de datos
    public function desconectar() {
        $this->conn = null;
    }
}
?>