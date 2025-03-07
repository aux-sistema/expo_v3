<?php 
class Cliente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo cliente
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

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);

        // Devolver el id del cliente recién creado
        return $this->conn->lastInsertId();
    }

    // Actualizar un cliente
    public function actualizar($data) {
        $sql = "UPDATE clientes SET 
            no_cliente = :no_cliente, 
            nom_completo = :nom_completo, 
            telefono = :telefono, 
            calle = :calle, 
            estado = :estado, 
            ciudad = :ciudad, 
            municipio = :municipio, 
            pais = :pais, 
            colonia = :colonia, 
            no_ext = :no_ext, 
            no_int = :no_int, 
            requiere_factura = :requiere_factura
        WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Registrar facturación
    public function registrarFacturacion($data) {
        $sql = "INSERT INTO facturacion (
            cliente_id, 
            razon_social, 
            rfc, 
            regimen_fiscal, 
            uso_cfdi, 
            codigo_postal, 
            correo, 
            es_cliente_nuevo, 
            como_nos_conocio
        ) VALUES (
            :cliente_id, 
            :razon_social, 
            :rfc, 
            :regimen_fiscal, 
            :uso_cfdi, 
            :codigo_postal, 
            :correo, 
            :es_cliente_nuevo, 
            :como_nos_conocio
        )";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Actualizar facturación
    public function actualizarFacturacion($data) {
        $sql = "UPDATE facturacion SET 
            razon_social = :razon_social, 
            rfc = :rfc, 
            regimen_fiscal = :regimen_fiscal, 
            uso_cfdi = :uso_cfdi, 
            codigo_postal = :codigo_postal, 
            correo = :correo, 
            es_cliente_nuevo = :es_cliente_nuevo, 
            como_nos_conocio = :como_nos_conocio
        WHERE cliente_id = :cliente_id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Verificar si existe facturación para un cliente
    public function existeFacturacion($cliente_id) {
        $sql = "SELECT COUNT(*) FROM facturacion WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetchColumn() > 0;
    }

    // Obtener datos de un cliente por id
    public function obtenerPorId($cliente_id) {
        $sql = "SELECT * FROM clientes WHERE id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener datos de facturación por cliente_id
    public function obtenerFacturacion($cliente_id) {
        $sql = "SELECT * FROM facturacion WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerEnvio($cliente_id) {
        $sql = "SELECT * FROM facturacion WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Obtener todos los clientes
    public function obtenerClientes() {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar un cliente
    public function eliminar($cliente_id) {
        $sql = "DELETE FROM clientes WHERE id = :cliente_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':cliente_id' => $cliente_id]);
    }
}
?>
