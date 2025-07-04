// IIFE: immediately invoked function expression, or IIFE (pronounced iffy), is a function that is called immediately after it is defined.

(function() {
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
        modal.addEventListener('click', function(e) {
            e.preventDefault();
            
            if(e.target.classList.contains('cerrar-modal') || e.target.classList.contains('modal')) {
                // document.querySelector('body').removeChild(modal);
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');

                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
        });

        document.querySelector('body').appendChild(modal);
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