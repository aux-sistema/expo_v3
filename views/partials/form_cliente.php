<div class="row g-4">
    <!-- Datos Personales -->
    <div class="col-md-6">
        <input type="text" name="nom_completo" class="form-control" placeholder="Nombre completo" required>
    </div>
    <div class="col-md-6">
        <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
    </div>
    
    <div class="col-md-4">
        <input type="text" name="calle" class="form-control" placeholder="Calle" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="no_ext" class="form-control" placeholder="No. Exterior" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="no_int" class="form-control" placeholder="No. Interior">
    </div>
    
    <div class="col-md-4">
        <input type="text" name="colonia" class="form-control" placeholder="Colonia" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="municipio" class="form-control" placeholder="Municipio" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" required>
    </div>
    
    <div class="col-md-6">
        <input type="text" name="estado" class="form-control" placeholder="Estado" required>
    </div>
    <div class="col-md-6">
        <input type="text" name="pais" class="form-control" placeholder="País" required>
    </div>
    
    <!-- Switch para facturación -->
    <div class="form-check form-switch mt-4">
        <input class="form-check-input" type="checkbox" id="facturaSwitch" name="requiere_factura">
        <label class="form-check-label" for="facturaSwitch">¿Requiere factura?</label>
    </div>

    <!-- Formulario de Facturación (oculto por defecto) -->
    <div id="facturaForm" style="display: none;">
        <h5 class="mt-4">Datos de Facturación</h5>
        <div class="row g-4">
            <div class="col-md-6">
                <input type="text" name="razon_social" class="form-control" placeholder="Razón Social">
            </div>
            <div class="col-md-6">
                <input type="text" name="rfc" class="form-control" placeholder="RFC">
            </div>
            <div class="col-md-6">
                <input type="text" name="regimen_fiscal" class="form-control" placeholder="Régimen Fiscal">
            </div>
            <div class="col-md-6">
                <input type="text" name="uso_cfdi" class="form-control" placeholder="Uso de CFDI">
            </div>
            <div class="col-md-6">
                <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal">
            </div>
            <div class="col-md-6">
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico">
            </div>
        </div>
    </div>

    <!-- Switch para cliente nuevo -->
    <div class="form-check form-switch mt-4">
        <input class="form-check-input" type="checkbox" id="clienteNuevoSwitch">
        <label class="form-check-label" for="clienteNuevoSwitch">¿Es Cliente nuevo?</label>
    </div>

    <!-- Lista desplegable para "¿Cómo nos conoció?" (oculta por defecto) -->
    <div id="comoNosConocio" style="display: none;">
        <div class="col-md-6 mt-4">
            <select class="form-select" name="como_nos_conocio">
                <option value="">¿Cómo nos conoció?</option>
                <option value="Recomendación">Recomendación</option>
                <option value="Redes Sociales">Redes Sociales</option>
                <option value="Publicidad">Publicidad</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
    </div>
</div>