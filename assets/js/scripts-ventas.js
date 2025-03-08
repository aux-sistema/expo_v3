$(document).ready(function () {
    // Configuración de la tabla de clientes
    const table = $('#clientesTable').DataTable({
        ajax: {
            url: BASE_PATH + '/admin/controller?action=obtenerClientes',
            dataSrc: 'data'
        },
        columns: [
            { data: 'no_cliente' },
            { data: 'nom_completo' },
            { data: 'telefono' },
            { data: 'estado' },
            {
                data: 'requiere_factura',
                render: function (data) {
                    return data == 1 ? 'Sí' : 'No';
                }
            },
            {
                data: 'id',
                render: function (data) {
                    return ` 
                        <a href="${BASE_PATH}/vendedor/add_papeleta?id=${data}" class="btn btn-sm" style="background-color:rgb(187, 93, 93); color: white;">Papeleta</a>`;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Filtros
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const facturaSwitch = document.getElementById('facturaSwitch');
    const facturaForm = document.getElementById('facturaForm');
    const clienteNuevoSwitch = document.getElementById('clienteNuevoSwitch');
    const comoNosConocio = document.getElementById('comoNosConocio');

    // Mostrar/Ocultar formulario de facturación
    if (facturaSwitch && facturaForm) {
        facturaSwitch.addEventListener('change', () => {
            facturaForm.style.display = facturaSwitch.checked ? 'block' : 'none';
        });
    }

    // Mostrar/Ocultar lista desplegable para "¿Cómo nos conoció?"
    if (clienteNuevoSwitch && comoNosConocio) {
        clienteNuevoSwitch.addEventListener('change', () => {
            comoNosConocio.style.display = clienteNuevoSwitch.checked ? 'block' : 'none';
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.form-floating input, .form-floating select');
    inputs.forEach(input => {
        if (input.value) {
            input.nextElementSibling.classList.add('floating');
        }

        input.addEventListener('input', function () {
            if (input.value) {
                input.nextElementSibling.classList.add('floating');
            } else {
                input.nextElementSibling.classList.remove('floating');
            }
        });
    });
});