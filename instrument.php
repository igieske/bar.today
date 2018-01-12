<?php
     require_once("database.php");
     require_once("models/instruments.php");
     require_once("models/functions.php");

     $link = db_connect();
     $instrument = instruments_get($link, $_GET['id']);

     include("views/instrument.php");

?>