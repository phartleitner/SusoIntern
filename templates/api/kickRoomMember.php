<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    if (!isset($input["roomId"]) || !isset($input["memberCode"])) {
        $api->throw("Requesterror", "Please provide roomId and memberCode.");
    }   

    if ($user->isAdminOfRoom($input["roomId"])) {
        $api->send($user->kickMemberFromRoom($input["memberCode"], $input["roomId"]), "Kicked user from room.");
    } else {
        $api->throw("Permissionerror", "Not admin.");
    }
}
?>
