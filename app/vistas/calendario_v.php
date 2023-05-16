<style>
    .nav-link {
        background-color: #285e40 !important;
        color: white !important;
    }

    .active {
        background-color: white !important;
        color: #285e40 !important;
    }

    .filtros {
        background-color: #e5f2c9;
    }

    .pagination:hover {
        cursor: pointer;
    }
</style>
            <div class="contenedorListado row">
                <div class="listado col-9">
                    <div id="calendar" class="mt-3">
                        <!-- AQUÍ VA EL LISTADO DE TAREAS GENERADO CON JAVASCRIPT -->
                    </div>
                    <div id="paginacionCalendario">
                        <!-- AQUÍ VA EL LISTADO DE TAREAS GENERADO CON JAVASCRIPT -->
                    </div>
                </div>

                <div id="camposTareas" class="filtros col-3">

                    <h2 class="mt-1">Tarea</h2>
                    <form class=" justify-content-center" name="nuevaTarea" action="<?= BASE_URL; ?>Tareas_c/insertar" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombreCal" name="nombre" placeholder="nombre" >
                            <label for="nombre">nombre</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="descripcionCal"
                            style="height: 150px" 
                            name="descripcion" placeholder="descripcion" ></textarea>
                            <label for="descripcion">descripcion</label>
                        </div>

                        <div class="mb-2 text-start">
                            <label for="fechaCal" class="form-label">Fecha:</label>
                            <input type="date" class="form-control" id="fechaCal" name="fecha">
                        </div>

                        <input type="hidden" name="idTarea" id="idTarea" value="0">

                        <div id="botonesCal">
                        <button type="submit" class="btn mt-3 btnOscuro w-75">Nueva</button>
                        <button type="reset" class="btn mt-3 btnMedio w-75">Limpiar</button>
                        </form>
                        </div>

                    
                </div>
            </div>

           


