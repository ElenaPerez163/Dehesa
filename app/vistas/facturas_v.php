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

        <!--  MODAL PARA ALTA DE FACTURAS-->
            <div class="modal fade" id="incidenciasModal" tabindex="-1" aria-labelledby="Alta y modificación de animales" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="labelModalIncidencias">Nueva Factura</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form class=" justify-content-center" name="formFacturas" action="<?= BASE_URL; ?>Facturas_c/insertar" method="post" enctype="multipart/form-data">

                                <div class="row mb-4 justify-content-right">
                                    <label for="idCliente" class="col-sm-1 col-form-label text-end">Cliente</label>
                                    <div class="col-sm-4">
        
                                        <select class="form-select" id="opcionesClientes" required>
                                            <?php foreach ($clientes as $cliente) : ?>
                                                <option value="<?= $cliente['idCliente'] ?>"><?= $cliente['NombreCli']." ".$cliente['ApellidosCli']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            El cliente debe añadirse primero
                                        </div>
                                    </div>

                                    <label for="numFactura" class="col-sm-1 col-form-label text-end" >Número</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="numFactura" id="numFactura" maxlength="7" 
                                        placeholder="2023-01" required>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            Esta factura ya existe
                                        </div>
                                    </div>

                                    <label for="fechaFac" class="col-sm-1 col-form-label text-end">Fecha</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="fechaFac" name="fechaFac" required>
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

                        <!-- FORMULARIO NUEVO CLIENTE: SE ENVIARÁ POR AJAX -->

                        <!-- fila 1: nombre y apellidos -->
                                    <div class="row mb-3 justify-content-start">

                                        <label for="NombreCli" class="col-sm-2 col-form-label text-end textoFac">Nombre</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="NombreCli" maxlength="25">
                                        </div>

                                        <label for="ApellidosCli" class="col-sm-2 col-form-label text-end textoFac">Apellidos</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="ApellidosCli" maxlength="60">
                                        </div>
                                    </div>

                        <!-- fila 2: NIF -->
                                    <div class="row mb-3 justify-content-start">
                                        <label for="NIFCli" class="col-sm-2 col-form-label text-end textoFac">NIF</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="NIFCli" maxlength="9">
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                Este NIF ya existe
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-start">
                                        <div class="col-sm-1">
                                        <span class="textoFac titulo5">Dirección</span>
                                        </div>
                                        <hr class="textoFac">
                                    </div>           

                        <!-- DIRECCIÓN: PROVINCIA Y MUNICIPIO-->
                                    <div class="row mb-3 justify-content-center">
                                   <!-- PROVINCIA -->
                                        <label for="ProvinciaCli" class="col-sm-1 col-form-label text-end textoFac">Provincia</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" list="opcionesProvincias" name="ProvinciaCli" id="ProvinciaCli" placeholder="Buscar...">
                                            <datalist id="opcionesProvincias">
                                                <?php foreach ($provincias as $provincia) : ?>
                                                    <option value="<?= $provincia['nombre']." ".$provincia['provincia_id']?>"></option>
                                                <?php endforeach; ?>
                                            </datalist>
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                La provincia debe existir
                                            </div>
                                        </div>
                                    <!-- MUNICIPIO -->
                                        <label for="PoblacionCli" class="col-sm-2 col-form-label text-end textoFac">Municipio</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" list="opcionesMunicipios" name="PoblacionCli" id="PoblacionCli" placeholder="Buscar...">
                                            <datalist id="opcionesMunicipios">
                                               <!--  SE RELLENA CON AJAX, ONCHANGE DE PROVINCIAS -->
                                            </datalist>
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                El municipio debe estar en la provincia seleccionada
                                            </div>
                                        </div>
                                   
                                    </div>

                                    <div class="row mb-4 justify-content-center">
                                    <!-- CÓDIGO POSTAL -->
                                        <label for="CpostalCli" class="col-sm-2 col-form-label text-end textoFac">C. Postal</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="CpostalCli" maxlength="5" >
                                        </div>    
                                        
                                    <!-- CALLE Y NÚMERO -->
                                        <label for="DireccionCli" class="col-sm-2 col-form-label text-end textoFac">Calle y número</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="DireccionCli" maxlength="255" >
                                        </div> 
                                       
                                    </div>

                                     <!-- BOTÓN AÑADIR -->               
                                    <div class="row mb-3 justify-content-end">
                                        <div class="col-sm-2">
                                            <button id="cliNuevoBTN" class="btn btnOscuro">Añadir</button>
                                        </div>
                                    </div>

                                </div>
                                </div>
                            </div>
                            
                        <!--  FIN NUEVO CLIENTE -->

                        <!--  INICIO DE LÍNEAS DE FACTURA -->

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                <button class="accordion-button btnMedio" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Animales
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                
                            <!-- BÚSQUEDA DE ANIMALES POR CROTAL -->
                                <div class="row mb-4 justify-content-end">   
                                        
                                <label for="numCrotal" class="col-sm-1 col-form-label text-end textoFac">Crotal</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" list="opcionesCrotales" name="numCrotal" id="numCrotal" placeholder="Buscar...">
                                        <datalist id="opcionesCrotales">
                                            <?php foreach ($crotales as $crotal) : ?>
                                                <option value="<?= $crotal['crotal'] ?>"></option>
                                            <?php endforeach; ?>
                                        </datalist>
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            Crotal no válido
                                        </div>
                                       
                                    </div>
                                    

                                    <div class="col-sm-1 gap-2 text-start" id="añadirLinea">
                                    <button id="btnAñadirLinea"class="botonInvisible" ><i class="bi bi-plus-circle-fill iconoAñadir fs-4 fw-bold" ></i></button>
                                    </div>
                                    </div>
                                    

                                    <!-- LÍNEAS DE FACTURA -->
                                    <div class="row mb-2 justify-content-center">
                                    <div class="col-sm-12">
                                        <ul class="list-group" id="lineasFactura">

                                        <!-- AQUÍ SE INSERTAN LAS LÍNEAS DE FACTURA CON UN APPEND -->
                                        

                                        </ul>

                                    </div>

                                    </div>

                                </div>
                                </div>
                            </div>
                            </div>                
                                
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btnPeligro" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn  btnOscuro" id="crearFactura">Guardar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


        <!-- MODAL DETALLES DE FACTURA-->
            <div class="modal fade" id="detallesFacModal" tabindex="-1" aria-labelledby="detalles de factura" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="detallesFactura">Detalles Factura</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <div class=" row">
                                <div class="col-lg-6 conSombra text-start p-3">
                                    <h4 class="text-center">Detalles de la factura</h4>

                                    <div id="tablaDetallesFactura"></div>

                                </div>

                                <div class="col-lg-6 p-3">
                                    <h4>Líneas de factura</h4>

                                    <div id="lineasFacturaDetalles"></div>

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