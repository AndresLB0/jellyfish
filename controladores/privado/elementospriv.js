document.getElementById('pie').innerHTML=' <div class="container">'+
'<div class="row">'+
  '<div class="col l6 s12">'+
    '<h5 class="white-text">contactanos</h5>'+
    '<ul>'+
      '<a href="mailto:jellyfish@info.com"><span class="material-icons md-light">email</span></a>'+
      '<a href="tel:+50374686573"><span class="material-icons md-light">call</span></a>'+
    '</ul>'+
  '</div>'+
  '<div class="col l4 offset-l2 s12">'+
    '<h5 class="white-text">redes sociales</h5>'+
    '<ul>'+
      '<li>'+
        '<a class="grey-text text-lighten-3" href="https://www.instagram.com/"><img class="social" src="../../recursos/img/social/instagram2.png" width="20 px" heigth="20px" />instagram</a>'+
      '</li>'+
      '<li>'+
        '<a class="grey-text text-lighten-3" href="https://www.facebook.com/"><img class="social" src="../../recursos/img/social/facebook2.png" width="20 px" heigth="20px" />facebook</a>'+
      '</li>'+
      '<li>'+
        '<a class="grey-text text-lighten-3" href="https://api.whatsapp.com/send?phone=+503 74686573"><img class="social" src="../../recursos/img/social/whatsapp2.png" width="20 px" heigth="20px" />whatsapp</a>'+
      '</li>'+
       '<li>'+
        '<a class="grey-text text-lighten-3" href="https://www.twitter.com/"><img class="social" src="../../recursos/img/social/twitter2.png" width="20 px" heigth="20px" />twitter</a>'+
      '</li>'+
    '</ul>'+
  '</div>'+
'</div>'+
'</div>'+
'<div class="footer-copyright">'+
'<div class="container">'+
  '&reg 2022 jellyfish hardware,todos los derechos reservados "tecnologia'+
  'de calidad en un solo lugar" y el logo son marcas registras de '+
  'jellyfish hardware &reg'+
'</div>'+
'</div>'

document.getElementById('menu').innerHTML=
'<nav>'+
'<div class="nav-wrapper indigo darken-2">'+
  '<div class="row">'+
    '<div class="col s2">'+
      '<a href="#!" class=""><img src="../../recursos/img/logos/jellyfishlogob.png" height="64px" alt="" /></a>'+
    '</div>'+
    //adapta el slogan
    '<div class="col s8 m7 l6">'+
      '<img class="adaptable m l s" src="../../recursos/img/logos/lema.png" />'+
    '</div>'+
    '<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>'+
    '<ul class="hide-on-med-and-down right">'+
      //(a1)pone el texto de color claro
      '<li id="pag1">'+
      '</li>'+
      '<li id="pag2">'+
      '</li>'+
      '<li id="pag3">'+
      '</li>'+
      //(a2) cambia el color de los iconos a blanco
      '<li>'+
        '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>'+
      '</li>'+
    '</ul>'+
  '</div>'+
'</div>'+
//popup de registro
'<div id="modal1" class="modal indigo darken-2">'+
  '<div class="modal-content center-align">'+
    '<div class="row">'+
    '<h5>'+
    'modificar perfil'+
    '</h5>'+
      //registro
        '<form class="col s12">'+
        '<div class="row">'+
        '<div class="input-field col s6">'+
          '<input placeholder="Jelly" id="nombre" type="text" class="validate" />'+
          '<label for="name">nombre</label>'+
        '</div>'+
        '<div class="input-field col s6">'+
          '<input placeholder="fish" id="apellido" type="text" class="validate" />'+
          '<label for="user">apellido</label>'+
        '</div>'+
      '</div>'+
      '<div class="row">'+
        '<div class="input-field col s6">'+
          '<input placeholder="••••••••••••••••••••" id="clave" type="password" class="validate" />'+
          '<label for="password">contraseña</label>'+
        '</div>'+
        '<div class="input-field col s6">'+
          '<input placeholder="Jelly_fish_by_2022" id="usuario" type="text" class="validate" />'+
          '<label for="user">usuario</label>'+
        '</div>'+
      '</div>'+
      '<div class="row">'+
        '<div class="input-field col s6">'+
          '<input placeholder="Jellyfish@info.com" id="email" type="email" class="validate" />'+
          '<label for="email">Email</label>'+
        '</div>'+
        '<div class="input-field col s6">'+
          '<input placeholder="78906554" id="tel" type="tel" class="validate" />'+
          '<label for="email"></label>'+
        '</div>'+
      '</div>'+
          '<a class="waves-effect indigo btn">modificar perfil</a>'+
          '<a class="waves-effect indigo btn" href="../publico/index.html">cerrar secion</a>'+
        '</form>'
      //inicio de sesion

  document.getElementById('mobile-demo').innerHTML=
  '<li><img src="../../recursos/img/logos/jellyfishanimated.gif" width="90%" /></li>'+
  //<!--(b1)hace lo mismo que a1 pero en version movil-->
  '<li id="mob1">'+
  '</li>'+
  '<li id="mob2">'+
  '</li>'+
  '<li id="mob3">'+
  '</li>'+
  //<!--(b2) hace lo mismo que a2 pero en versiones moviles-->
  '<li>'+
    '<a href="#"><span class="material-icons md-light">add_shopping_cart</span></a>'+
  '</li>'+
  '<li>'+
    '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>'+
  '</li>'