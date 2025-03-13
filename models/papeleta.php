<?php
// models/papeleta.php

class Papeleta {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Método para insertar una papeleta (ya existente)
    public function addPapeleta($data) {
        $sql = "INSERT INTO papeletas (id_cliente, folio_papeleta, metales, quien_atendio, tipo_entrega)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['cliente_id'],
            $data['folio_papeleta'],
            $data['metales'],
            $data['quien_atendio'],
            $data['tipo_entrega']
        ]);
    }
    
    // Método para obtener todas las papeletas con búsqueda y orden
    public function getAll($search = '', $order = 'DESC') {
        $sql = "SELECT p.*, c.nom_completo 
                FROM papeletas p 
                JOIN clientes c ON p.id_cliente = c.id 
                WHERE 1=1";
        if (!empty($search)) {
            $sql .= " AND (p.folio_papeleta LIKE :search OR c.nom_completo LIKE :search OR p.metales LIKE :search)";
        }
        $sql .= " ORDER BY p.fecha_creacion $order";
        $stmt = $this->conn->prepare($sql);
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Método para obtener una papeleta por ID
    public function getById($id) {
        $sql = "SELECT * FROM papeletas WHERE id_papeleta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function countAsignacionesMesa($idMesa) {
        $sql = "SELECT COUNT(*) AS total FROM papeletas WHERE id_mesa = :id_mesa";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_mesa', $idMesa, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    // Método para actualizar la asignación de mesa en la papeleta
    public function updateMesa($idPapeleta, $idMesa) {
        $sql = "UPDATE papeletas SET id_mesa = :id_mesa WHERE id_papeleta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_mesa', $idMesa, PDO::PARAM_INT);
        $stmt->bindValue(':id', $idPapeleta, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
