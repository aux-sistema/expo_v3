<?php
// models/mesa.php

require_once 'database.php';

class Mesa {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getAll() {
        $sql = "SELECT * FROM mesas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($idMesa) {
        $sql = "SELECT * FROM mesas WHERE id_mesa = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $idMesa, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
