<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"])) {
    $data = array();

    $data = array_merge($data, $user->getData());
    $data["type"] = $userType;

    if (!isset($input["studentId"])) {
        $api->throw("Requesterror", "No studentId given.");
    }

    if ($userType === 'Guardian') {
        foreach($user->getChildren() as $child) {
            if (intval($child->getId()) === intval($input["studentId"])) {
                $api->send($child->getConsentOptions(), "Illegal consent.");
            }
        }
    }
}
?>
