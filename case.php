<?php
     require_once("database.php");
     require_once("models/cases.php");
     require_once("models/functions.php");

     $link = db_connect();
     $case = cases_get($link, $_GET['id']);

     include("views/case.php");

?>