<div id="centro" class="col-lg-10  text-center align-items-center justify-content-center">

    <div class="row mt-1 justify-content-center " id="contenedor">
        <div class="col-lg-6">
            <ul class="nav nav-tabs container-fluid" id="myTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detParcelas" data-bs-toggle="tab" data-bs-target="#detParcelas-pane" type="button" role="tab" aria-controls="animales" aria-selected="true" data-grupo="<?= $_SESSION['grupo'] ?>"><?= $nombreFinca ?></button>
                </li>
            </ul>

            <div class=" tab-content container-fluid" id="myTabContent">
                <div class=" tab-pane fade show active " id="detParcelas-pane" role="tabpanel" aria-labelledby="detParcelas" tabindex="0">
                    <div class="contenedorListado row">

                        <div class="row mt-3 justify-content-end">
                            <label for="crotal" class="col-sm-2 col-form-label">Crotal</label>
                            <div class="col-sm-6">
                                <input type="search" class="form-control" id="crotal">
                            </div>
                        </div>

                        <div id="listadoPorParcela">

                            <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
                        </div>
                        <div id="paginacionPorParcela">
                            <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mt-5 justify-content-center align-items-center" id="parcelas"></div>
        </div>

    </div>

</div>

<!-- Modal detalles animales-->
<div class="modal fade" id="detallesAnimalesModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="detallesAnimal">Detalles Animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class=" row">
                    <div class="col-lg-6 conSombra text-start p-3">
                        <h4 class="text-center">Detalles del Animal</h4>

                        <div id="tablaDetalles"></div>

                    </div>

                    <div class="col-lg-6 ">
                        <div class="row conSombra mb-2 mt-md-3">
                            <h4>Partos del Animal</h4>

                            <div id="detallesAnPar"></div>

                        </div>

                        <div class="row conSombra mb-2">
                            <h4>Incidencias del Animal</h4>
                            <div id="detallesAnInc"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>app/vistas/js/funciones.js"></script>
<script src="<?= BASE_URL ?>app/vistas/js/parDetalles.js"></script>