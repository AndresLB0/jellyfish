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
  
  document.getElementById('pag1').innerHTML='<a class="grey-text text-lighten-3" href="#">productos</a>'
document.getElementById('pag2').innerHTML='<a class="grey-text text-lighten-3" href="marcas.html">marcas</a>'
document.getElementById('mob1').innerHTML='<a class="grey-text text-lighten-3" href="productos.html">productos</a>'
document.getElementById('mob2').innerHTML='<a class="grey-text text-lighten-3" href="marcas.html">marcas</a>'
document.getElementById('pag3').innerHTML='<a class="grey-text text-lighten-3" href="dashboard.html">dashboard</a>'
document.getElementById('mob3').innerHTML='<a class="grey-text text-lighten-3" href="dashboard.html">dashboard</a>'
document.getElementById('login').innerHTML='<a class="waves-effect indigo btn" href="../publico/index.html">cerrar secion</a>'