$(document).ready(function () {
    // Configuración de la tabla de papeletas con DataTable
    const table = $('#papeletasTable').DataTable({
        ajax: {
            // Ajusta la URL a la ruta que devuelva los datos de las papeletas en formato JSON.
            url: BASE_PATH + '/vendedor/controller?action=obtenerPapeletas',
            dataSrc: 'data'
        },
        columns: [
            { data: 'folio_papeleta', title: 'Folio' },
            { data: 'nom_completo', title: 'Cliente' },
            { data: 'fecha_creacion', title: 'Fecha Creación' },
            {
                data: 'id_mesa',
                title: 'Mesa Asignada',
                defaultContent: 'No asignada',
                render: function(data) {
                    return data ? data : 'No asignada';
                }
            },
            {
                data: 'id_papeleta',
                title: 'Acciones',
                render: function (data) {
                    return `<a href="${BASE_PATH}/vendedor/papeleta/asignar_mesas?id=${data}" class="btn btn-primary btn-sm">
                                Asignar Mesa
                            </a>`;
                }
            }
        ],
        
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Filtros: búsqueda en vivo mientras escribes
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();
    });
});

// Si tienes otros listeners (por ejemplo, para formularios de facturación o campos flotantes),
// puedes agregarlos aquí o incluirlos en archivos separados según tu estructura.
document.addEventListener('DOMContentLoaded', () => {
    // Ejemplo: funcionalidad para inputs de formulario con labels flotantes
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
