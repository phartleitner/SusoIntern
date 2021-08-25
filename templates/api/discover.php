<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    /*
    [
        ["type" => "room", "id" => "1", "name" => "Nathans Chill Lounge", "inChat" => false],
        ["type" => "user", "id" => "Guardian:9", "name" => "Muster, Mama (Elternteil)", "inChat" => true]
    ]*/

    $api->send($user->getDiscover(), "Discover new people and rooms!");
}
?>
