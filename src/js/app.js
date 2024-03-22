let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id:'',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []

}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); //muestra y oculta secciones
    tabs(); //carga la sesion
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    idCliente();
    consultarAPI(); // consulta la api en php backend
    nombreCliente(); //llena el input de nombre con el valor
    seleccionarFecha(); // añade la fecha de la cita
    seleccionarHora();// añade la hora de la cita en el objeto
    mostrarResumen(); //resumen de la cita
}

function mostrarSeccion() {

    //ocultar las seccion que tenga la clase mostrar
    const seccionAnterior = document.querySelector('.mostrar')
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');



    const tabAnterior = document.querySelector('.actual')
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }


    //resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();

        });
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();

    } else if (paso === 2) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {

        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();


    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {

        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();


    });
}

async function consultarAPI() {

    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);


        console.log(resultado);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('p');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('p');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    //Identificar al elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio= "${id}"]`);

    // comprobar  si ya estaba seleccionado o no
    if (servicios.some(agregado => agregado.id === id)) {

        // eliminar si esta agregado
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');

    } else {

        // agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
  
}

function nombreCliente() {

    cita.nombre = document.querySelector('#nombre').value;
}
function  idCliente(){

    cita.id = document.querySelector('#id').value;
}


function seleccionarFecha() {
    const inputFecha = document.querySelector("#fecha");
    inputFecha.addEventListener("input", function (e) {
        const dia = new Date(e.target.value).getUTCDay();

        // NO PERMITIR FINES DE SEMANA.............................. FINES DE SEMANA
        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostratAlerta('Fines de semana no permitido', 'error', '.formulario');

        } else {
            cita.fecha = e.target.value;
        }
    })
}


function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener("input", function (e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if (hora < 12 || hora > 23) {
            e.target.value = "";
            mostratAlerta('Horario debe ser entre 12 y 23 horas', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    })

}


function mostratAlerta(mensaje, tipo, elemento, desaparece = true) {

    // no mostrar dos veces la alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        // tiempo parar que desaparezca la alerta
        setTimeout(() => {
            alerta.remove();
        }, 4000);

    }
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // limpiar contenido resumen
    resumen.innerHTML = '';
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);

    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostratAlerta('Faltan datos de servicios, fecha u hora', 'error', '.contenido-resumen', false);
        return;
    }

    const { nombre, fecha, hora, servicios } = cita;
    // formatear fecha al español 

    const nombreCliente = document.createElement('p');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();
 
    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);

    // formatear el div resumen

    const fechaCita = document.createElement('p');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('p');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;



    // heading para resumen

    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    //itinerarndo y mostrando servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span>$${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);


    })

    const headingDatos = document.createElement('H3');
    headingDatos.textContent = 'Resumen de Cita';
    resumen.appendChild(headingDatos);


    // boton para crear una cita 
    const botonReservar= document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent ='Reservar cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);

}


async function reservarCita(){
    const { nombre, fecha, hora, servicios,id} = cita;

    const idServicios = servicios.map(servicio => servicio.id)

    const datos = new FormData();
    
    datos.append  ('fecha', fecha);
    datos.append  ('hora', hora);
    datos.append  ('usuarioId', id);
    datos.append  ('servicios', idServicios);

    //console.log([...datos]);
    // peticion hacia ala api
    const url = `${location.origin}/api/citas`

    const respuesta = await fetch (url, {
        method: 'POST',
        body: datos
    });

    const resultado = await respuesta.json();
    console.log(resultado.resultado);

    if (resultado.resultado) {
        Swal.fire({
            title: "Cita creada!",
            text: "Tu cita fue creada correctamente!",
            icon: "success"
          }).then(()=> {
            window.location.reload();
          })
    }

}
