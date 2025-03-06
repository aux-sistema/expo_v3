<div class="row g-4"> 
    <!-- Datos Personales -->
    <div class="col-md-4">
        <input type="text" name="no_cliente" class="form-control" placeholder="Número de Cliente (ej: cli 43)" 
               value="<?php echo $cliente['no_cliente'] ?? ''; ?>" required>
    </div>
    <div class="col-md-6">
        <input type="text" name="nom_completo" class="form-control" placeholder="Nombre completo" 
               value="<?php echo $cliente['nom_completo'] ?? ''; ?>" required>
    </div>
    <div class="col-md-4">
        <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" 
               value="<?php echo $cliente['telefono'] ?? ''; ?>" required>
    </div>
    
    <div class="col-md-5">
        <input type="text" name="calle" class="form-control" placeholder="Calle" 
               value="<?php echo $cliente['calle'] ?? ''; ?>" required>
    </div>
    <div class="col-md-3">
        <input type="text" name="no_ext" class="form-control" placeholder="No. Exterior" 
               value="<?php echo $cliente['no_ext'] ?? ''; ?>" required>
    </div>
    <div class="col-md-3">
        <input type="text" name="no_int" class="form-control" placeholder="No. Interior" 
               value="<?php echo $cliente['no_int'] ?? ''; ?>">
    </div>
    
    <div class="col-md-4">
        <input type="text" name="colonia" class="form-control" placeholder="Colonia" 
               value="<?php echo $cliente['colonia'] ?? ''; ?>" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="municipio" class="form-control" placeholder="Municipio" 
               value="<?php echo $cliente['municipio'] ?? ''; ?>" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" 
               value="<?php echo $cliente['ciudad'] ?? ''; ?>" required>
    </div>
    
    <div class="col-md-5">
        <input type="text" name="estado" class="form-control" placeholder="Estado" 
               value="<?php echo $cliente['estado'] ?? ''; ?>" required>
    </div>
    <div class="col-md-5">
        <input type="text" name="pais" class="form-control" placeholder="País" 
               value="<?php echo $cliente['pais'] ?? ''; ?>" required>
    </div>
    
    <!-- Switch para facturación -->
    <?php 
    // Si el cliente ya tenía registrada facturación, se marca el checkbox
    $requiereFactura = isset($cliente['requiere_factura']) && $cliente['requiere_factura'] ? true : false;
    ?>
    <div class="form-check form-switch mt-4">
        <input class="form-check-input" type="checkbox" id="facturaSwitch" name="requiere_factura" 
            <?php echo $requiereFactura ? 'checked' : ''; ?>>
        <label class="form-check-label" for="facturaSwitch">¿Requiere factura?</label>
    </div>

    <!-- Formulario de Facturación (se muestra si el cliente requiere factura) -->
    <div id="facturaForm" style="display: <?php echo $requiereFactura ? 'block' : 'none'; ?>;">
        <h5 class="mt-4">Datos de Facturación</h5>
        <div class="row g-4">
            <div class="col-md-6">
                <input type="text" name="razon_social" class="form-control" placeholder="Razón Social" 
                       value="<?php echo $facturacion['razon_social'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
                <input type="text" name="rfc" class="form-control" placeholder="RFC" 
                       value="<?php echo $facturacion['rfc'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
                <select name="regimen_fiscal" class="form-select">
                    <option value="">Seleccione Régimen Fiscal</option>
                    <option value="Régimen General" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen General') ? 'selected' : ''; ?>>Régimen General</option>
                    <option value="Régimen Simplificado" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen Simplificado') ? 'selected' : ''; ?>>Régimen Simplificado</option>
                    <option value="Régimen de Incorporación Fiscal" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen de Incorporación Fiscal') ? 'selected' : ''; ?>>Régimen de Incorporación Fiscal</option>
                </select>
            </div>
            <div class="col-md-6">
                <select name="uso_cfdi" class="form-select">
                    <option value="">Seleccione Uso de CFDI</option>
                    <option value="Gastos en general" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Gastos en general') ? 'selected' : ''; ?>>Gastos en general</option>
                    <option value="Adquisición de mercancías" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Adquisición de mercancías') ? 'selected' : ''; ?>>Adquisición de mercancías</option>
                    <option value="Servicios profesionales" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Servicios profesionales') ? 'selected' : ''; ?>>Servicios profesionales</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal" 
                       value="<?php echo $facturacion['codigo_postal'] ?? ''; ?>">
            </div>
            <div class="col-md-6">
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" 
                       value="<?php echo $facturacion['correo'] ?? ''; ?>">
            </div>
        </div>
    </div>

    <!-- Switch para cliente nuevo -->
    <div class="form-check form-switch mt-4">
        <input class="form-check-input" type="checkbox" id="clienteNuevoSwitch" name="es_cliente_nuevo" 
            <?php echo (isset($facturacion['es_cliente_nuevo']) && $facturacion['es_cliente_nuevo']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="clienteNuevoSwitch">¿Es Cliente nuevo?</label>
    </div>

    <!-- Lista desplegable para "¿Cómo nos conoció?" (oculta por defecto si no hay dato) -->
    <div id="comoNosConocio" style="display: <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] != '') ? 'block' : 'none'; ?>;">
        <div class="col-md-6 mt-4">
            <select class="form-select" name="como_nos_conocio">
                <option value="">¿Cómo nos conoció?</option>
                <option value="Recomendación" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Recomendación') ? 'selected' : ''; ?>>Recomendación</option>
                <option value="Redes Sociales" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Redes Sociales') ? 'selected' : ''; ?>>Redes Sociales</option>
                <option value="Publicidad" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Publicidad') ? 'selected' : ''; ?>>Publicidad</option>
                <option value="Otro" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
        </div>
    </div>
</div>
