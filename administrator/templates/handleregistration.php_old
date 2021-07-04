<?php namespace administrator;
    include("header.php");
    $data = \View::getInstance()->getDataForView();
	$requests = $data['requests'];
?>

<div class="row">
	<div class="col s12  m6 l6 ">
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
			  <div>
			  <?php if(isset($requests)) { ?>
				
					<?php foreach ($requests as $r) { ?>
					<div class="card grey lighten-4"  id="request<?php echo $r['id']; ?>">	
					<!--	<div class="card-content" > -->
						<div class="card-title">
						AnfrageID: <?php echo $r['id']; ?> 
						</div>
							<div>
							<table>
								<tbody>
									<tr>
										<td>
											Anfrage für 
											<?php echo $r['name'] . " (".$r['klasse'].") geb. am ".$r['dob'] ."<br> durch ".
											$r['parentName'] . " (".$r['email'].") am " . $r['requestDate']; ?>
										</td>
										<td>
											<a href="#" onClick="deleteRequest(<?php echo $r['id']; ?>)" class= "">
												<i class="material-icons grey-text">delete</i>
											</a>
										</td>
										<td>
											<a href="#" onClick="passRequestId(<?php echo $r['id']; ?>)" class= "">
												<i class="material-icons grey-text">edit</i>
											</a>
										</td>
									<tr>
								</tbody>
							</table>
							</div>
					<!--	</div> -->
						
					</div>	
									
					<?php } ?>					
				
				
			  <?php } else { ?>
			  <p> Keine aktuellen Anfragen </p>
			  <?php }?>
				</div>

			</div>
			

		</div>
	</div>
    <!-- card mit Suchleiste zur Schülerauswahl -->
	<div class="col s12 m6 l6">
		<div class="card">
		
				  <span id="searchtitle" class="card-title">
					Bitte Anfrage auswählen
				  </span>
				  <br>
				<?php include('pupilmgt_form.php'); ?>
		
		</div>
	</div>
	
</div>

<!-- Include Javascript -->
<?php include("js.php") ?>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
<script src="templates/pupilmgt.js"></script>


</body>
</html>
