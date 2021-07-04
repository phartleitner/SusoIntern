<?php namespace administrator;
    include("header.php");
    $data = \View::getInstance()->getDataForView();
?>

<div class="container">
	<div class="row">
		<div class="col s12  ">
			<div class="card">
				<div class="card-content">
				  <span class="card-title">
					<?php if (isset($data["backButton"])) { ?>
						<a id="backButton" class="mdl-navigation__link waves-effect waves-light teal-text"
						   href="<?php echo $data["backButton"]; ?>"><i
									class="material-icons">chevron_left</i></a>
					<?php } ?>
					  <?php echo \View::getInstance()->getTitle(); ?>
				  </span>
				  <br>
				<?php include('pupilmgt_form.php'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
