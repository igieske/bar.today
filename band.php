<?php
     require_once("database.php");
     require_once("models/bands.php");
     require_once("models/functions.php");

     $link = db_connect();
     $band = bands_get($link, $_GET['id']);

     include("views/band.php");

?>