document.addEventListener('DOMContentLoaded', function() {
    //inicializa el modal
     var instances = M.Modal.init(document.querySelectorAll('.modal'));
     //inicializa el menu para moviles
    var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
    //inicializa las pstañas del modal
  var instances = M.Tabs.init(document.querySelectorAll('.tabs',{
   swipeable:true
      }));
  });

document.getElementById('menu').innerHTML =
  '<nav>' +
  '<div class="nav-wrapper indigo darken-2" id="registro">' +
  '<div class="row">' +
  '<div class="col s2">' +
  '<a href="index.html" class=""><img src="../../recursos/img/logos/jellyfishlogob.png" height="64px" alt="" /></a>' +
  '</div>' +
  //adapta el slogan
  '<div class="col s8 m7 l6">' +
  '<img class="adaptable m l s" src="../../recursos/img/logos/lema.png" />' +
  '</div>' +
  '<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>' +
  '<ul class="hide-on-med-and-down right">' +
  //(a1)pone el texto de color claro
  '<li>' +
'<a class="grey-text text-lighten-3" href="about.html">sobre nosotros</a>'+
  '</li>' +
  //(a2) cambia el color de los iconos a blanco
  '<li>' +
  '<a href="#"><span class="material-icons md-light">add_shopping_cart</span></a>' +
  '</li>' +
  '<li>' +
  '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>' +
  '</li>' +
  '</ul>' +
  '</div>' +
  '</div>' +
  //popup de registro
  '<div id="modal1" class="modal indigo darken-2">' +
  '<div class="modal-content center-align">' +
  '<div class="row">' +
  //pestañas
  '<ul id="tabs-swipe-demo" class="tabs indigo darken-2">' +
  '<li class="tab col s3">' +
  '<a href="#test-swipe-1">registrarse</a>' +
  '</li>' +
  '<li class="tab col s3">' +
  '<a class="active" href="#test-swipe-2">iniciar sesion</a>' +
  '</li>' +
  '</ul>' +
  //registro
  '<div id="test-swipe-1" class="col s12 indigo darken-2">' +
  '<iframe src="../../plantilla/singup.html" class="noScrolling" sandbox="allow-forms" style="border:none;" seamless></iframe>'+
  '</div>' +
  //inicio de sesion
  '<div id="test-swipe-2" class="col s12 indigo darken-2">' +
 '<iframe src="../../plantilla/login.html" class="noScrolling" sandbox="allow-forms" style="border:none;" seamless></iframe>'+
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</nav>'

document.getElementById('mobile-demo').innerHTML =
  '<li><img src="../../recursos/img/logos/jellyfishanimated.gif" width="90%" /></li>' +
  //<!--(b1)hace lo mismo que a1 pero en version movil-->
  '<li>' +
  '<a class="grey-text text-lighten-3" href="index.html">inicio</a>'+
  '</li>' +
  '<li>' +
  '<a class="grey-text text-lighten-3" href="about.html">sobre nosotros</a>'+
  '</li>' +
  //<!--(b2) hace lo mismo que a2 pero en versiones moviles-->
  '<li>' +
  '<a href="#"><span class="material-icons md-light">add_shopping_cart</span></a>' +
  '</li>' +
  '<li>' +
  '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>' +
  '</li>'
document.getElementById('productos').innerHTML='<div class="col s12 m12 l6 x6 ">'+
'<div class="card horizontal">'+
  '<div class="card-image">'+
    '<img src="../../api/images/productos/RX570.jfif" width="70 px" height="200 px">'+
  '</div>'+
  '<div class="card-stacked">'+
    '<div class="card-content">'+
      '<h5>RTX 570</h5>'+
      '<h5>$200.00 </h5>'+
    '</div>'+
    '<div class="card-action">'+
      '<a href="#" class="blue-text">Mas detalles</a> <a href="#" class="blue-text">Añadir al carrito</a> <a class="blue-text modal-trigger" href="#modalval">valorar producto</a>'+
    '</div>'+
  '</div>'+
'</div>'+
'</div>'
