let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id:'',
    nombre : '',
    fecha : '',
    hora : '',
    servicios : []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion(); //cambia la seccion cuando se presionen los tabs 
    tabs();  //muestra y oculta las secciones
    btnPaginador() //Agrega o quita los paginadores
    pagSiguiente();
    pagAnterior();

    consultarAPI();

    idCliente();
    nombreCliente();
    fechaCita();
    horaCita();

    mostrarResumen();
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');


    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            btnPaginador();

            if(paso === 3){
                mostrarResumen();
            }

        });
    });
}

function mostrarSeccion(){
    //ocultar la seccion
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    //mostrar seccion por el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);

    seccion.classList.add('mostrar');

    //quita la clase de actual anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function btnPaginador(){
    const pagAnterior = document.querySelector('#anterior');
    const pagSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        pagAnterior.classList.add('ocultar');
        pagSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        pagAnterior.classList.remove('ocultar')
        pagSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        pagAnterior.classList.remove('ocultar');
        pagSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();

}


function pagAnterior(){
    const pagAnterior = document.querySelector('#anterior');
    pagAnterior.addEventListener('click', function(){
        if(paso<=pasoInicial) return;{
            paso--;
        }
        btnPaginador();
    });
}


function pagSiguiente(){
    const pagSiguiente = document.querySelector('#siguiente');
    pagSiguiente.addEventListener('click', function(){
        if(paso>=pasoFinal) return;{
            paso++;
        }
        btnPaginador();
    });
}


function mostrarServicios(servicios){
    servicios.forEach( servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `${precio} €`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        servicioDiv.onclick = function (){
            seleccionarServicio(servicio);
        }

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

async function consultarAPI(){

    try {
        const url = 'https://git.heroku.com/mysterious-forest-16460.git/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicios = document.querySelector(`[data-id-servicio="${id}"]`);

    //comprobar si ya esta seleccionado
    if( servicios.some( agregado => agregado.id === id) ){
        //eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id != id);
        divServicios.classList.remove('seleccionado');
    }else{
        //agregarlo
        cita.servicios = [...servicios, servicio];
        divServicios.classList.add('seleccionado');
    }
}

function idCliente(){
    const id = document.querySelector('#id').value;
    cita.id = id;
}

function nombreCliente(){
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;
}

function fechaCita(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();

        if( [6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos', 'error', '.form');
        }else{
            cita.fecha = e.target.value;
        }

    });
}


function horaCita(){
    const inputHora = document.querySelector('#hora');

    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];

        if(hora<10 || hora>20){
            e.target.value = '';
            mostrarAlerta('El horario es de 10:00 a 20:00', 'error', '.form');
        }else{
            cita.hora = e.target.value;
        }
    });
}

function mostrarAlerta(msj, tipo, elemento, desaparece=true){

    const existeAlerta = document.querySelector('.alerta');
    if(existeAlerta) {
        existeAlerta.remove();
    };

    const alerta = document.createElement('DIV');
    alerta.textContent = msj;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        setTimeout(()=> {
            alerta.remove();
        }, 3000);
    }

}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //alertas
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if( cita.fecha=='' || cita.hora=='' || cita.servicios.length === 0){
        mostrarAlerta('Faltan seleccionar servicios, la fecha u hora de la cita', 'error', '.contenido-resumen', false);
        return;
    }

    const { nombre, fecha, hora, servicios } = cita;

    //header del resumen
    const headerServicios = document.createElement('H3');
    headerServicios.textContent = 'Resumen Servicios';
    resumen.appendChild(headerServicios);

    //mostrando los servicios
    servicios.forEach(servicio => {

        const {id, precio, nombre} = servicio;


        const contServicios = document.createElement('DIV');
        contServicios.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> ${precio}€`;



        contServicios.appendChild(nombreServicio);
        contServicios.appendChild(precioServicio);

        resumen.appendChild(contServicios);


    });

    //header del perfil
    const headerCita = document.createElement('H3');
    headerCita.classList.add('headerCita');

    headerCita.textContent = 'Resumen Cita';
    resumen.appendChild(headerCita);

    const nameCliente = document.createElement('P');
    nameCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //formatear la fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const ano = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(ano,mes,dia));

    const opc = {weekday:'long', month:'long', year:'numeric', day:'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opc);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;


    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;


    //Botn para reservar cita
    const btnReservar = document.createElement('BUTTON');
    btnReservar.classList.add('btn-inicio');
    btnReservar.textContent = 'Reservar';
    btnReservar.onclick = reservarCita;


    resumen.appendChild(nameCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(btnReservar);
  }

async function reservarCita(){

    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id);

    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);


    try{
        //peticion a la api
        const url = 'https://git.heroku.com/mysterious-forest-16460.git/api/citas'

        const respuesta = await fetch(url, {
            method:'POST',
            body: datos
        });


        const resultado = await respuesta.json();
        console.log(resultado.resultado);


        if(resultado.resultado){
            Swal.fire({
                icon: 'success',
                title: 'Nueva cita creada',
                text: 'Tu cita se reservó correctamente',
                button: 'OK'
            }).then( ()=> {
                window.location.reload();  
            })
        }

    }catch(error){
        Swal.fire({
            icon: 'error',
            title: '¡Algo no salió como debía!',
            text: 'Intentalo de nuevo mas tarde',
            button: 'OK'
        })
    }


    //console.log([...datos]);

}