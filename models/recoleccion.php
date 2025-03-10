<?php
class Recoleccion {
    private $conn;
    private $table = "recolecciones";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Inserta una nueva cita de recolección
    public function addCita($data) {
        $sql = "INSERT INTO " . $this->table . " (id_papeleta, fecha, hora, estado) VALUES (:id_papeleta, :fecha, :hora, :estado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_papeleta', $data['id_papeleta']);
        $stmt->bindParam(':fecha', $data['fecha']);
        $stmt->bindParam(':hora', $data['hora']);
        $stmt->bindParam(':estado', $data['estado']);
        return $stmt->execute();
    }

    // Retorna la cantidad de citas agendadas para una fecha y hora
    public function getCitasPorHora($fecha, $hora) {
        $sql = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE fecha = :fecha AND hora = :hora";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
