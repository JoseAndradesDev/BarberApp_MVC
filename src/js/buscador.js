document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    buscarxfecha() ?? null;
}

function buscarxfecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
       const fechaSeleccionada = e.target.value;

       window.location = `?fecha=${fechaSeleccionada}`
    });
}





