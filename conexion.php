<?php
class Conexion {
    private $host = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base = "agenda_promedios";
    private $puerto = 3307; // Añade el puerto
    protected $conexion;

    public function abrirConexion() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->base, $this->puerto);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }

    public function prepare($query) {
        return $this->conexion->prepare($query);
    }
}
?>

