<?php
     require_once("database.php");
     require_once("models/bars.php");
     require_once("models/functions.php");

     $link = db_connect();
     $bar = bars_get($link, $_GET['id']);

     include("views/bar.php");

?>