<?php require_once __DIR__ . '/../header_vendedor.php'; ?>

<div class="container">
    <?php
    require_once __DIR__ . '/../../models/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $id_papeleta = $_GET['id_papeleta'];
    $stmt = $conn->prepare("SELECT * FROM papeletas WHERE id_papeleta = ?");
    $stmt->execute([$id_papeleta]);
    $papeleta = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <form action="<?php echo $base_path; ?>/vendedor/controller_envio.php" method="post">
        <!-- Enviar id_papeleta y cliente_id -->
        <input type="hidden" name="id_papeleta" value="<?php echo $id_papeleta; ?>">
        <input type="hidden" name="cliente_id" value="<?php echo $_GET['cliente_id']; ?>">
        
        <div class="row g-4 mt-3">
            <!-- Mostrar el número de papeleta en readonly -->
            <div class="col-md-6 form-floating">
                <input type="text" name="folio_papeleta" class="form-control" id="folioPapeleta"
                       value="<?php echo htmlspecialchars($papeleta['folio_papeleta']); ?>" readonly>
                <label for="folioPapeleta">Folio de la Papeleta</label>
            </div>
        </div>
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-custom">Guardar Envío</button>
            <a href="<?php echo $base_path; ?>/vendedor/view_vendedor" class="btn btn-custom"
               style="background: #ccc; color: #000; margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../footer_ventas.php'; ?>
