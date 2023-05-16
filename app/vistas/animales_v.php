<style>
    .filtros {
        background-color: #e5f2c9;
    }

    .pagination:hover {
        cursor: pointer;
    }
</style>

<div class="contenedorListado m-none row">
    <div class="listado col-9">
        <div id="listadoAnimales" class="mt-5">
            <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
        </div>
        <div id="paginacionAnimales">
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
            <input type="search" class="form-control" id="crotalMadre" name="crotalMadre" placeholder="crotal madre">
            <label for="crotalMadre">crotal madre</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" id="raza" name="raza" aria-label="raza">
                <option class="active" value="">Todas</option>
                <?php foreach ($razas as $raza) : ?>
                    <option value="<?= $raza['idRaza'] ?>"><?= $raza['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <label for="raza">raza</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" id="finca" name="finca" aria-label="finca">
                <option class="active" value="">Todas</option>
                <?php foreach ($fincas as $finca) : ?>
                    <option value="<?= $finca['idGrupo'] ?>"><?= $finca['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <label for="finca">finca</label>
        </div>

        <div class="mb-2 text-start">
            <label for="desde" class="form-label">Desde:</label>
            <input type="date" class="form-control" id="desde" name="desde">
        </div>

        <div class="mb-2 text-start">
            <label for="hasta" class="form-label">Hasta:</label>
            <input type="date" class="form-control" id="hasta" name="hasta">
        </div>

        <button data-bs-toggle="modal" data-bs-target="#animalesModal" type="button" id="btnNuevoAnimal" class="btn mt-5 btnOscuro w-75">Nuevo</button>

    </div>

</div>

<!-- Modal para alta y modificación de animales-->
<div class="modal fade" id="animalesModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="modalAltaModAnimal">Alta Animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="justify-content-center" name="formAnimales" action="<?php echo BASE_URL; ?>Bovido_c/insertar" method="post" enctype="multipart/form-data">

                    <div class="row mb-3 justify-content-center">
                        <label for="crotal" class="col-sm-2 col-form-label text-end">Crotal</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="crotal" maxlength="14" required>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                Este crotal ya existe
                            </div>
                        </div>

                        <label for="crotalMadre" class="col-sm-2 col-form-label text-end">Crotal Madre</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="crotalMadre" maxlength="14" required>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="explotacionPertenencia" class="col-sm-2 col-form-label text-end">E. Pertenencia</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="explotacionPertenencia" maxlength="14" required>
                        </div>

                        <label for="explotacionNacimiento" class="col-sm-2 col-form-label text-end">E. Nacimiento</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="explotacionNacimiento" maxlength="14" required>
                        </div>
                    </div>

                    <div class="row mb-4 justify-content-center">
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label text-end">F. Nacimiento</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" name="fechaNacimiento" required>
                        </div>

                        <label for="raza" class="col-sm-2 col-form-label text-end">Raza</label>
                        <div class="col-sm-3">
                            <select class="form-select" name="raza">
                                <?php
                                foreach ($razas as $raza) :
                                ?>
                                    <option value="<?= $raza['idRaza']; ?>"><?= $raza['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                    </div>

                    <div class="row mb-4 justify-content-center">

                        <label for="sexo" class="col-sm-1 col-form-label text-end">Sexo</label>
                        <div class="col-sm-2">
                            <select class="form-select" name="sexo">
                                <option value="H">hembra</option>
                                <option value="M">macho</option>
                            </select>
                        </div>

                        <label for="idGrupo" class="col-sm-1 col-form-label text-end">Grupo</label>
                        <div class="col-sm-3">
                            <select class="form-select" name="idGrupo">
                                <?php
                                foreach ($grupos as $grupo) :
                                ?>
                                    <option value="<?= $grupo['idGrupo']; ?>"><?= $grupo['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <label for="tipo" class="col-sm-1 col-form-label text-end">Tipo</label>
                        <div class="col-sm-2">
                            <select class="form-select" name="tipo">
                                <?php
                                foreach ($tipos as $tipo) :
                                ?>
                                    <option value="<?= $tipo['idTipo']; ?>"><?= $tipo['nombreTipo']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3 justify-content-center">
                        <label for="parto" class="col-sm-1 col-check-label">Parto</label>
                        <div class="col-sm-1">
                            <input type="hidden" name="parto" value="0">
                            <input type="checkbox" class="form-check-input" id="parto" name="parto" value="1">
                        </div>

                        <label for="asistido" class="col-sm-1 col-check-label">Asistido</label>
                        <div class="col-sm-1">
                            <input type="hidden" name="asistido" value="0">
                            <input type="checkbox" class="form-check-input" id="animAsistido" name="asistido" value="1">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-10">
                            <textarea class="form-control" name="observaciones" placeholder="Observaciones" rows="4" cols="30"></textarea>
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btnPeligro" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn  btnOscuro">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal detalles animales-->
<div class="modal fade" id="detallesAnimalesModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4 fw-semibold" id="detallesAnimal">Detalles Animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class=" row">
                    <div class="col-lg-6 conSombra text-start p-3">
                        <h4 class="text-center mb-2">Detalles del Animal</h4>

                        <div id="tablaDetalles"></div>

                    </div>

                    <div class="col-lg-6 p-3">
                        <div class="row conSombra mb-2 mt-md-3">
                            <h4 class="text-center">Partos del Animal</h4>

                            <div id="detallesAnPar"></div>

                        </div>

                        <div class="row conSombra mt-3">
                            <h4>Incidencias del Animal</h4>
                            <div id="detallesAnInc"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>