<?php
    require_once("database.php");

    require_once("models/bars.php");
    require_once("models/cases.php");
    require_once("models/bands.php");
    require_once("models/fellas.php");
    //require_once("models/instruments.php");
    //require_once("models/musicstyles.php");

    require_once("models/functions.php");

    $link = db_connect();

    $bars = bars_all($link);
    $cases = cases_all($link);
    $bands = bands_all($link);
    $fellas = fellas_all($link);
    //$instruments = instruments_all($link);
    //musicstyles = musicstyles_all($link);

    include("views/header.php");

?>
     <div id="main-view">
          <div><?php include("views/bars.php"); ?></div>
          <div><?php include("views/cases.php"); ?></div>
          <div><?php include("views/bands.php"); ?></div>
          <div><?php include("views/fellas.php"); ?></div>
     </div>
<?php include("views/footer.php"); ?>