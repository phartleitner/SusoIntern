<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    if (!isset($input["roomName"])) {
        $api->throw("Requesterror", "Please provide roomName.");
    }   

    $api->send($user->createNewRoom($input["roomName"]), "Created new room.");
}
?>
