<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    
    $api->send($user->get_rooms(), "Rooms of the current user.");
}
?>
