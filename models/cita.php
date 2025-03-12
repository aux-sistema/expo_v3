<?php
class Cita {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCita($fecha, $hora) {
        $sql = "SELECT * FROM citas WHERE fecha = ? AND hora = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$fecha, $hora]);
        return $stmt->fetch();
    }

    public function createCita($fecha, $hora, $cupos = 5) {
        $sql = "INSERT INTO citas (fecha, hora, cupos) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$fecha, $hora, $cupos])) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function countRecolecciones($id_cita) {
        $sql = "SELECT COUNT(*) as total FROM recoleccion WHERE id_cita = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_cita]);
        $row = $stmt->fetch();
        return $row['total'];
    }
}
?>
