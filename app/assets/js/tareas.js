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

                <div class="btn-creartarea acciones">
                    <input type="submit" value="Añadir Tarea"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>

            </form>
        `;

        document.querySelector('body').appendChild(modal);
    }

})();