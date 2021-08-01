<?php
// Returns current User Data

$api->CSRF();


if (isset($_SESSION["user"]) && isset($input["studentId"]) && isset($input["consent"])) {
    if ($userType === 'Guardian') {
        foreach($user->getChildren() as $child) {
            if (intval($child->getId()) === intval($input["studentId"])) {
                foreach($child->getConsentOptionNames() as $key => $consent) {
                    if ($input["consent"] == $consent) {
                        $api->send($child->toggleConsent($input["consent"]), "Toggled child consent.");
                    }
                }
                $api->throw("Requesterror", "Illegal consent.");
            }
        }
    }
}

?>