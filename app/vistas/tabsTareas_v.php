<style>
   
</style>

<div id="centro" class="col-lg-10 text-center m-auto d-flex flex-column mt-1">
<ul class="nav nav-tabs container-fluid m-auto " id="myTab" role="tablist">


  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="animales" aria-selected="true">Calendario</button>
  </li>

  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="partos" aria-selected="false">Lista</button>
  </li>

</ul>

<div class="tab-content container-fluid" id="myTabContent">
  <div class="tab-pane fade show  active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0"><?php include "calendario_v.php";?></div>

  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"><?php include "tareas_v.php";?></div>
</div>

</div>
<script src="<?= BASE_URL?>app/vistas/js/funciones.js"></script>
<script src="<?= BASE_URL?>app/vistas/js/tareas.js"></script>
