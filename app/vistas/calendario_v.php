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

    .contGeneral{
        height: 90%;
    }
</style>
            <div class="contenedorListado row contGeneral">
                <div class="listado col-9 px-lg-5">
                    <div id="calendar" class="px-lg-5 pt-lg-2">
                        <!-- AQUÍ VA EL CALENDARIO GENERADO CON JAVASCRIPT -->
                    </div>
                </div>

                <div id="camposTareas" class="filtros col-3">

                    <h2 class="mt-1">Tarea</h2>
                    <form class=" justify-content-center" name="nuevaTarea" action="<?= BASE_URL; ?>Tareas_c/insertar" method="post" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombreCal" name="nombre" placeholder="nombre" required>
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
                            <input type="date" class="form-control" id="fechaCal" name="fecha" required>
                        </div>

                        <input type="hidden" name="idTarea" id="idTarea" value="0">

                        <div id="botonesCal">
                        <button type="submit" class="btn mt-3 btnOscuro w-75">Nueva</button>
                        <button class="btn mt-3 btnMedio w-75 btnLimpiar">Limpiar</button>
                        </form>
                        </div>

                    
                </div>
            </div>

           



