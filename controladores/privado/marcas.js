document.addEventListener('DOMContentLoaded', function() {
    //inicializa el modal
     var instances = M.Modal.init(document.querySelectorAll('.modal'));
     //inicializa el menu para moviles
    var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
    //inicializa las pstañas del modal
  var instances = M.Tabs.init(document.querySelector('.tabs',{
   swipeable:true,
      }));
  });
 

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
        '<li>'+
'<a class="grey-text text-lighten-3" href="agregarprod.html">productos</a>'+
        '</li>'+
        '<li>'+
'<a class="grey-text text-lighten-3" href="empleados.html">empleados</a>'+
        '</li>'+
        '<li>'+
'<a class="grey-text text-lighten-3" href="dashboard.html">dashboard</a>'+
        '</li>'+
        //(a2) cambia el color de los iconos a blanco
        '<li>'+
          '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>'+
        '</li>'+
      '</ul>'+
    '</div>'+
  '</div>'+
  //popup de modificar perfil y cerrar secion
  '<div id="modal1" class="modal indigo darken-2">'+
    '<div class="modal-content center-align">'+
      '<div class="row">'+
      '<h5>'+
      'modificar perfil'+
      '</h5>'+
        //modificar perfil
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

  document.getElementById('mobile-demo').innerHTML=
  '<li><img src="../../recursos/img/logos/jellyfishanimated.gif" width="90%" /></li>'+
  //<!--(b1)hace lo mismo que a1 pero en version movil-->
  '<li>'+
  '<a class="grey-text text-lighten-3" href="agregarprod.html">productos</a>'+
  '</li>'+
  '<li>'+
  '<a class="grey-text text-lighten-3" href="empleados.html">empleados</a>'+
  '</li>'+
  '<li>'+
  '<a class="grey-text text-lighten-3" href="dashboard.html">dashboard</a>'+
  '</li>'+
  //<!--(b2) hace lo mismo que a2 pero en versiones moviles-->
  '<li>'+
    '<a href="#"><span class="material-icons md-light">add_shopping_cart</span></a>'+
  '</li>'+
  '<li>'+
    '<a href="#modal1" class="modal-trigger"><span class="material-icons md-light">account_circle</span></a>'+
  '</li>'