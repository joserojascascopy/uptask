<?php include_once __DIR__ . '/../dashboard/header-dashboard.php'; ?>

<div class="container-sm">
    <div class="container-nueva-tarea">
        <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva tarea</button>
    </div>

    <div class="filtrar-tareas">
        <span>Filtrar:</span>
        <div class="form-group">
            <label for="todas">Todas</label>
            <input type="radio" id="todas" class="input-radio" name="filter" value="" checked>
        </div>
        <div class="form-group">
            <label for="pendientes">Pendientes</label>
            <input type="radio" id="pendientes" class="input-radio" name="filter" value="0">
        </div>
        <div class="form-group">
            <label for="completadas">Completadas</label>
            <input type="radio" id="completadas" class="input-radio" name="filter" value="1">
        </div>
</div>

    <ul class="listado-tareas" id="listado-tareas">

    </ul>
</div>

<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/tareas.js"></script>