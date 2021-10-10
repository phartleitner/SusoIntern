<?php
$data = $this->getDataForView();
$input = array_merge($_GET, $_POST);

/* Get Student Object by ID */
$student = Model::getInstance()->getStudentById($input['child']);

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
                <b><?php echo $student->getFullName() ?></b>
            </span><br>
        </div>

        <?php echo $utility->get("copyright"); ?>
    </div>
</div>

<?php include("js.php"); ?>

</body>
</html>
