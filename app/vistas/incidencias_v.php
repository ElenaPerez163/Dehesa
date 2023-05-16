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

<div id="centro" class="col-lg-10 text-center d-flex flex-column mt-1">
    <ul class="nav nav-tabs container-fluid" id="myTab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="incidencias" aria-selected="true">Incidencias</button>
        </li>
    </ul>

    <div class="tab-content container-fluid" id="myTabContent">
        <div class="tab-pane fade show active " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    
            <div class="contenedorListado m-none row">
                <div class="listado col-9">
                    <div id="listadoIncidencias" class="mt-5">
                        <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
                    </div>
                    <div id="paginacionIncidencias">
                        <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
                    </div>
                </div>

                <div id="filtrosAnimales" class="filtros col-3">

                    <h2 class="mt-1">Filtros</h2>

                    <div class="form-floating mb-3">
                        <input type="search" class="form-control" id="crotal" name="crotal" placeholder="crotal" maxlength="14">
                        <label for="crotal">crotal</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="idTipoInc" name="finca" aria-label="tipoInc">
                            <option class="active" value="">Todas</option>
                            <?php foreach ($tipos as $tipo) : ?>
                                <option value="<?= $tipo['idTipoInc'] ?>"><?= $tipo['nombreInc'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="idTipoInc">Tipo Incidencia</label>
                    </div>

                    <div class="mb-2 text-start">
                        <label for="desde" class="form-label">Desde:</label>
                        <input type="date" class="form-control" id="desde" name="desde">
                    </div>

                    <div class="mb-2 text-start">
                        <label for="hasta" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="hasta" name="hasta">
                    </div>

                    <button data-bs-toggle="modal" data-bs-target="#incidenciasModal" type="button" id="btnNuevoAnimal" class="btn mt-5 btnOscuro w-75">Nueva</button>

                </div>

            </div>

            <!-- Modal para alta y modificación de incidencias-->
            <div class="modal fade" id="incidenciasModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="labelModalIncidencias">Alta Incidencias</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class=" justify-content-center" name="formIncidencias" action="<?= BASE_URL; ?>Incidencias_c/insertar" method="post" enctype="multipart/form-data">

                                <div class="row mb-4 justify-content-right">
                                    <label for="crotal" class="col-sm-1 col-form-label text-end">Crotal</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" list="opcionesCrotales" name="crotal" id="crotal" placeholder="Buscar...">
                                        <datalist id="opcionesCrotales">
                                            <?php foreach ($crotales as $crotal) : ?>
                                                <option value="<?= $crotal['crotal'] ?>"></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            El animal debe existir en la explotación
                                        </div>
                                    </div>

                                    <label for="fechaIncidencia" class="col-sm-2 col-form-label text-end">F. Incidencia</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="fechaIncidencia" required>
                                    </div>
                                </div>


                                <div class="row mb-4 justify-content-start">
                                    <label for="tipo" class="col-sm-1 col-form-label text-end">Tipo</label>
                                    <div class="col-sm-3">
                                        <select class="form-select" id="idTipoInc" name="tipo" aria-label="tipoInc">
                                            <?php foreach ($tipos as $tipo) : ?>
                                                <option value="<?= $tipo['idTipoInc'] ?>"><?= $tipo['nombreInc'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-4 mx-3 justify-content-start">
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="descripcion" placeholder="descripcion" rows="3" cols="40"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="idIncidencia" id="idIncidencia" value="0">

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
            <div class="modal fade" id="detallesIncModal" tabindex="-1" aria-labelledby="detalles de incidencia" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="detallesIncidencia">Detalles Incidencia</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class=" row">
                                <div class="col-lg-6 conSombra text-start p-3">
                                    <h4 class="text-center">Detalles de la incidencia</h4>

                                    <div id="tablaDetallesIncidencia"></div>

                                </div>

                                <div class="col-lg-6 p-3">
                                    <h4>Otras incidencias del animal</h4>

                                    <div id="detallesOtrasIncidencias"></div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>

</div>
<script src="<?= BASE_URL ?>app/vistas/js/funciones.js"></script>
<script src="<?= BASE_URL ?>app/vistas/js/incidencias.js"></script>