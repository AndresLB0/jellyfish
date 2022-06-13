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
