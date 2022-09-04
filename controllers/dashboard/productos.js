// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_PRODUCTOS = SERVER + 'dashboard/productos.php?action=';
const ENDPOINT_MARCAS = SERVER + 'dashboard/marcas.php?action=readAll';
const ENDPOINT_TIPO = SERVER + 'dashboard/tipoproducto.php?action=readAll';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows(API_PRODUCTOS);
    // Se define una variable para establecer las opciones del componente Modal.
    let options = {
        dismissible: false,
        onOpenStart: function () {
            // Se restauran los elementos del formulario.
            document.getElementById('save-form').reset();
            // Se establece el valor mínimo para el precio del producto.
            document.getElementById('precio').setAttribute('min', 0.01);
            // Se establece el valor máximo para el precio del producto.
            document.getElementById('precio').setAttribute('max', 999.99);
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
        // Se establece un icono para el estado del producto.
        (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td><img src="${SERVER}images/productos/${row.imagen_producto}" class="materialboxed" height="100"></td>
                <td>${row.nombre_producto}</td>
                <td>${row.precio_producto}</td>
                <td>${row.tipo_producto}</td>
                <td>${row.nombre_marca}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>${row.existencias}</td>
                <td>
                    <a onclick="openUpdate(${row.id_producto})" class="btn-floating waves-effect blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <a onclick="openDelete(${row.id_producto})" class="btn-floating waves-effect red tooltipped" data-tooltip="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    document.getElementById('tbody-rows').innerHTML = content;
    // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
    // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de buscar.
document.getElementById('search-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows(API_PRODUCTOS, 'search-form');
});

// Función para preparar el formulario al momento de insertar un registro.
function openCreate() {
    // Se abre la caja de diálogo (modal) que contiene el formulario.
    M.Modal.getInstance(document.getElementById('save-modal')).open();
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Crear producto';
    // Se establece el campo de archivo como obligatorio.
    document.getElementById('archivo').required = true;
    // Se llama a la función que llena el select del formulario. Se encuentra en el archivo components.js
    fillSelect(ENDPOINT_MARCAS, 'marca', null);
    fillSelect(ENDPOINT_TIPO, 'tipoproducto', null);
}

// Función para abrir el reporte de productos.
function openReport() {
    // Se establece la ruta del reporte en el servidor.
    let url = SERVER + 'reports/dashboard/productos.php';
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(url);
}

// Función para preparar el formulario al momento de modificar un registro.
function openUpdate(id) {
    // Se abre la caja de diálogo (modal) que contiene el formulario.
    M.Modal.getInstance(document.getElementById('save-modal')).open();
    // Se asigna el título para la caja de diálogo (modal).
    document.getElementById('modal-title').textContent = 'Actualizar producto';
    // Se establece el campo de archivo como opcional.
    document.getElementById('archivo').required = false;
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    fetch(API_PRODUCTOS + 'readOne', {
        method: 'post',
        body: data
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                if (response.status) {
                    // Se inicializan los campos del formulario con los datos del registro seleccionado.
                    document.getElementById('id').value = response.dataset.id_producto;
                    document.getElementById('nombre').value = response.dataset.nombre_producto;
                    document.getElementById('precio').value = response.dataset.precio_producto;
                    document.getElementById('existencia').value = response.dataset.existencias;
                    document.getElementById('descripcion').value = response.dataset.descripcion_producto;
                    fillSelect(ENDPOINT_MARCAS, 'marca', response.dataset.id_marca);
                    fillSelect(ENDPOINT_TIPO, 'tipoproducto', response.dataset.idtipo_producto);
                    if (response.dataset.estado_producto) {
                        document.getElementById('estado').checked = true;
                    } else {
                        document.getElementById('estado').checked = false;
                    }
                    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
                    M.updateTextFields();
                } else {
                    sweetAlert(2, response.exception, null);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Método manejador de eventos que se ejecuta cuando se envía el formulario de guardar.
document.getElementById('save-form').addEventListener('submit', function (event) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se define una variable para establecer la acción a realizar en la API.
    let action = '';
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
    saveRow(API_PRODUCTOS, action, 'save-form', 'save-modal');
});

// Función para establecer el registro a eliminar y abrir una caja de diálogo de confirmación.
function openDelete(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const data = new FormData();
    data.append('id', id);
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete(API_PRODUCTOS, data);
}