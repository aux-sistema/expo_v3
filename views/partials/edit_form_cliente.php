<div class="row g-4">
    <!-- Datos Personales -->
    <div class="col-md-4 form-floating">
        <input type="text" name="no_cliente" class="form-control" 
               id="noCliente" placeholder="Número de Cliente (ej: cli 43)" 
               value="<?php echo $cliente['no_cliente'] ?? ''; ?>" required>
        <label for="noCliente">Número de Cliente</label>
    </div>

    <div class="col-md-6 form-floating">
        <input type="text" name="nom_completo" class="form-control" 
               id="nomCompleto" placeholder="Nombre completo" 
               value="<?php echo $cliente['nom_completo'] ?? ''; ?>" required>
        <label for="nomCompleto">Nombre Completo</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="tel" name="telefono" class="form-control" 
               id="telefono" placeholder="Teléfono" 
               value="<?php echo $cliente['telefono'] ?? ''; ?>" required>
        <label for="telefono">Teléfono</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="calle" class="form-control" 
               id="calle" placeholder="Calle" 
               value="<?php echo $cliente['calle'] ?? ''; ?>" required>
        <label for="calle">Calle</label>
    </div>

    <div class="col-md-3 form-floating">
        <input type="text" name="no_ext" class="form-control" 
               id="noExt" placeholder="No. Exterior" 
               value="<?php echo $cliente['no_ext'] ?? ''; ?>" required>
        <label for="noExt">No. Exterior</label>
    </div>

    <div class="col-md-3 form-floating">
        <input type="text" name="no_int" class="form-control" 
               id="noInt" placeholder="No. Interior" 
               value="<?php echo $cliente['no_int'] ?? ''; ?>">
        <label for="noInt">No. Interior</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="text" name="colonia" class="form-control" 
               id="colonia" placeholder="Colonia" 
               value="<?php echo $cliente['colonia'] ?? ''; ?>" required>
        <label for="colonia">Colonia</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="text" name="municipio" class="form-control" 
               id="municipio" placeholder="Municipio" 
               value="<?php echo $cliente['municipio'] ?? ''; ?>" required>
        <label for="municipio">Municipio</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="text" name="ciudad" class="form-control" 
               id="ciudad" placeholder="Ciudad" 
               value="<?php echo $cliente['ciudad'] ?? ''; ?>" required>
        <label for="ciudad">Ciudad</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="estado" class="form-control" 
               id="estado" placeholder="Estado" 
               value="<?php echo $cliente['estado'] ?? ''; ?>" required>
        <label for="estado">Estado</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="pais" class="form-control" 
               id="pais" placeholder="País" 
               value="<?php echo $cliente['pais'] ?? ''; ?>" required>
        <label for="pais">País</label>
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
            <div class="col-md-6 form-floating">
                <input type="text" name="razon_social" class="form-control" 
                       id="razonSocial" placeholder="Razón Social" 
                       value="<?php echo $facturacion['razon_social'] ?? ''; ?>">
                <label for="razonSocial">Razón Social</label>
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" name="rfc" class="form-control" 
                       id="rfc" placeholder="RFC" 
                       value="<?php echo $facturacion['rfc'] ?? ''; ?>">
                <label for="rfc">RFC</label>
            </div>

            <div class="col-md-6 form-floating">
                <select name="regimen_fiscal" class="form-select" id="regimenFiscal">
                    <option value="">Seleccione Régimen Fiscal</option>
                    <option value="Régimen General" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen General') ? 'selected' : ''; ?>>Régimen General</option>
                    <option value="Régimen Simplificado" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen Simplificado') ? 'selected' : ''; ?>>Régimen Simplificado</option>
                    <option value="Régimen de Incorporación Fiscal" <?php echo (isset($facturacion['regimen_fiscal']) && $facturacion['regimen_fiscal'] == 'Régimen de Incorporación Fiscal') ? 'selected' : ''; ?>>Régimen de Incorporación Fiscal</option>
                </select>
                <label for="regimenFiscal">Régimen Fiscal</label>
            </div>

            <div class="col-md-6 form-floating">
                <select name="uso_cfdi" class="form-select" id="usoCFDI">
                    <option value="">Seleccione Uso de CFDI</option>
                    <option value="Gastos en general" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Gastos en general') ? 'selected' : ''; ?>>Gastos en general</option>
                    <option value="Adquisición de mercancías" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Adquisición de mercancías') ? 'selected' : ''; ?>>Adquisición de mercancías</option>
                    <option value="Servicios profesionales" <?php echo (isset($facturacion['uso_cfdi']) && $facturacion['uso_cfdi'] == 'Servicios profesionales') ? 'selected' : ''; ?>>Servicios profesionales</option>
                </select>
                <label for="usoCFDI">Uso de CFDI</label>
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" name="codigo_postal" class="form-control" 
                       id="codigoPostal" placeholder="Código Postal" 
                       value="<?php echo $facturacion['codigo_postal'] ?? ''; ?>">
                <label for="codigoPostal">Código Postal</label>
            </div>

            <div class="col-md-6 form-floating">
                <input type="email" name="correo" class="form-control" 
                       id="correo" placeholder="Correo electrónico" 
                       value="<?php echo $facturacion['correo'] ?? ''; ?>">
                <label for="correo">Correo electrónico</label>
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
        <div class="col-md-6 mt-4 form-floating">
            <select class="form-select" name="como_nos_conocio" id="comoNosConocioSelect">
                <option value="">¿Cómo nos conoció?</option>
                <option value="Recomendación" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Recomendación') ? 'selected' : ''; ?>>Recomendación</option>
                <option value="Redes Sociales" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Redes Sociales') ? 'selected' : ''; ?>>Redes Sociales</option>
                <option value="Publicidad" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Publicidad') ? 'selected' : ''; ?>>Publicidad</option>
                <option value="Otro" <?php echo (isset($facturacion['como_nos_conocio']) && $facturacion['como_nos_conocio'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
            </select>
            <label for="comoNosConocioSelect">¿Cómo nos conoció?</label>
        </div>
    </div>
</div>