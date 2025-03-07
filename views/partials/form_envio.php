<div class="row g-4">
    <div class="col-md-6 form-floating">
        <input type="text" name="nom_completo" class="form-control" 
               id="nomCompleto" placeholder="Nombre completo" 
               value="<?php echo $cliente['nom_completo'] ?? ''; ?>" readonly>
        <label for="nomCompleto">Nombre Completo</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="tel" name="telefono" class="form-control" 
               id="telefono" placeholder="Teléfono" 
               value="<?php echo $cliente['telefono'] ?? ''; ?>" readonly>
        <label for="telefono">Teléfono</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="calle" class="form-control" 
               id="calle" placeholder="Calle" 
               value="<?php echo $cliente['calle'] ?? ''; ?>" readonly>
        <label for="calle">Calle</label>
    </div>

    <div class="col-md-3 form-floating">
        <input type="text" name="no_ext" class="form-control" 
               id="noExt" placeholder="No. Exterior" 
               value="<?php echo $cliente['no_ext'] ?? ''; ?>" readonly>
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
               value="<?php echo $cliente['colonia'] ?? ''; ?>" readonly>
        <label for="colonia">Colonia</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="text" name="municipio" class="form-control" 
               id="municipio" placeholder="Municipio" 
               value="<?php echo $cliente['municipio'] ?? ''; ?>" readonly>
        <label for="municipio">Municipio</label>
    </div>

    <div class="col-md-4 form-floating">
        <input type="text" name="ciudad" class="form-control" 
               id="ciudad" placeholder="Ciudad" 
               value="<?php echo $cliente['ciudad'] ?? ''; ?>" readonly>
        <label for="ciudad">Ciudad</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="estado" class="form-control" 
               id="estado" placeholder="Estado" 
               value="<?php echo $cliente['estado'] ?? ''; ?>" readonly>
        <label for="estado">Estado</label>
    </div>

    <div class="col-md-5 form-floating">
        <input type="text" name="pais" class="form-control" 
               id="pais" placeholder="País" 
               value="<?php echo $cliente['pais'] ?? ''; ?>" readonly>
        <label for="pais">País</label>
    </div>
</div>