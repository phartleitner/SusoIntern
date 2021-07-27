<?php
$data = $this->getDataForView();
/** @var Guardian $user */
$user = $data['user'];
$today = date("Ymd");

$today = date('d.m.Y');
$todayMonth = date('Ym');
//$today="12.10.2016";//Nur zum Debugging
$todayTimestamp = strtotime($today);
// Grab API Type from GLOBALS
$apiType = $GLOBALS["apiType"];

$input = array_merge($_POST, $_GET);
$api = new Api();


if (in_array($apiType, [
    "test"
])) {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/intern/templates/api/" . $apiType . '.php')) {
        include($_SERVER["DOCUMENT_ROOT"] . "/intern/templates/api/" . $apiType . '.php');
    } else {
        $api->throw("Servererror", "No API-Endpoint-File found.");
    }
} else {
    $api->throw("Requesterror", "Illegal / Nonexistent API-Endpoint.");
}


?>
