<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    if (!isset($input["setting"]) || !isset($input["value"])) {
        $api->throw("Requesterror", "Parameter missing.");
    }
    
    $api->send($user->setSetting($input["setting"], $input["value"]), "Current user information.");
}
?>
