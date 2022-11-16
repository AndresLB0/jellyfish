// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_CLIENTES = SERVER + 'Dashboard/clientes.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_CLIENTES);
    // Se define una variable para establecer las opciones del componente Modal.
    let options = {
        dismissible: false,
        onOpenStart: function () {
            // Se restauran los elementos del formulario.
            document.getElementById('save-form').reset();
        }
    }
    // Se inicializa el componente Modal para que funcionen las cajas de diálogo.
    M.Modal.init(document.querySelectorAll('.modal'), options);
});

// Función para llenar la tabla con los datos de los registros. Se manda a llamar en la función readRows().
function fillTable(dataset) {
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.map(function (row) {
        (row.estado) ? check = 'checked' : check = '';
        (row.estado) ? valor = 1 : valor = 0;
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.apellido}</td>
                <td>${row.nombre}</td>
                <td>${row.correo}</td>
                <td>${row.usuario}</td>
                <td>
                <form id="cliente${row.id_cliente}">
                <input class="hide" type="number" id="id" name="id" value="${row.id_cliente}">
                <div class="switch">
                    <label>
                    <i class="material-icons">lock</i>
                        <input onclick="Status(${row.id_cliente})" type="checkbox" value="${valor}" name="estado" ${check}>
                        <span class="lever"></span>
                        <i class="material-icons">lock_open</i>
                    </label>
                </div>
                </form>
                </td>
            
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('search-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_CLIENTES, 'search-form');
});

// es para acrualizar el estado
function Status(id) {
   let cliente='cliente'+id
   document.getElementById('id').value
saveRow(API_CLIENTES,'changeStatus',cliente,null)
}