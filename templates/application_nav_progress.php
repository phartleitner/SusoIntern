<!--
    shows nav/headbar and progress bar
-->
<div class="navbar-fixed">
        
        <nav>
            <div class="nav-wrapper teal">
<li>
        
            <i class="material-icons left">
                <?php echo "school"; ?>
            </i>
            
            <a id = "header_info" style="font-size:18px;font-weight:bold">Elektronische Anmeldung an den Gymnasien der Stadt Konstanz</a>
            </div>
    </li>
    </nav>
</div>

<div class="row">
        <div class="col s12 m12 l12">
            <div class="card ">
                <div id="progressbar" class="teal-text" align="center">
                        <?php
                        
                        for($x = 1;$x <= 3; $x++) {
                        ?>
                            <span id="<?php echo "step".$x; ?>" class="teal-text" >
                            <?php echo $steps[$x]; ?>
                        </span>
                        <?php
                        if ($x == 3) {
                        ?>
                            <br/>
                        <?php    
                        } else {
                        ?>
                            <a >
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                            </a> 
                        <?php
                        }
                    }
                        
                        for($x = 4;$x <= 6; $x++) {
                        ?>
                            <span id="<?php echo "step".$x; ?>" class="teal-text" <?php if ($x == 6) { echo 'style="display:none"'; }?> >
                            <?php echo $steps[$x]; ?>
                        </span>
                        <?php
                        if ($x == 6) {
                        ?>
                            <br/>
                        <?php    
                        } else {
                        ?>
                            <a >
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                            </a> 
                        <?php
                        }
                    }
                        ?>
                        
                        
                        
                </div>
            </div>
        </div>
</div>