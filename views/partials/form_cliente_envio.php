<div class="row g-4">
    <!-- Datos Personales -->
    <div class="col-md-4 form-floating">
        <input type="text" name="no_cliente" class="form-control" 
               id="noCliente" placeholder="Número de Cliente (ej: cli 43)" 
               value="<?php echo $cliente['no_cliente'] ?? ''; ?>" readonly>
        <label for="noCliente">Número de Cliente</label>
    </div>

    <div class="col-md-6 form-floating">
        <input type="text" name="nom_completo" class="form-control" 
               id="nomCompleto" placeholder="Nombre completo" 
               value="<?php echo $cliente['nom_completo'] ?? ''; ?>" readonly>
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

</div>  