$(document).ready(function () {
    // Configuración de la tabla de clientes
    const table = $('#clientesTable').DataTable({
        ajax: {
            url: '../../controllers/cliente_controller.php?action=obtenerClientes',
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
                    return `<a href="editar_cliente.php?id=${data}" class="btn btn-sm btn-warning">Editar</a>`;
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