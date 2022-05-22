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
  document.getElementById('pag1').innerHTML='<a class="grey-text text-lighten-3" href="index.html">inicio</a>'
document.getElementById('pag2').innerHTML='<a class="grey-text text-lighten-3" href="about.html">sobre nosotros</a>'
document.getElementById('mob1').innerHTML='<a class="grey-text text-lighten-3" href="index.html">inicio</a>'
document.getElementById('mob2').innerHTML='<a class="grey-text text-lighten-3" href="about.html">sobre nosotros</a>'
document.getElementById('login').innerHTML='<a class="waves-effect indigo btn" href="../privado/dashboard.html">iniciar secion</a>'

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
