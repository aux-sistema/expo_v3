<?php
// Archivo parcial: recoleccion_form.php
?>
<hr>
<h5>Datos para Recolección</h5>
<div class="row g-4 mt-3">
    <!-- Campo readonly para mostrar el folio (opcional) -->
    <div class="col-md-6 form-floating">
        <input type="text" name="folio_recoleccion" class="form-control" id="folioRecoleccionExtra" placeholder="Folio de la Papeleta" readonly>
        <label for="folioRecoleccionExtra">Folio de la Papeleta</label>
    </div>
    <!-- Campo para Lugar de Recolección -->
    <div class="col-md-6 form-floating">
        <input type="text" name="lugar_recoleccion" class="form-control" id="lugarRecoleccion" placeholder="Lugar de Recolección" required>
        <label for="lugarRecoleccion">Lugar de Recolección</label>
    </div>
</div>
<div class="row g-4 mt-3">
    <!-- Selector de fecha (limitado a los próximos 5 días) -->
    <div class="col-md-6 form-floating">
        <input type="date" name="fecha_recoleccion" class="form-control" id="fechaRecoleccionExtra" required>
        <label for="fechaRecoleccionExtra">Fecha de Recolección</label>
    </div>
    <!-- Selector de hora (entre 10:00 y 18:00) -->
    <div class="col-md-6 form-floating">
        <select name="hora_recoleccion" class="form-select" id="horaRecoleccionExtra" required>
            <option value="">Seleccione la hora</option>
            <option value="10:00:00">10:00</option>
            <option value="11:00:00">11:00</option>
            <option value="12:00:00">12:00</option>
            <option value="13:00:00">13:00</option>
            <option value="14:00:00">14:00</option>
            <option value="15:00:00">15:00</option>
            <option value="16:00:00">16:00</option>
            <option value="17:00:00">17:00</option>
            <option value="18:00:00">18:00</option>
        </select>
        <label for="horaRecoleccionExtra">Hora de Recolección</label>
    </div>
</div>

<script>
    // Copia el valor del folio principal al campo readonly del formulario de recolección
    const mainFolio = document.getElementById('folioPapeleta');
    const extraFolio = document.getElementById('folioRecoleccionExtra');
    if(mainFolio && extraFolio) {
        extraFolio.value = mainFolio.value;
        mainFolio.addEventListener('input', function() {
            extraFolio.value = this.value;
        });
    }
    
    // Configurar el selector de fecha para limitarlo a los próximos 5 días
    const fechaExtra = document.getElementById('fechaRecoleccionExtra');
    const today = new Date();
    // Formatear la fecha actual en formato YYYY-MM-DD
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    const minDate = `${yyyy}-${mm}-${dd}`;
    fechaExtra.min = minDate;
    // Calcular el máximo: 5 días desde hoy
    let maxDateObj = new Date();
    maxDateObj.setDate(today.getDate() + 5);
    const ddMax = String(maxDateObj.getDate()).padStart(2, '0');
    const mmMax = String(maxDateObj.getMonth() + 1).padStart(2, '0');
    const yyyyMax = maxDateObj.getFullYear();
    const maxDate = `${yyyyMax}-${mmMax}-${ddMax}`;
    fechaExtra.max = maxDate;
</script>
