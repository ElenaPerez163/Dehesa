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
                    <div id="listadoTareas" class="mt-5">
                        <!-- AQUÍ VA EL LISTADO DE TAREAS GENERADO CON JAVASCRIPT -->
                    </div>
                    <div id="paginacionTareas">
                        <!-- AQUÍ VA EL LISTADO DE TAREAS GENERADO CON JAVASCRIPT -->
                    </div>
                </div>

                <div id="filtrosTareas" class="filtros col-3">

                    <h2 class="mt-1">Filtros</h2>

                    <div class="form-floating mb-3">
                        <input type="search" class="form-control" id="nombre" name="nombre" placeholder="nombre" maxlength="14">
                        <label for="nombre">nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="search" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" maxlength="14">
                        <label for="descripcion">descripcion</label>
                    </div>


                    <div class="mb-2 text-start">
                        <label for="desde" class="form-label">Desde:</label>
                        <input type="date" class="form-control" id="desde" name="desde">
                    </div>

                    <div class="mb-2 text-start">
                        <label for="hasta" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="hasta" name="hasta">
                    </div>

                    <button data-bs-toggle="modal" data-bs-target="#tareasModal" type="button" id="btnNuevaTarea" class="btn mt-5 btnOscuro w-75">Nueva</button>

                </div>

            </div>

            <!-- Modal para alta y modificación de incidencias-->
            <div class="modal fade" id="tareasModal" tabindex="-1" aria-labelledby="Alta y modificación de tareas" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="labelModalTareas">Alta Tareas</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class=" justify-content-center" name="formTareas" action="<?= BASE_URL; ?>Tareas_c/insertar" method="post" enctype="multipart/form-data">

                                <div class="row mb-4 justify-content-right">
                                <label for="nombre" class="col-sm-2 col-form-label text-end">Nombre</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nombre" maxlength="60" required>
                                </div>

                                    <label for="fecha" class="col-sm-2 col-form-label text-end">fecha</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="fecha" required>
                                    </div>
                                </div>

                                <div class="row mb-4 mx-3 justify-content-start">
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="descripcion" placeholder="descripcion" rows="3" cols="40"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="idTarea" id="idTarea" value="0">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btnPeligro" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn  btnOscuro">Guardar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal detalles incidencias-->
            <div class="modal fade" id="detallesTarModal" tabindex="-1" aria-labelledby="detalles de tarea" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="detallesTarea">Detalles Tarea</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class=" row">
                                <div class="col-lg-12 conSombra text-start p-3">
                                    <h4 class="text-center">Detalles de la tarea</h4>

                                    <div id="tablaDetallesTarea"></div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


  
