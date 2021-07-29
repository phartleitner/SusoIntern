<?php
$data = $this->getDataForView();
$input = array_merge($_GET, $_POST);

include("header.php");

?>

<div class="container">
    <div class="card">
        <div class="card-content">
            <span class="card-title">
                <a id="backButton" title="Zurück zur Kinderauswahl" class="mdl-navigation__link waves-effect waves-light teal-text" href="?type=childsel">
					<i class="material-icons">chevron_left</i>
				</a>
                Einverständniserklärungen bearbeiten <br>
            </span><br>
            <b>Kind ID:</b> <?php echo $input['child']; ?>
        </div>

        <?php echo $utility->get("copyright"); ?>
    </div>
</div>

<?php include("js.php"); ?>

</body>
</html>
