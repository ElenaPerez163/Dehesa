<style>
    .filtros {
        background-color: #e5f2c9;
    }
</style>

<div class="contenedorListado m-none row">
    <div class="listado col-9">
        <div id="listadoPartos" class="mt-5">
            <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
        </div>
        <div id="paginacionPartos">
            <!-- AQUÍ VA EL LISTADO DE ANIMALES GENERADO CON JAVASCRIPT -->
        </div>

    </div>

    <div id="filtrosPartos" class="filtros col-3">

        <h2 class="mt-4">Filtros</h2>

        <div class="form-floating mb-3">
            <input type="search" class="form-control" id="partoCrotal" name="crotal" placeholder="crotal" maxlength="14">
            <label for="crotal">crotal</label>
        </div>

        <div class="form-floating mb-3">
            <input type="search" class="form-control" id="partoCrotalMadre" name="crotalMadre" placeholder="crotal madre">
            <label for="crotalMadre">crotal madre</label>
        </div>

        <div class="form-check form-check-inline  w-100 text-start mb-3 mx-2">
            <input class="form-check-input" type="checkbox" id="asistido" value="1">
            <label class="form-check-label mx-2 fw-semibold" for="asistido">Asistido</label>
        </div>

        <div class="mb-2 text-start">
            <label for="desde" class="form-label">Desde:</label>
            <input type="date" class="form-control" id="partoDesde" name="desde">
        </div>

        <div class="mb-5 text-start">
            <label for="hasta" class="form-label">Hasta:</label>
            <input type="date" class="form-control" id="partoHasta" name="hasta">
        </div>

    </div>
</div>

<!-- Modal detalles partos-->
<div class="modal fade" id="detallesPartosModal" tabindex="-1" aria-labelledby="detalles de parto" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4" id="detallesParto">Detalles Parto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class=" row">
                    <div class="col-lg-6 conSombra text-start p-3">
                        <h4 class="text-center">Detalles del Parto</h4>

                        <div id="tablaDetallesParto"></div>

                    </div>

                    <div class="col-lg-6 p-3 ">
                        <h4>Otros Partos de la Vaca</h4>

                        <div id="detallesOtrosPartos"></div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>