<?php
     require_once("database.php");
     require_once("models/musicstyles.php");
     require_once("models/functions.php");

     $link = db_connect();
     $musicstyle = musicstyles_get($link, $_GET['id']);

     include("views/musicstyle.php");

?>