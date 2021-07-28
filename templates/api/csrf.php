<?php

/*
Makes no sense as if yuou want to get the token, you cant use it 

$api->CSRF();
*/

if (isset($_SESSION["CSRF-token"])) {
    $api->send($_SESSION["CSRF-token"], "CSRF-token. Use it inside a Http-Header named 'CSRF-token'.");
} else {
    $api->throw("Servererror", "No CSRF-token set. Please try to reload the page.");
}
?>
