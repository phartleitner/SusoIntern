<?php
// Returns current User Data

require_once $_SERVER["DOCUMENT_ROOT"] . '/intern/class.model.php';


$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }

    if (!isset($input["roomId"]) ) {
        $api->throw("Requesterror", "Please provide roomId.");
    }   

    
    if (intval(Model::getInstance()->getRoomById($input["roomId"])["joinable"]) === 1) {
        $api->send($user->joinRoom($input["roomId"]), "Promoted / Demoted user from room.");
    } else {
        $api->throw("Permissionerror", "Not admin.");
    }
}
?>
