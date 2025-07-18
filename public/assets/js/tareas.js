// IIFE: immediately invoked function expression, or IIFE (pronounced iffy), is a function that is called immediately after it is defined.

(function () {
    let tareas = [];

    obtenerTareas();

    // Boton para mostrar el Modal de Agregar nueva tarea
    const nuevaTareaBtn = document.querySelector('.agregar-tarea');
    nuevaTareaBtn.addEventListener('click', () => { // ('click', mostrarFormulario) => de esta manera implicitamente el primer parametro que se le pasa a la funcion es el objeto de evento
        mostrarFormulario();
    });

    function mostrarFormulario(editar = false, tarea = {}) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea" method='POST'>
                <legend>${editar ? 'Editar Tarea' : 'Añadir una nueva tarea'}</legend>

                <div class="form-group">
                    <label for="tarea">Tarea</label>
                    <input type="text" id="tarea" name="tarea" placeholder="${tarea.nombre ? 'Editar la tarea' : 'Nombre de la tarea'}" value="${tarea.nombre ? tarea.nombre : ''}" />
                </div>

                <div class="opciones">
                    <input type="submit" class="submit-tarea" value="${editar ? 'Guardar cambios' : 'Añadir Tarea'}"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>

            </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        // Delegation JS
        modal.addEventListener('click', function (e) {
            e.preventDefault();
            // Cerrar el modal
            if (e.target.classList.contains('cerrar-modal') || e.target.classList.contains('modal')) {
                // document.querySelector('body').removeChild(modal);
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');

                setTimeout(() => {
                    modal.remove();
                }, 500);
            }

            // Verificar si le damos click al boton de añadir tarea
            if (e.target.classList.contains('submit-tarea')) {
                // Obtenemos el valor del input "Añadir Tarea"
                const nombreTarea = document.getElementById('tarea').value.trim();
                // Validamos el campo de añadir tarea, si esta vacio, mostramos la alerta
                if (nombreTarea === '') {
                    // Mostrar una alerta de error
                    mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));

                    return;
                }

                if (editar) {
                    // Reescribimos el nombre de la tarea del objeto global tarea por el nuevo nombre
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);

                    return;
                }

                agregarTarea(nombreTarea);
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }

    // Agregar la tarea al proyecto actual (Mandar los datos al servidor backend)
    async function agregarTarea(tarea) {
        // Construir la petición
        const datos = new FormData();

        // Obtenemos la url del query string
        const params = new URLSearchParams(window.location.search);
        const url = params.get('url');

        // const proyecto = Object.fromEntries(params.entries());
        // const url = proyecto.url;

        datos.append('nombre', tarea);
        datos.append('url', url);

        try {
            const apiUrl = 'http://localhost:3000/api/tarea';
            const res = await fetch(apiUrl, {
                method: 'POST',
                body: datos
            });

            const body = await res.json();

            if (!body.success) {
                mostrarAlerta(body.message, 'error', document.querySelector('.formulario legend'));

                return;
            }

            mostrarAlerta(body.message, 'exito', document.querySelector('.formulario legend'));

            // Agregar el objeto de tarea al global de tareas
            const tareaObject = {
                id: String(body.id),
                nombre: tarea,
                estado: '0',
                proyecto_id: body.proyecto_id
            }

            tareas = [...tareas, tareaObject];

            renderTareas();

            const modal = document.querySelector('.modal');

            setTimeout(() => {
                modal.remove();
            }, 5000);

        } catch (error) {
            console.log(error);
        }
    }

    // el argumento tarea de esta funcion es una copia de la tarea del objeto tareas, no debemos modificar el objeto original antes de realizar cualquier accion
    function cambiarEstadoTarea(tarea) {
        const nuevoEstado = tarea.estado === '1' ? '0' : '1';
        tarea.estado = nuevoEstado;

        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea) {
        const { id, nombre, estado, proyecto_id } = tarea;

        const params = new URLSearchParams(window.location.search);
        const url = params.get('url');

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyecto_id', proyecto_id);
        datos.append('url', url);

        try {
            const apiUrl = 'http://localhost:3000/api/tarea-actualizar';
            const res = await fetch(apiUrl, {
                method: 'POST',
                body: datos
            })

            const body = await res.json();

            if (body.success) {
                Swal.fire({
                    icon: "success",
                    title: "Se ha actualizado la tarea",
                    showConfirmButton: true,
                }).then((result) => {
                    if(result.isConfirmed) {
                        const modal = document.querySelector('.modal');

                        if(modal) {
                            modal.remove();
                        }
                    }
                });

                tareas = tareas.map(tareaMemoria => {
                    if (tareaMemoria.id === body.id) {
                        tareaMemoria.estado = body.estado;
                        tareaMemoria.nombre = body.nombre;
                    }

                    return tareaMemoria; // !Important el return, o sino retorna cada elemento del array como undefined
                });

                renderTareas();
            }

        } catch (error) {
            console.log(error);
        }
    }

    function confirmarEliminarTarea(tarea) {
        Swal.fire({
            title: "¿Quieres eliminar esta tarea?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);

                Swal.fire({
                    title: "Eliminado!",
                    text: "La tarea ha sido eliminada",
                    icon: "success"
                });
            }
        });
    }

    async function eliminarTarea(tarea) {
        const { id, nombre, estado, proyecto_id } = tarea;

        const params = new URLSearchParams(window.location.search);
        const url = params.get('url');

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyecto_id', proyecto_id);
        datos.append('url', url);

        try {
            const apiUrl = 'http://localhost:3000/api/tarea-eliminar';
            const res = await fetch(apiUrl, {
                method: 'POST',
                body: datos
            })

            const body = await res.json();

            if (body.success) {
                // mostrarAlerta(body.message, 'exito', document.querySelector('.container-nueva-tarea'));

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== body.id);
            }

            renderTareas();

        } catch (error) {
            console.log(error);
        }
    }

    // Muestra un mensaje en la vista
    function mostrarAlerta(mensaje, tipo, referencia) {
        // Eliminar la alerta previa
        const alertaPrevia = document.querySelector('.alerta');

        if (alertaPrevia) {
            alertaPrevia.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo)
        alerta.textContent = mensaje;

        // Buscamos el padre de "referencia", insertamos la "alerta" antes del siguinte hermano (nextElementSibling) de la referencia
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        // Eliminar alerta luego de los 4 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }

    // Obtener todas las tareas desde el backend
    async function obtenerTareas() {
        const params = new URLSearchParams(window.location.search);
        const url = params.get('url');

        try {
            const apiUrl = `http://localhost:3000/api/tareas?url=${url}`;
            const res = await fetch(apiUrl);
            const body = await res.json();

            tareas = body.tareas;

            renderTareas();

        } catch (error) {
            console.log(error);
        }
    }

    // Render de las tareas en el frontend
    function renderTareas() {
        // Limpiar las tareas anteriores
        limpiarTareas();

        const contenedorTareas = document.querySelector('#listado-tareas');

        if (tareas.length === 0) {
            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No tienes ninguna tarea para este proyecto';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);

            return;
        }

        const estados = {
            0: 'Pendiente',
            1: 'Completado'
        }

        tareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function () {
                mostrarFormulario(editar = true, { ...tarea });
            }

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.tareaEstado = tarea.estado;
            btnEstadoTarea.ondblclick = function () {
                cambiarEstadoTarea({ ...tarea });
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.tareaId = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';
            btnEliminarTarea.ondblclick = function () {
                confirmarEliminarTarea({ ...tarea });
            }


            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            contenedorTareas.appendChild(contenedorTarea);
        });
    }

    function limpiarTareas() {
        const tareaAnterior = document.querySelector('#listado-tareas');

        while (tareaAnterior.firstChild) {
            tareaAnterior.removeChild(tareaAnterior.firstChild);
        }
    }
})();

// Modelo de concurrencia y loop de eventos

// console.log('1');

// setTimeout(() => { // Pertenece al queue, primero se ejecuta los que pertenecen a stack (funciones)
//     console.log('2');
// }, 0);

// console.log('3');

// setTimeout(() => {
//     console.log('4');
// }, 40);

// console.log('5');