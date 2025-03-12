<?php
class Envio {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addEnvio($data) {
        $sql = "INSERT INTO envio (id_papeleta, direccion_envio) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['id_papeleta'],
            $data['direccion_envio']
        ]);
    }
}
?>
