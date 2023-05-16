<?php
    $cont="1234";
  $passw= password_hash($cont, PASSWORD_DEFAULT);
  var_dump($passw);