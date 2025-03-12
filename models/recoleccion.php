<?php
class recoleccion {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Inserta un registro de recolección en la tabla
    public function addRecoleccion($data) {
        $sql = "INSERT INTO recoleccion (id_papeleta, id_cita, fecha_recoleccion, hora_recoleccion, lugar_recoleccion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['id_papeleta'],       // Línea 1
            $data['id_cita'],           // Línea 2
            $data['fecha_recoleccion'], // Línea 3
            $data['hora_recoleccion'],  // Línea 4
            $data['lugar_recoleccion']  // Línea 5
        ]);
    }
}
?>
