<?php

/*
*Klasse Utility, verwende diese um dinge wie das copyright hinzuzufuegen ()
*/

class Api {
    /**
     * Instantiate with new API(), then use with individual functions
     */
    public function __construct ()
    {
        
    }

    /**
     * Used to return Errors
     * @param type Type of Error
     * @param debug Debug message
    */
    public function throw ($type, $debug) 
    {
        header('Content-Type: application/json');
        exit(json_encode([
            "type" => "error",
            "error" => $type,
            "debug" => $debug

        ]));
    }

    /**
     * Used to return Data of query
     * @param data Data as php object / array
     * @param debug Debug message
    */
    public function send ($data, $debug) 
    {
        header('Content-Type: application/json');
        exit(json_encode([
            "type" => "success",
            "data" => $data,
            "debug" => $debug
        ]));
    }






    /**
     * Checks if CSRF is set
     */

    public function CSRF ()
    {
        if (!isset($_SESSION["CSRF-token"])) {
            $this->throw("Servererror", "CSRF-SESSION-Variable missing. Please try to reload the page.");
        }
        if (!isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            session_destroy();
            $this->throw("Requesterror", "'HTTP_X_CSRF_TOKEN' not sent. Please include it in the HTTP-Headers. You can receive it from the API endpoint 'csrf'.");
        }
        if ($_SERVER["HTTP_X_CSRF_TOKEN"] !== $_SESSION["CSRF-token"]) {
            session_destroy();
            $this->throw("Requesterror", "'HTTP_X_CSRF_TOKEN' not correct. Please include it in the HTTP-Headers. You can receive it from the API endpoint 'csrf'.");
        }
    }
}

?>