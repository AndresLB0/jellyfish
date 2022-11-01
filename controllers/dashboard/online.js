/*
*   Controlador de uso general en las páginas web del sitio privado cuando se ha iniciado sesión.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para establecer la ruta y parámetros de comunicación con la API.
const API = SERVER + 'dashboard/usuarios.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    fetch(API + 'getUser', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            // Se obtiene la respuesta en formato JSON.
            request.json().then(function (response) {
                // Se revisa si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
                if (response.session) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se direcciona a la página web principal.
                    if (response.status) {
                        const header = `
                            <div class="navbar-fixed">
                                <nav class="indigo">
                                    <div class="nav-wrapper">
                                        <a href="main.html" class="brand-logo"><img src="${SERVER}images/logo.png" height="60"></a>
                                        <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                        <ul class="right hide-on-med-and-down">
                                        <li><a href="tipoproducto.html"><i class="material-icons left">shop_two</i>Tipos de productos</a></li>
                                            <li><a href="productos.html"><i class="material-icons left">shop</i>Productos</a></li>
                                            <li><a href="marca.html"><i class="material-icons left">store</i>Marcas</a></li>
                                            <li><a href="usuarios.html"><i class="material-icons left">group</i>Usuarios</a></li>
                                            <li>
                                                <a href="#" class="dropdown-trigger" data-target="desktop-dropdown">
                                                    <i class="material-icons left">verified_user</i>Cuenta: <b>${response.username}</b>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                                <ul id="desktop-dropdown" class="dropdown-content">
                                    <li><a href="profile.html"><i class="material-icons">face</i>Editar perfil</a></li>
                                    <li><a href="password.html"><i class="material-icons">lock</i>Cambiar clave</a></li>
                                    <li><a onclick="logOut()"><i class="material-icons">clear</i>Salir</a></li>
                                </ul>
                            </div>
                            <ul id="mobile-menu" class="sidenav indigo">
                            <li><img src="../../resources/img/jellyfishanimated.gif" width="90%" /></li>
                            <li><a href="tipoproducto.html"><i class="material-icons left">shop_two</i>Tipos de productos</a></li>
                                <li><a href="productos.html"><i class="material-icons">shop</i>Productos</a></li>
                                <li><a href="marca.html"><i class="material-icons">store</i>Marcas</a></li>
                                <li><a href="usuarios.html"><i class="material-icons">group</i>Usuarios</a></li>
                                <li>
                                    <a class="dropdown-trigger" href="#" data-target="mobile-dropdown">
                                        <i class="material-icons">verified_user</i>Cuenta: <b>${response.username}</b>
                                    </a>
                                </li>
                            </ul>
                            <ul id="mobile-dropdown" class="dropdown-content">
                                <li><a href="profile.html">Editar perfil</a></li>
                                <li><a href="password.html">Cambiar clave</a></li>
                                <li><a onclick="logOut()">Salir</a></li>
                            </ul>
                        `;
                        const footer = `
                        <div class="container">
                        <div class="row">
                        <div class="col s12">
                            <div class="center">
                                <h5 class="white-text">Contacto</h5>
                                <ul>
                                    <a href="mailto:jellyfish@info.com"><span class="material-icons md-light">email</span></a>
                                    <a href="tel:+50374686573"><span class="material-icons md-light">call</span></a>
                                    </ul>
                                </div>
                        </div>
                    </div>
                            </div>
                        `;
                        document.querySelector('header').innerHTML = header;
                        document.querySelector('footer').innerHTML = footer;
                        // Se inicializa el componente Dropdown para que funcione la lista desplegable en los menús.
                        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
                        // Se inicializa el componente Sidenav para que funcione la navegación lateral.
                        M.Sidenav.init(document.querySelectorAll('.sidenav'));
                    } else {
                        sweetAlert(3, response.exception, 'index.html');
                    }
                } else {
                    location.href = 'index.html';
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
});
var timer, currSeconds = 0;
//esta funcion tiene un cronometro
function resetTimer() {
    clearInterval(timer);
    currSeconds = 0;
    timer =
        setInterval(startIdleTimer, 1000);


}

//cada vez que la pagina detecta acciones,el cronometro se reinicia
window.onload = resetTimer;
window.onmousemove = resetTimer;
window.onmousedown = resetTimer;
window.ontouchstart = resetTimer;
window.onclick = resetTimer;
window.onkeypress = resetTimer;
/* cuando este "cronometro" llega a 300s(5 min) se cierra sesion de forma
automatica*/
function startIdleTimer() {

    /* Increment the
        timer seconds */
    currSeconds++;

    if (currSeconds ==300) {
        fetch(API + 'logOut', {
            method: 'get'
        }).then(function (request) {
            // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
            if (request.ok) {
                // Se obtiene la respuesta en formato JSON.
                request.json().then(function (response) {
                    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
                    if (response.status) {
                        sweetAlert(1, response.message, 'index.html');
                    } else {
                        sweetAlert(2, response.exception, null);
                    }
                });
            } else {
                console.log(request.status + ' ' + request.statusText);
            }
        });
    }
}