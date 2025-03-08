<div class="row g-4">
    <h5 class="mt-4">Datos de Facturación</h5>
    <div class="row g-4">
        <!-- Razón Social -->
        <div class="col-md-6 form-floating">
            <input type="text" name="razon_social" class="form-control" id="razonSocial" placeholder="Razón Social"
                value="<?php echo $facturacion['razon_social'] ?? ''; ?>" readonly>
            <label for="razonSocial">Razón Social</label>
        </div>

        <!-- RFC -->
        <div class="col-md-6 form-floating">
            <input type="text" name="rfc" class="form-control" id="rfc" placeholder="RFC"
                value="<?php echo $facturacion['rfc'] ?? ''; ?>" readonly>
            <label for="rfc">RFC</label>
        </div>

        <!-- Régimen Fiscal -->
        <div class="col-md-6 form-floating">
            <select name="regimen_fiscal" class="form-select" id="regimenFiscal">
                <option value="">Seleccione Régimen Fiscal</option>
                <option value="Régimen General" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen General') ? 'selected' : ''; ?>>Régimen General</option>
                <option value="Régimen Simplificado" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen Simplificado') ? 'selected' : ''; ?>>Régimen Simplificado
                </option>
                <option value="Régimen de Incorporación Fiscal" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen de Incorporación Fiscal') ? 'selected' : ''; ?>>Régimen de
                    Incorporación Fiscal</option>
            </select>
            <label for="regimenFiscal">Régimen Fiscal</label>
        </div>

        <!-- Uso de CFDI -->
        <div class="col-md-6 form-floating">
            <select name="uso_cfdi" class="form-select" id="usoCFDI">
                <option value="">Seleccione Uso de CFDI</option>
                <option value="Gastos en general" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Gastos en general') ? 'selected' : ''; ?>>Gastos en general</option>
                <option value="Adquisición de mercancías" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Adquisición de mercancías') ? 'selected' : ''; ?>>Adquisición de
                    mercancías</option>
                <option value="Servicios profesionales" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Servicios profesionales') ? 'selected' : ''; ?>>Servicios profesionales
                </option>
            </select>
            <label for="usoCFDI">Uso de CFDI</label>
        </div>

        <!-- Código Postal -->
        <div class="col-md-6 form-floating">
            <input type="text" name="codigo_postal" class="form-control" id="codigoPostal" placeholder="Código Postal"
                value="<?php echo $facturacion['codigo_postal'] ?? ''; ?>" readonly>
            <label for="codigoPostal">Código Postal</label>
        </div>

        <!-- Correo Electrónico -->
        <div class="col-md-6 form-floating">
            <input type="email" name="correo" class="form-control" id="correo" placeholder="Correo electrónico"
                value="<?php echo $facturacion['correo'] ?? ''; ?>" readonly>
            <label for="correo">Correo electrónico</label>
        </div>
    </div>
</div>