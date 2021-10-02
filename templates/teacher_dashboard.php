<?php
include("header.php");
$data = $this->getDataForView();
$cover_lessons = $data['VP_coverLessons'];
$taughtStudents = $data['taughtstudents'];
$taughtClasses = $data['taughtclasses'];
$welcomeText = null;
$shownotice = false;
if (strlen($data['welcomeText'])>15) {
$shownotice = "true";
$welcomeText = $data['welcomeText'];	
} 
?>
<?php if ($shownotice) { ?>
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

<div class="col l6 s12 m6">
	<div class="card white ">
        <div class="card-content">
            <span class="card-title">Vertretungen</span>
            <p><?php echo count($cover_lessons)." aktuelle Vertretungen" ?></p>
        
		<div class="card-action">
			<a class="secondary-content action" href="?type=vplan">zum Vertretungsplan</a>
		</div>
		</div>
		
    </div>
</div>
<div class="col l6 s12 m6">
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
</div>
<div class="row">
	<div class="col s12 m6 l6">
		<div class="card">
			<div class="card-content">
				<span class="card-title"><?php echo "Abwesenheit eintragen" ?></span>
				 <br>
				 <div class="input-field ">
					<i class="material-icons prefix">search</i>
					<input type="text" id="pupil-input" name="name"></input>
					<label for="pupil-input" class="truncate">Nachname</label>
				</div>
				<div id="pupils"></div>	
				<br/>oder aus Klasse wählen
				<ul class="collapsible" id="classlist"></ul>
			</div>
		</div>
	</div>
	<div class="col s12 m6 l6">
		<div class="card">
			<div class="card-content">
				<span class="card-title">abwesende Schüler</span>
				 <!-- <div id="missingpupils"></div>	-->	
				<ul class="collapsible" id="missingpupils">	
			</div>
		</div>
	</div>
</div>
<!-- blueprint for collapsible list -->

    <li id="row_blueprint" style="display: none;">
      <div class="collapsible-header" name="listheader"></div>
      <div class="collapsible-body" name="listbody"></div>
    </li>
<!-- blueprint for collapsible class list -->

    <li id="class_blueprint" style="display: none;">
      <div class="collapsible-header" name="listheader"></div>
      <div class="collapsible-body" name="listbody"></div>
	  <ul id="students"></ul>
    </li>
	
	<!-- Blueprint for singleLessonAbsence Button-->
	<div class="btn" id="button_blueprint" style="display: none"></div>
    
<?php include("teacher_dashboard_modals.php"); ?>



<?php include("js.php"); ?>
<script type="text/javascript">

<?php include("absence_mgt.php"); ?>
var shownote = false;
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


teacherUser = 1;
requestReady = true;
studentList = <?php echo json_encode($taughtStudents); ?>;
classList = <?php echo json_encode($taughtClasses); ?>;
createStudentList(studentList);
createClassList();
createAbsenteeList();
</script>


</body>
</html>
