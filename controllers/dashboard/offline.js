/*
*   Controlador de uso general en las páginas web del sitio privado cuando no se ha iniciado sesión.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    const header = `
        <div class="navbar-fixed">
            <nav class="indigo darken-2">
                <div class="nav-wrapper center-align">
                    <a href="index.html" class="brand-logo"><i class="material-icons">dashboard</i></a>
                </div>
            </nav>
        </div>
    `;
    const footer = `
    <div class="container">
    <div class="row">
        <div class="col l6 s12">
            <h5 class="white-text">contactanos</h5>
            <ul>
                <a href="mailto:jellyfish@info.com"><span class="material-icons md-light">email</span></a>
                <a href="tel:+50374686573"><span class="material-icons md-light">call</span></a>
                </ul>
            </div>
        <div class="col l4 offset-l2 s12">
            <h5 class="white-text">redes sociales</h5>
            <ul>
                <li>
                    <a class="grey-text text-lighten-3" href="https://www.instagram.com/" target="_blank"><img class="social" src="../../resources/img/social/instagram2.png" width="20 px" heigth="20px" />instagram</a>
                    </li>
                <li>
                    <a class="grey-text text-lighten-3" href="https://www.facebook.com/" target="_blank"><img class="social" src="../../resources/img/social/facebook2.png" width="20 px" heigth="20px" />facebook</a>
                    </li>
                <li>
                    <a class="grey-text text-lighten-3" href="https://api.whatsapp.com/send?phone=50374686573" target="_blank"><img class="social" src="../../resources/img/social/whatsapp2.png" width="20 px"heigth="20px" />whatsapp</a>
                </li>
                <li>
                    <a class="grey-text text-lighten-3" href="https://www.twitter.com/" target="_blank"><img class="social" src="../../resources/img/social/twitter2.png" width="20 px" heigth="20px" />twitter</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="footer-copyright">
    <div class="container white-text">
        &reg 2022 jellyfish hardware,todos los derechos reservados "tecnologia
        de calidad en un solo lugar" y el logo son marcas registras de
        jellyfish hardware &reg
    </div>
</div>
    `;
    document.querySelector('header').innerHTML = header;
    document.querySelector('footer').innerHTML = footer;
});