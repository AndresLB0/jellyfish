/*
*   Controlador de uso general en las páginas web del sitio privado cuando no se ha iniciado sesión.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    const header = `
        <div class="navbar-fixed">
            <nav class="indigo">
                <div class="nav-wrapper center-align">
                    <a href="index.html" class="brand-logo"><i class="material-icons">lock</i></a>
                </div>
            </nav>
        </div>
    `;
    const footer = `
    <div class="container">
        <div class="center">
            <h5 class="white-text">¿Nescesitas ayuda?</h5>
            <ul>
                <a href="mailto:jellyfish@info.com"><span class="material-icons md-light">email</span></a>
                <a href="tel:+50374686573"><span class="material-icons md-light">call</span></a>
                </ul>
            </div>
</div>
    `;
    document.querySelector('header').innerHTML = header;
    document.querySelector('footer').innerHTML = footer;
});