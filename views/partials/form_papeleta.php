<?php require_once __DIR__ . '/../header_vendedor.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <!-- Formulario único para guardar toda la información -->
    <form action="<?php echo $base_path; ?>/vendedor/controller" method="post">
        <!-- ID del cliente (hidden) -->
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

        <!-- Datos generales de la papeleta -->
        <div class="row g-4 mt-3">
            <div class="col-md-6 form-floating">
                <input type="text" name="folio_papeleta" class="form-control" id="folioPapeleta"
                       placeholder="Folio de la Papeleta" required>
                <label for="folioPapeleta">Folio de la Papeleta</label>
            </div>
            <div class="col-md-6 form-floating">
                <select name="metales" class="form-select" id="metales" required>
                    <option value="">Tipo de Metal</option>
                    <option value="Oro">Oro</option>
                    <option value="Plata">Plata</option>
                    <option value="Otros">Otros</option>
                </select>
                <label for="metales">Tipo de Metal</label>
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" name="quien_atendio" class="form-control" id="quienAtendio"
                       placeholder="¿Quién atendió?" required>
                <label for="quienAtendio">¿Quién atendió?</label>
            </div>
        </div>

        <!-- Selección del tipo de entrega -->
        <div class="row mt-4">
            <div class="col-md-12">
                <p><strong>Escoge tu tipo de entrega:</strong></p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="radioEnvio" value="envio" required>
                    <label class="form-check-label" for="radioEnvio">Envío</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="radioRecoleccion" value="recoleccion" required>
                    <label class="form-check-label" for="radioRecoleccion">Recolección</label>
                </div>
            </div>
        </div>

        <!-- Bloque de datos para Envío (oculto por defecto) -->
        <div id="envioFields" style="display: none;">
            <hr>
            <h5>Datos para Envío</h5>
            <div class="row g-4 mt-3">
                <!-- Campo readonly para mostrar el folio de la papeleta -->
                <div class="col-md-6 form-floating">
                    <input type="text" name="folio_envio" class="form-control" id="folioEnvio"
                           placeholder="Folio de la Papeleta" readonly>
                    <label for="folioEnvio">Folio de la Papeleta</label>
                </div>
                <!-- Campo para la Dirección de Envío -->
                <div class="col-md-6 form-floating">
                    <input type="text" name="direccion_envio" class="form-control" id="direccionEnvio"
                           placeholder="Dirección de Envío">
                    <label for="direccionEnvio">Dirección de Envío</label>
                </div>
            </div>
        </div>

        <!-- Bloque de datos para Recolección (oculto por defecto) -->
        <div id="recoleccionFields" style="display: none;">
            <hr>
            <h5>Datos para Recolección</h5>
            <div class="row g-4 mt-3">
                <!-- Campo readonly para mostrar el folio de la Papeleta -->
                <div class="col-md-6 form-floating">
                    <input type="text" name="folio_recoleccion" class="form-control" id="folioRecoleccion"
                           placeholder="Folio de la Papeleta" readonly>
                    <label for="folioRecoleccion">Folio de la Papeleta</label>
                </div>
                <!-- Campo para Lugar de Recolección -->
                <div class="col-md-6 form-floating">
                    <input type="text" name="lugar_recoleccion" class="form-control" id="lugarRecoleccion"
                           placeholder="Lugar de Recolección">
                    <label for="lugarRecoleccion">Lugar de Recolección</label>
                </div>
            </div>
            <div class="row g-4 mt-3">
                <!-- Selector de fecha (limitado a los próximos 5 días) -->
                <div class="col-md-6 form-floating">
                    <input type="date" name="fecha_recoleccion" class="form-control" id="fechaRecoleccion" required>
                    <label for="fechaRecoleccion">Fecha de Recolección</label>
                </div>
                <!-- Selector de hora (entre 10:00 y 18:00) -->
                <div class="col-md-6 form-floating">
                    <select name="hora_recoleccion" class="form-select" id="horaRecoleccion" required>
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
                    <label for="horaRecoleccion">Hora de Recolección</label>
                </div>
            </div>
        </div>

        <!-- Botón para enviar el formulario completo -->
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-custom">Guardar Papeleta</button>
            <a href="<?php echo $base_path; ?>/vendedor/view_vendedor" class="btn btn-custom"
               style="background: #ccc; color: #000; margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>

<script>
// Referencias a los radio buttons y contenedores
const radioEnvio = document.getElementById('radioEnvio');
const radioRecoleccion = document.getElementById('radioRecoleccion');
const envioFields = document.getElementById('envioFields');
const recoleccionFields = document.getElementById('recoleccionFields');
const folioPapeletaInput = document.getElementById('folioPapeleta');
const folioEnvioInput = document.getElementById('folioEnvio');
const folioRecoleccionInput = document.getElementById('folioRecoleccion');

// Función para mostrar/ocultar bloques y copiar el folio
function toggleFields() {
    if (radioEnvio.checked) {
        envioFields.style.display = 'block';
        recoleccionFields.style.display = 'none';
        folioEnvioInput.value = folioPapeletaInput.value;
    } else if (radioRecoleccion.checked) {
        envioFields.style.display = 'none';
        recoleccionFields.style.display = 'block';
        folioRecoleccionInput.value = folioPapeletaInput.value;
    }
}

// Escuchar cambios en los radio buttons
radioEnvio.addEventListener('change', toggleFields);
radioRecoleccion.addEventListener('change', toggleFields);

// Actualizar el campo readonly de envío/recolección cuando cambie el folio
folioPapeletaInput.addEventListener('input', () => {
    if (radioEnvio.checked) {
        folioEnvioInput.value = folioPapeletaInput.value;
    } else if (radioRecoleccion.checked) {
        folioRecoleccionInput.value = folioPapeletaInput.value;
    }
});

// Limitar la fecha a los próximos 5 días
const fechaInput = document.getElementById('fechaRecoleccion');
const today = new Date();
const dd = String(today.getDate()).padStart(2, '0');
const mm = String(today.getMonth() + 1).padStart(2, '0');
const yyyy = today.getFullYear();
const minDate = `${yyyy}-${mm}-${dd}`;
fechaInput.min = minDate;
// Calcular el máximo: hoy + 5 días
let maxDateObj = new Date();
maxDateObj.setDate(today.getDate() + 5);
const ddMax = String(maxDateObj.getDate()).padStart(2, '0');
const mmMax = String(maxDateObj.getMonth() + 1).padStart(2, '0');
const yyyyMax = maxDateObj.getFullYear();
const maxDate = `${yyyyMax}-${mmMax}-${ddMax}`;
fechaInput.max = maxDate;
</script>

<?php require_once __DIR__ . '/../footer_ventas.php'; ?>
