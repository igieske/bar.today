<?php
     require_once("database.php");
     require_once("models/fellas.php");
     require_once("models/functions.php");

     $link = db_connect();
     $fella = fellas_get($link, $_GET['id']);

     include("views/fella.php");

?>