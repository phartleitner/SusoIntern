<?php
$data = $this->getDataForView();
/** @var Guardian $user */
$user = $data['user'];

$today = date("Ymd H:i");
include("header.php");
$day = date_format(date_create($data['estdate']), 'd.m.Y');

//identify potential second parent
$parents = $data['parents'];
$secondParent = null;
if (isset($parents[0]) && isset($parents[1]) ) {
	if ($user->getParentId() == $parents[0] ) {
		$secondParent = $parents[1];
		} 
	else if ($user->getParentId() == $parents[1]  ) {
		$secondParent = $parents[0];
		}
}


?>

<div class="container col s4 m4 l4">
    <div class="card ">
        <div class="card-content">
            
            
            <?php
            if ($today > $data['book_end']) {
                ?>
                <span class="card-title">Ihre Termine für den Elternsprechtag am <?php echo $day; ?></span>
                <?php include("show_bookings.php");
                
            } else {
                ?>
                <span class="card-title">Buchung für den Elternsprechtag am <?php echo $day; ?></span>
                <?php
                $teachers = $data['teachers'];
                $appointments = $data['appointments'];
                $maxAppointments = $data['maxAppointments'];
                $maxedOutAppointments = count($appointments) >= $maxAppointments;
                include("do_bookings.php");
                
            }
            ?>
            
            <div class="row">
                <div class="col l12 m12 s12">
                
                </div>
            </div>
        </div>
        <?php echo $utility->get("copyright"); ?>card-action center
    </div>

</div>


<?php include("js.php"); ?>
<script>
    <?php
    if (isset($data['notifications']))
        foreach ($data['notifications'] as $not) {
            echo "Materialize.toast('" . $not['msg'] . "', " . $not['time'] . ");";
        }
    
    ?>
</script>
</body>
</html>
