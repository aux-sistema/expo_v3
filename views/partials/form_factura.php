<div class="row g-4">
    <!-- Formulario de Facturación (oculto por defecto) -->
    <div id="facturaForm">
        <h5 class="mt-4">Datos de Facturación</h5>
        <div class="row g-4">
            <!-- Razón Social -->
            <div class="col-md-6">
                <label class="form-label">Razón Social</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['razon_social'] ?? 'No disponible'; ?>" readonly>
            </div>

            <!-- RFC -->
            <div class="col-md-6">
                <label class="form-label">RFC</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['rfc'] ?? 'No disponible'; ?>" readonly>
            </div>

            <!-- Régimen Fiscal -->
            <div class="col-md-6">
                <label class="form-label">Régimen Fiscal</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['regimen_fiscal'] ?? 'No disponible'; ?>" readonly>
            </div>

            <!-- Uso de CFDI -->
            <div class="col-md-6">
                <label class="form-label">Uso de CFDI</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['uso_cfdi'] ?? 'No disponible'; ?>" readonly>
            </div>

            <!-- Código Postal -->
            <div class="col-md-6">
                <label class="form-label">Código Postal</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['codigo_postal'] ?? 'No disponible'; ?>" readonly>
            </div>

            <!-- Correo Electrónico -->
            <div class="col-md-6">
                <label class="form-label">Correo Electrónico</label>
                <input type="text" class="form-control" value="<?php echo $facturacion['correo'] ?? 'No disponible'; ?>" readonly>
            </div>
        </div>
    </div>

    <!-- ¿Es Cliente Nuevo? -->
    

    <!-- ¿Cómo nos conoció? -->
    <div id="comoNosConocio">
        <div class="col-md-6 mt-4">
            <label class="form-label">¿Cómo nos conoció?</label>
            <input type="text" class="form-control" value="<?php echo $facturacion['como_nos_conocio'] ?? 'No disponible'; ?>" readonly>
        </div>
    </div>
</div>