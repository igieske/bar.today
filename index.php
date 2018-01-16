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
?>

<?php include("views/header.php"); ?>

<div class="container">
	<div class="main row">
		<div class="col-12 col-lg-4 align-self-center input-group input-group-lg">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-lg">dfg</span>
			</div>
			<input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
		</div>
		<div class="col-12 col-lg-4 align-self-center input-group input-group-lg">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
			</div>
			<input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
		</div>
		<div class="col-12 col-lg-4 align-self-center input-group input-group-lg">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
			</div>
			<input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
		</div>
	</div>
</div>

<?php include("views/footer.php"); ?>