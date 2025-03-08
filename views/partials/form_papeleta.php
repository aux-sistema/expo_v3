<?php require_once __DIR__ . '/../header_vendedor.php'; ?>

<div class="container">
    <h2>Añadir Papeleta</h2>
    <form action="<?php echo $base_path; ?>/vendedor/controller" method="post">
        <!-- Enviar el id del cliente -->
        <input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">

        <!-- Datos del cliente (solo lectura) -->
        <div class="row g-4">
            <div class="col-md-6 form-floating">
                <input type="text" name="nom_completo" class="form-control" id="nomCompleto"
                    value="<?php echo $cliente['nom_completo'] ?? ''; ?>" readonly>
                <label for="nomCompleto">Nombre Completo</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="no_cliente" class="form-control" id="noCliente"
                    value="<?php echo $cliente['no_cliente'] ?? ''; ?>" readonly>
                <label for="noCliente">Número de Cliente</label>
            </div>
        </div>

        <!-- Campos para la papeleta -->
        <div class="row g-4 mt-3">
            <div class="col-md-6 form-floating">
                <input type="text" name="folio_papeleta" class="form-control" id="folioPapeleta"
                    placeholder="Folio de la papeleta" required>
                <label for="folioPapeleta">Folio de la Papeleta</label>
            </div>

            <div class="col-md-6 form-floating">
                <select name="metales" class="form-select" id="metales">
                    <option value="">Tipo de Metal</option>
                    <option value="Oro" <?php echo (isset($papeletas['metales']) && $papeletas['metales'] == 'Oro') ? 'selected' : ''; ?>>Oro</option>
                    <option value="Plata" <?php echo (isset($papeletas['metales']) && $papeletas['metales'] == 'Plata') ? 'selected' : ''; ?>>Plata</option>
                    <option value="Otros" <?php echo (isset($papeletas['metales']) && $papeletas['metales'] == 'Otros') ? 'selected' : ''; ?>>Otros</option>
                </select>

                <label for="metales">Tipo de Metal</label>
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" name="quien_atendio" class="form-control" id="quienAtendio"
                    placeholder="¿Quién atendió?" required>
                <label for="quienAtendio">¿Quién atendió?</label>
            </div>
        </div>

        <div class="text-center mt-5">
    <button type="submit" class="btn btn-custom">Guardar Cliente</button>
    <a href="<?php echo $base_path; ?>/vendedor/edit?id=<?php echo $cliente['id']; ?>" class="btn btn-custom" style="background: #ccc; color: #000; margin-left: 10px;">Factura</a>
</div>

    </form>
</div>