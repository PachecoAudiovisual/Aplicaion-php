document.addEventListener(
  "DOMContentLoaded", function(){
    iniciarapp()
  })

  function iniciarapp(){
    buscarPorFecha();
  }
   function buscarPorFecha(){
   const fechaInput = document.querySelector('#fecha');
   fechaInput.addEventListener('input', function(e){
    const fechaSeleccionada = e.target.value;

    window.location = `?fecha=${fechaSeleccionada}`;
   });
   }