<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    if (!isset($user)) {
        $api->throw("Permissionerror", "No user provided / logged in.");
    }


    if (!isset($input["text"]) || !isset($input["roomId"])) {
        $api->throw("Requesterror", "Please set room and test Id.");
    }
 
    $name = false;
    $rooms = $user->get_rooms();
    
    foreach($rooms as $key => $value) {
        if (intval($value["id"]) === intval($input["roomId"])) {
            $api->send($user->sendMessage($input["roomId"], htmlspecialchars($input["text"])), "Message sent in room.");
        }
    }

    $api->throw("Permissionerror", "You are not inside of the room.");
}

?>

