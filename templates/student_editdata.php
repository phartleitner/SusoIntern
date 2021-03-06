<?php

//$model = Model::getInstance();
$data = $this->getDataForView();
/** @var StudentUser $user */
$user = $data['user'];
include("header.php");

?>

<div class="container">
    
    <div class="card">
        <div class="card-content">
             <span class="card-title">
					<a id="backButton" class="mdl-navigation__link waves-effect waves-light teal-text" href=".">
						 <i class="material-icons">chevron_left</i>
					</a>
                 Nutzereinstellungen aktualisieren:
				</span>
            <?php if ($user->getClass() == "11" || $user->getClass() == "12"): ?>
                
                <form onsubmit="submitForm()" action="javascript:void(0);" autocomplete="off">
                    <div class="rw">
                        <div class="input-field">
                            <label for="f_courselist">Liste der Kurse (z.B. E1;M3;gk2 ...):</label>
                            <input name="f_courselist" id="f_courselist" type="text"
                                   value="<?php echo $user->getCourses(); ?>">
                        </div>
                    </div>
                    <div class="input-field right-align">
                        <button class="btn waves-effect waves-light" type="submit">Update
                            <i class="material-icons right">loop</i>
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <?php echo $utility->get("copyright"); ?>
    </div>
</div>

</div>

<?php include("js.php"); ?>

<script type="application/javascript">
    function submitForm() {

        var courses = $('#f_courselist').val();

        $.post("", {
            'type': 'student_editdata',
            'console': '',
            'data[courses]': courses

        }, function (data) {

            try {
                if (data.success) {
                    location.reload();
                }
                else { // oh no! ;-;
                    var notifications = data['notifications'];
                    notifications.forEach(function (data) {
                        Materialize.toast(data, 4000);
                    });

                }
            } catch (e) {
                Materialize.toast('Interner Server Fehler!');
                console.error(e);
                console.info('Request: ' + url_param);
                console.info('Response: ' + data);
            }

        });

    }
</script>

</body>
</html>
