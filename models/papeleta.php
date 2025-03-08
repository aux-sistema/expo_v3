<?php
class Papeleta {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addPapeleta($data) {
        $sql = "INSERT INTO papeletas (id_cliente, folio_papeleta, metales, quien_atendio) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([
            $data['cliente_id'], 
            $data['folio_papeleta'], 
            $data['metales'], 
            $data['quien_atendio']
        ])) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>
