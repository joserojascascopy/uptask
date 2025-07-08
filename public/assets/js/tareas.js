// IIFE: immediately invoked function expression, or IIFE (pronounced iffy), is a function that is called immediately after it is defined.

(function () {
    // Boton para mostrar el Modal de Agregar nueva tarea
    const nuevaTareaBtn = document.querySelector('.agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea" method='POST'>
                <legend>Añadir una nueva tarea</legend>

                <div class="form-group">
                    <label for="tarea">Tarea</label>
                    <input type="text" id="tarea" name="tarea" placeholder="Nombre de la tarea"/>
                </div>

                <div class="opciones">
                    <input type="submit" class="submit-tarea" value="Añadir Tarea"/>
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
                submitFormNewTask();
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
    }

    function submitFormNewTask() {
        // Obtenemos el valor del input "Añadir Tarea"
        const tarea = document.getElementById('tarea').value.trim();
        // Validamos el campo de añadir tarea, si esta vacio, mostramos la alerta
        if(tarea === '') {
            // Mostrar una alerta de error
            mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
            
            return;
        }

        agregarTarea(tarea);
    }

    // Agregar la tarea al proyecto actual (Mandar los datos al servidor backend)
    function agregarTarea(tarea) {
        
    }

    // Muestra un mensaje en la vista
    function mostrarAlerta(mensaje, tipo, referencia) {
        // Eliminar la alerta previa
        const alertaPrevia = document.querySelector('.alerta');
        
        if(alertaPrevia) {
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
        }, 4000);
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