<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    if (!isset($input["setting"])) {
        $api->throw("Requesterror", "Parameter missing.");
    }
    
    $api->send($user->getSettings()[$input["setting"]], "Setting.");
}
?>
