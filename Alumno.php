<?php
require_once("conexion.php");

class Alumno {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function alta($nombre, $carrera, $edad) {
        $this->conexion->abrirConexion();
        $sentencia = $this->conexion->prepare("INSERT INTO alumnos (nombre, carrera, edad) VALUES (?, ?, ?)");
        $sentencia->bind_param("ssi", $nombre, $carrera, $edad);
        $sentencia->execute();
        $this->conexion->cerrarConexion();
    }

    public function eliminar($id) {
        $this->conexion->abrirConexion();
        $sentencia = $this->conexion->prepare("DELETE FROM alumnos WHERE id = ?");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $this->conexion->cerrarConexion();
    }

    public function obtenerAlumnos() {
        $this->conexion->abrirConexion();
        $resultado = $this->conexion->prepare("SELECT id, nombre, carrera, edad FROM alumnos");
        $resultado->execute();
        $resultado = $resultado->get_result();
        $alumnos = $resultado->fetch_all(MYSQLI_ASSOC);
        $this->conexion->cerrarConexion();
        return $alumnos;
    }
}
?>
