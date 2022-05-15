document.addEventListener('DOMContentLoaded', function () {
  var instances = M.Parallax.init(document.querySelectorAll('.parallax'));
  //inicializa el modal
  var instances = M.Modal.init(document.querySelectorAll('.modal'));
  //inicializa el menu para moviles
  var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
  //inicializa las pstañas del modal
  var instances = M.Tabs.init(document.querySelectorAll('.tabs', {
    swipeable: true
  }));
  var instances = M.Carousel.init(document.querySelectorAll('.carousel'));
});
