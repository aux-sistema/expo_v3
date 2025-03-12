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
            <!-- Sección para preguntar si se necesita factura -->
            <div class="col-md-6">
                <p><strong>¿Necesitarás factura?</strong></p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="necesita_factura" id="facturaSi" value="si"
                        required>
                    <label class="form-check-label" for="facturaSi">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="necesita_factura" id="facturaNo" value="no"
                        required>
                    <label class="form-check-label" for="facturaNo">No</label>
                </div>
            </div>
        </div>

        <!-- Selección del tipo de entrega -->
        <div class="row mt-4">
            <div class="col-md-12">
                <p><strong>Escoge tu tipo de entrega:</strong></p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="radioEnvio" value="envio"
                        required>
                    <label class="form-check-label" for="radioEnvio">Envío</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_entrega" id="radioRecoleccion"
                        value="recoleccion" required>
                    <label class="form-check-label" for="radioRecoleccion">Recolección</label>
                </div>
            </div>
        </div>

        <!-- Bloque de confirmación de envío (se muestra solo si se selecciona "envio") -->
        <div id="preguntaEnvio" style="display: none; margin-top: 20px;">
            <div class="alert alert-info">
                Te lo podríamos enviar a partir del <strong>1 de mayo</strong>. ¿Aceptas?
                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="btnAceptarEnvioConfirm">Sí, acepto</button>
                    <button type="button" class="btn btn-danger" id="btnRechazarEnvioConfirm">No, gracias</button>
                </div>
            </div>
        </div>

        <!-- Bloque de datos para Envío (se muestra cuando el usuario acepta la fecha de envío) -->
        <div id="envioFields" style="display: none;">
            <hr>
            <h5>Datos para Envío</h5>
            <!-- Input hidden para saber si se aceptó la fecha -->
            <input type="hidden" name="acepto_envio" id="acepto_envio" value="no">
            <!-- Botón para revisar datos de envío -->
            <div class="col-md-6 form-floating mt-3">
                <button type="button" class="btn btn-custom"
                    onclick="window.location.href='<?php echo $base_path; ?>/vendedor/edit?id=<?php echo $cliente['id']; ?>'">Revisar
                    Datos de Envío</button>
            </div>
            <div class="row g-6 mt-3">
                <!-- Campo readonly para mostrar el folio de la papeleta -->
                <div class="col-md-6 form-floating">
                    <input type="text" name="folio_envio" class="form-control" id="folioEnvio"
                        placeholder="Folio de la Papeleta" readonly>
                    <label for="folioEnvio">Folio de la Papeleta</label>
                </div>
                <!-- Campo para la Fecha de Envío (opcional) -->
                <div class="col-md-6 form-floating mt-3">
                    <input type="date" name="fecha_envio" class="form-control" id="fechaEnvio">
                    <label for="fechaEnvio">Fecha de Envío</label>
                </div>
            </div>
        </div>

        <!-- Bloque de datos para Recolección (se muestra solo si se selecciona "recoleccion") -->
        <div id="recoleccionFields" style="display: none;">
            <hr>
            <h5>Datos para Recolección</h5>
            <div class="row g-4 mt-3">
                <!-- Campo readonly para mostrar el folio de la papeleta -->
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
                    <input type="date" name="fecha_recoleccion" class="form-control" id="fechaRecoleccionField"
                        required>
                    <label for="fechaRecoleccionField">Fecha de Recolección</label>
                </div>
                <!-- Selector de hora (entre 10:00 y 18:00) -->
                <div class="col-md-6 form-floating">
                    <select name="hora_recoleccion" class="form-select" id="horaRecoleccionField" required>
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
                    <label for="horaRecoleccionField">Hora de Recolección</label>
                </div>
            </div>
        </div>

        <!-- Botón para enviar el formulario completo -->
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-custom">Guardar Papeleta</button>
            <a href="<?php echo $base_path; ?>/vendedor/view_vendedor?id=<?php echo $cliente['id']; ?>"
                class="btn btn-custom" style="background: #ccc; color: #000; margin-left: 10px;">Cancelar</a>
        </div>
    </form>
</div>

<script>
    // Referencias a los radio buttons y contenedores
    const radioEnvio = document.getElementById('radioEnvio');
    const radioRecoleccion = document.getElementById('radioRecoleccion');
    const preguntaEnvio = document.getElementById('preguntaEnvio');
    const envioFields = document.getElementById('envioFields');
    const recoleccionFields = document.getElementById('recoleccionFields');
    const folioPapeletaInput = document.getElementById('folioPapeleta');
    const folioEnvioInput = document.getElementById('folioEnvio');
    const folioRecoleccionInput = document.getElementById('folioRecoleccion');
    const aceptoEnvioInput = document.getElementById('acepto_envio');
    const btnAceptarEnvioConfirm = document.getElementById('btnAceptarEnvioConfirm');
    const btnRechazarEnvioConfirm = document.getElementById('btnRechazarEnvioConfirm');

    // Función para mostrar/ocultar bloques según la opción elegida y ajustar atributos "required" y "disabled"
    function toggleFields() {
        if (radioEnvio.checked) {
            // Mostrar la pregunta de envío y ocultar recolección
            preguntaEnvio.style.display = 'block';
            recoleccionFields.style.display = 'none';

            // Deshabilitar campos de recolección
            document.getElementById('fechaRecoleccionField').disabled = true;
            document.getElementById('horaRecoleccionField').disabled = true;
            document.getElementById('fechaRecoleccionField').removeAttribute('required');
            document.getElementById('horaRecoleccionField').removeAttribute('required');

            // Copiar el folio
            folioEnvioInput.value = folioPapeletaInput.value;
            aceptoEnvioInput.value = 'no';

        } else if (radioRecoleccion.checked) {
            // Ocultar el bloque de envío y la pregunta
            preguntaEnvio.style.display = 'none';
            envioFields.style.display = 'none';

            // Mostrar el bloque de recolección
            recoleccionFields.style.display = 'block';
            // Habilitar campos de recolección y agregar "required"
            document.getElementById('fechaRecoleccionField').disabled = false;
            document.getElementById('horaRecoleccionField').disabled = false;
            document.getElementById('fechaRecoleccionField').setAttribute('required', 'required');
            document.getElementById('horaRecoleccionField').setAttribute('required', 'required');
            folioRecoleccionInput.value = folioPapeletaInput.value;
        }
    }

    radioEnvio.addEventListener('change', toggleFields);
    radioRecoleccion.addEventListener('change', toggleFields);

    folioPapeletaInput.addEventListener('input', function () {
        if (radioEnvio.checked) {
            folioEnvioInput.value = folioPapeletaInput.value;
        }
        if (radioRecoleccion.checked) {
            folioRecoleccionInput.value = folioPapeletaInput.value;
        }
    });

    // Manejo de la confirmación de envío
    btnAceptarEnvioConfirm.addEventListener('click', function () {
        aceptoEnvioInput.value = 'si';
        preguntaEnvio.style.display = 'none';
        envioFields.style.display = 'block';
    });

    btnRechazarEnvioConfirm.addEventListener('click', function () {
        aceptoEnvioInput.value = 'no';
        preguntaEnvio.style.display = 'none';
        envioFields.style.display = 'none';
        radioEnvio.checked = false;
    });

    // Configurar el selector de fecha para envío con fecha mínima fija (1 de mayo)
    const fechaEnvioInput = document.getElementById('fechaEnvio');
    if (fechaEnvioInput) {
        fechaEnvioInput.min = "2025-05-01";
        fechaEnvioInput.max = "2025-05-31";
    }

    // Configurar el selector de fecha para recolección
    const fechaRecoleccionInput = document.getElementById('fechaRecoleccionField');
    if (fechaRecoleccionInput) {
        const today2 = new Date();
        const dd2 = String(today2.getDate()).padStart(2, '0');
        const mm2 = String(today2.getMonth() + 1).padStart(2, '0');
        const yyyy2 = today2.getFullYear();
        const minDate2 = `${yyyy2}-${mm2}-${dd2}`;
        fechaRecoleccionInput.min = minDate2;
        let maxDateObj2 = new Date();
        maxDateObj2.setDate(today2.getDate() + 5);
        const ddMax2 = String(maxDateObj2.getDate()).padStart(2, '0');
        const mmMax2 = String(maxDateObj2.getMonth() + 1).padStart(2, '0');
        const yyyyMax2 = maxDateObj2.getFullYear();
        const maxDate2 = `${yyyyMax2}-${mmMax2}-${ddMax2}`;
        fechaRecoleccionInput.max = maxDate2;
    }

    // Manejo inmediato de "¿Necesitarás factura?" para redirigir al instante y guardar datos en sessionStorage
    const facturaSi = document.getElementById('facturaSi');
    if (facturaSi) {
        facturaSi.addEventListener('change', function () {
            if (this.checked) {
                // Guardar datos del formulario en sessionStorage de forma segura
                const tipoEntregaEl = document.querySelector('input[name="tipo_entrega"]:checked');
                const formData = {
                    cliente_id: document.querySelector('input[name="cliente_id"]') ? document.querySelector('input[name="cliente_id"]').value : '',
                    nom_completo: document.querySelector('input[name="nom_completo"]') ? document.querySelector('input[name="nom_completo"]').value : '',
                    no_cliente: document.querySelector('input[name="no_cliente"]') ? document.querySelector('input[name="no_cliente"]').value : '',
                    folio_papeleta: document.querySelector('input[name="folio_papeleta"]') ? document.querySelector('input[name="folio_papeleta"]').value : '',
                    metales: document.querySelector('select[name="metales"]') ? document.querySelector('select[name="metales"]').value : '',
                    quien_atendio: document.querySelector('input[name="quien_atendio"]') ? document.querySelector('input[name="quien_atendio"]').value : '',
                    tipo_entrega: tipoEntregaEl ? tipoEntregaEl.value : '',
                    // Si hay datos en envío, opcionalmente guardarlos:
                    direccion_envio: document.querySelector('input[name="direccion_envio"]') ? document.querySelector('input[name="direccion_envio"]').value : '',
                    fecha_envio: document.querySelector('input[name="fecha_envio"]') ? document.querySelector('input[name="fecha_envio"]').value : '',
                    necesita_factura: "si"
                };
                sessionStorage.setItem('papeletaData', JSON.stringify(formData));
                // Redirige inmediatamente a la ruta de facturación
                window.location.href = "<?php echo $base_path; ?>/vendedor/edit?id=<?php echo $cliente['id']; ?>";
            }
        });
    }


    // Repoblar el formulario principal al cargar, si existen datos guardados en sessionStorage
    document.addEventListener("DOMContentLoaded", function () {
        const savedData = sessionStorage.getItem('papeletaData');
        if (savedData) {
            const data = JSON.parse(savedData);
            document.querySelector('input[name="cliente_id"]').value = data.cliente_id || '';
            document.querySelector('input[name="nom_completo"]').value = data.nom_completo || '';
            document.querySelector('input[name="no_cliente"]').value = data.no_cliente || '';
            document.querySelector('input[name="folio_papeleta"]').value = data.folio_papeleta || '';
            document.querySelector('select[name="metales"]').value = data.metales || '';
            document.querySelector('input[name="quien_atendio"]').value = data.quien_atendio || '';

            // Seleccionar el radio de tipo_entrega
            if (data.tipo_entrega === "envio") {
                document.getElementById('radioEnvio').checked = true;
                // Repoblar datos de envío (si existen)
                if (document.getElementById('direccionEnvio'))
                    document.getElementById('direccionEnvio').value = data.direccion_envio;
                if (document.getElementById('fechaEnvio'))
                    document.getElementById('fechaEnvio').value = data.fecha_envio;
            } else if (data.tipo_entrega === "recoleccion") {
                document.getElementById('radioRecoleccion').checked = true;
                // Puedes repoblar datos de recolección si fueran necesarios
            }
            // Seleccionar el radio de necesita_factura
            if (data.necesita_factura === "si") {
                document.getElementById('facturaSi').checked = true;
            } else {
                document.getElementById('facturaNo').checked = true;
            }
            // Una vez repoblados, limpiar los datos guardados
            sessionStorage.removeItem('papeletaData');
        }
    });
</script>

<?php require_once __DIR__ . '/../footer_ventas.php'; ?>