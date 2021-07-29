<?php

/*
*Klasse Utility, verwende diese um dinge wie das copyright hinzuzufuegen ()
*/

class Utility {
    /**
     * Instantiate with new Utility(), then use with individual functions
     */
    public function __construct ()
    {
        
    }

    /**
     * @param type Type of Utility HTML
     */

    public function get ($type) 
    {
        switch ($type) {
            case "copyright":
                return '
                <div class="card-action center">
                    <span style="cursor: pointer; font-weight: lighter;" onclick="window.location=\'/intern/?type=information\';">&copy; '.date("Y").' Heinrich-Suso-Gymnasium Konstanz</span>
                </div>
                ';
                break;
            case "copyright-divider":
                return '
                <div class="card-action center">
                    <div class="divider"></div>
                    <br/>
                    <span style="cursor: pointer; font-weight: lighter;" onclick="window.location=\'/intern/?type=information\';">&copy; '.date("Y").' Heinrich-Suso-Gymnasium Konstanz</span>
                </div>
                ';
                break;
        }
    }
}

?>