<style>
   
</style>

<div id="centro" class="col-lg-10 text-center m-auto d-flex flex-column mt-1">
<ul class="nav nav-tabs container-fluid m-auto " id="myTab" role="tablist">

<?php 
$animalesShow="";
$partosShow="";
$animSelected="";
$partosSelected="";
if (!empty($animActiva)) {
  $animalesShow="show";
  $animSelected="true";
}else{
  $animSelected="false";
}
if (!empty($partActiva)) {
  $partosShow="show";
  $partosSelected="true";
}else{
  $partosSelected="false";
}
?>

  <li class="nav-item" role="presentation">
    <button class="nav-link <?= $animActiva?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="animales" aria-selected="<?= $animSelected?>">Animales</button>
  </li>

  <li class="nav-item" role="presentation">
    <button class="nav-link <?= $partActiva?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="partos" aria-selected="<?= $partosSelected?>">Partos</button>
  </li>

</ul>
<?php 
$animalesShow="";
$partosShow="";
if (!empty($animActiva)) $animalesShow="show";
if (!empty($partActiva)) $partosShow="show";
    ?>
<div class="tab-content container-fluid" id="myTabContent">
  <div class="tab-pane fade <?= $animalesShow?>  <?= $animActiva?> " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0"><?php include "animales_v.php";?></div>

  <div class="tab-pane fade <?= $partosShow?>  <?= $partActiva?>" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"><?php include "partos_v.php";?></div>
</div>

</div>
<script src="<?= BASE_URL?>app/vistas/js/funciones.js"></script>
<script src="<?= BASE_URL?>app/vistas/js/animales.js"></script>
<script src="<?= BASE_URL?>app/vistas/js/partos.js"></script>