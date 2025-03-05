<?php
class cliente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($data) {
        $sql = "INSERT INTO clientes (
            no_cliente, 
            nom_completo, 
            telefono, 
            calle, 
            estado, 
            ciudad, 
            municipio, 
            pais, 
            colonia, 
            no_ext, 
            no_int, 
            requiere_factura
        ) VALUES (
            :no_cliente, 
            :nom_completo, 
            :telefono, 
            :calle, 
            :estado, 
            :ciudad, 
            :municipio, 
            :pais, 
            :colonia, 
            :no_ext, 
            :no_int, 
            :requiere_factura
        )";

        // Generar número de cliente automático
        $data['no_cliente'] = 'CLI-' . str_pad($this->obtenerUltimoId() + 1, 3, '0', STR_PAD_LEFT);

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function obtenerClientes() {
        $sql = "SELECT id, no_cliente, nom_completo, telefono, estado, requiere_factura FROM clientes";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerUltimoId() {
        $stmt = $this->conn->query("SELECT MAX(id) FROM clientes");
        return $stmt->fetchColumn();
    }
}
?>