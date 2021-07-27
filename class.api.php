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
}

?>