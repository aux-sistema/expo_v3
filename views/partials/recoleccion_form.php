<?php require_once __DIR__ . '/../header_vendedor.php'; ?>
<div class="container">
    <h2>Agendar Cita para Recolección</h2>
    <?php
    if(isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="<?php echo $base_path; ?>/vendedor/recoleccion" method="post">
        <div class="mb-3">
            <label for="id_papeleta" class="form-label">ID Papeleta</label>
            <input type="text" class="form-control" id="id_papeleta" name="id_papeleta" required>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <select name="fecha" id="fecha" class="form-select" required>
                <?php foreach ($availableDates as $date): ?>
                    <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <select name="hora" id="hora" class="form-select" required>
                <?php for ($h = $horarioInicio; $h <= $horarioFin; $h++): ?>
                    <option value="<?php echo $h; ?>"><?php echo $h; ?>:00</option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Agendar Cita</button>
        <a href="<?php echo $base_path; ?>/vendedor/view_vendedor?id=<?php echo $cliente_id; ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once __DIR__ . '/../footer_ventas.php'; ?>
