<?php
include("header.php");
$data = $this->getDataForView();
$cover_lessons_text = isset($data['VP_coverLessons']) ? "es liegen Vertretungen vor" : "keine Vertretungen";
$cover_lessons_link = isset($data['VP_coverLessons']) ? true : false;
if (isset($data['children'])) {
$children = (count($data['children']) > 0) ? $data['children'] : "null";
}

if(isset($data['dashboard_children'])) {
$dashboardChildren = $data['dashboard_children'];	
} else {
$dashboardChildren = "null";	
}
$shownotice = "true";
if (isset($children) ) {
if (strlen($data['welcomeText'])>15) {
	$welcomeText = $data['welcomeText'];
	} else {
	$welcomeText = null;
	$shownotice = "false";
	}	
} else {
$welcomeText = "Sie müssen zunächst Ihre Kinder registrieren, bevor Sie die Angebote nutzen können!";
}
?>
	<?php if ($shownotice) { ?>

<div class="container">
	<div class="row">
		<div class="col s12 ">
			<div class="card white">
				<div class="card-content">
					<div class="card-title" style="margin-bottom: 20px;">Informationen</div>

					<!--
						<span class="card-title">aktuelle Hinweise
							<a class="btn-flat teal-text " onClick="showNotice();"><i id="button" class="material-icons">expand_more</i></a> 
						</span>
						
						
						<div id="notice" style="display: none;">
						<?php echo $welcomeText; ?>
						</div>
					-->
					<ul class="collapsible">
						<li>
						<div class="collapsible-header card-title" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">Aktuelles zu Corona & Fernlernen <i class="material-icons">expand_more</i></div>
						<div id ="notes" class="collapsible-body">

						</div>
						</li>
					</ul>

					<ul class="collapsible">
						<li>
						<div class="collapsible-header card-title" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">Einschulungen & Aenderungen <i class="material-icons">expand_more</i></div>
						<div id ="notes" class="collapsible-body">

						</div>
						</li>
					</ul>

					<ul class="collapsible">
						<li>
						<div class="collapsible-header card-title" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">Sonstiges <i class="material-icons">expand_more</i></div>
						<div id ="notes" class="collapsible-body">

						</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
    <div class="row">
		<?php if (isset($children) ) { ?>
		<div class="col s12 ">
			<div class="card white">
				<div class="card-content">
					<span class="card-title">Demnächst</span>
					<?php
					if (isset($data["upcomingEvents"]) && count($data["upcomingEvents"]) > 0) {
						$brPrevent = false;
						foreach ($data["upcomingEvents"] as $t) {
						?>
							<span><?php if ($brPrevent === true) {?> <br> <?php }?><b><a class="teal-text"><?php echo $t->typ; ?></b></a><a class="teal-text">
						<?php echo $t->sweekday . " " . $t->sday;
						if (isset($t->stime)) {
							echo ' (' . $t->stime . ')';
						}
						if (isset($t->eday)) {
							echo "-";
						}
						echo " " . $t->eweekday . " " . $t->eday;
						if (isset($t->etime)) {
							echo ' (' . $t->etime . ')';
						}
						?>
						</a>
						</span>
							<?php
							$brPrevent = true;
						}
					}
					?>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<?php if (isset($children) ) { ?>
		<div class="col l6 s12 m6">
			
			<div class="card white ">
				<div class="card-content">
					<span class="card-title" style="margin-bottom: 15px;">Ihre Kinder</span>
					<ul class="collapsible" id="childrenlist"></ul>	
				</div>
			</div>
			
			<!-- blueprint for collapsible list -->
			<li id="row_blueprint" style="display: none;">
			  <div class="collapsible-header" ></div>
			  <div class="collapsible-body" ></div>
			</li>
			
		</div>
		<?php include("parent_dashboard_modals.php"); ?>
		<?php } ?>
		<?php if (isset($children) ) { ?>
		<div class="col l6 s12 m6">
			<div class="card white ">
				<div class="card-content">
					<span class="card-title">Vertretungen</span>
					<p><?php echo $cover_lessons_text ?></p>
        		<?php if ($cover_lessons_link) { ?>
				<div class="card-action">
					<a class="secondary-content action" href="?type=vplan">zum Vertretungsplan</a>
				</div>
				<?php } ?>
			</div>
		
			</div>
		</div>
		<?php } ?>
		
	</div>
</div>

<?php 
include("js.php"); 
?>
<script type="text/javascript">
<?php
include("absence_mgt.js"); 
?>
/*shownotice = <?php echo $shownotice ?>;
document.addEventListener("DOMContentLoaded", function(event) {
    if (shownotice) {
	$('#notes').modal();
	$('#notes').modal('open');
	}
		
  });*/
var shownote = false;
document.getElementById('notes').innerHTML="<?php echo $welcomeText; ?>";
/*
function showNotice() {
if (shownote == false) {
	shownote = true;
	document.getElementById('button').innerHTML="expand_less";
	document.getElementById('notice').style.display="block";
	} else {
	shownote = false;
	document.getElementById('button').innerHTML="expand_more";
	document.getElementById('notice').style.display="none";
	}	
}
*/
studentList = <?php echo $dashboardChildren; ?>;
createStudentList(studentList);
createChildrenList();

</script>

</body>
</html>
