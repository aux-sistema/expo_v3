<?php
class Envio {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Inserta un registro en la tabla envio
    public function addEnvio($data) {
        $sql = "INSERT INTO envio (id_papeleta, fecha_envio)
                VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['id_papeleta'],
            $data['fecha_envio']
        ]);
    }
}
?>
