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
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="incidencias" aria-selected="true">Facturas</button>
        </li>
    </ul>

    <div class="tab-content container-fluid" id="myTabContent">
        <div class="tab-pane fade show active " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    
            <div class="contenedorListado m-none row">
                <div class="listado col-9">
                    <div id="listadofacturas" class="mt-5">
                        <!-- AQUÍ VA EL LISTADO DE FACTURAS GENERADO CON JAVASCRIPT -->
                    </div>
                    <div id="paginacionfacturas">
                        <!-- AQUÍ VA LA PAGINACIÓN GENERADA CON JAVASCRIPT -->
                    </div>
                </div>

                <div id="filtrosAnimales" class="filtros col-3">

                    <h2 class="mt-1">Filtros</h2>

                    <div class="form-floating mb-3">
                        <input type="search" class="form-control" id="numFactura" name="numFactura" placeholder="Número Factura" maxlength="14">
                        <label for="numFactura">Número Factura</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="idCliente" name="idCliente" aria-label="idCliente">
                            <option class="active" value="">Todos</option>
                            <?php foreach ($clientes as $cliente) : ?>
                                <option value="<?= $cliente['idCliente'] ?>"><?= $cliente['NombreCli']." ".$cliente['ApellidosCli']?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="idCliente">Cliente</label>
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

            <!-- Modal para alta de facturas-->
            <div class="modal fade" id="incidenciasModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="labelModalIncidencias">Nueva Factura</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class=" justify-content-center" name="formIncidencias" action="<?= BASE_URL; ?>Incidencias_c/insertar" method="post" enctype="multipart/form-data">

                                <div class="row mb-4 justify-content-right">
                                    <label for="crotal" class="col-sm-1 col-form-label text-end">Cliente</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" list="opcionesClientes" name="idCliente" id="idCliente" placeholder="Buscar...">
                                        <datalist id="opcionesClientes">
                                            <?php foreach ($clientes as $cliente) : ?>
                                                <option value="<?= $cliente['NombreCli']." ".$cliente['ApellidosCli']?>"><?= $cliente['idCliente'] ?></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            El cliente debe añadirse primero
                                        </div>
                                    </div>

                                    <label for="numFactura" class="col-sm-1 col-form-label text-end">Número</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="numFactura" maxlength="7" required>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            Esta factura ya existe
                                        </div>
                                    </div>

                                    <label for="fechaIncidencia" class="col-sm-1 col-form-label text-end">Fecha</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" name="fechaIncidencia" required>
                                    </div>
                                </div>

                                <div class="accordion" id="accordionPanelsStayOpenExample">
                        
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button collapsed btnMedio" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Nuevo Cliente
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Aquí va el formulario para añadir un nuevo cliente</p>
                                </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button btnMedio" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Animales
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                <p>Aquí van los animales que se van a incluir en la factura</p>
                                </div>
                                </div>
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
<script src="<?= BASE_URL ?>app/vistas/js/facturas.js"></script>