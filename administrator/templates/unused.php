<?php namespace administrator;
    include("header.php");

    $data = \View::getInstance()->getDataForView();

?>


<div class="container">

    <div class="card">
        <div class="card-content">
          <span class="card-title">
            <?php if (isset($data["backButton"])) { ?>
                <a id="backButton" class="mdl-navigation__link waves-effect waves-light teal-text"
                   href="<?php echo $data["backButton"]; ?>"><i
                            class="material-icons">chevron_left</i></a>
            <?php } ?>
              <?php echo \View::getInstance()->getTitle(); ?>
         
		  <div class="row mdl-navigation__link"><?php echo count($data["unused"]) ." registrierte Benutzer ohne Schülerzuordnung"; ?></div>
           </span>  
		  <p style="margin-top: 20px;">
                <?php
                    if (isset($data["unused"]))
                    {
                    foreach ($data["unused"] as $u)
                    { ?>
            <div class="row">
				<span ><?php echo $u['name'].", ".$u['vorname']." (ElternId: ".$u['eid'].") - "; ?></span>
                <a class="teal-text " id="menueItem"
                   href="?type=usredit&name=<?php echo $u['mail']; ?>"><?php echo $u['mail']; ?> </a>
				   <span><?php echo '  registriert am: '.$u['registered']; ?></span>
				<a class="teal-text " title="Benutzer löschen" href="?type=usrmgt&unused&del=<?php echo $u['id']; ?>" ><i class="material-icons right">delete</i> </a>
					
            </div>

            <?php
                }
                } ?>

            </p>
        </div>

    </div>


</div>

<?php include "js.php"; ?>
</body>
</html>
