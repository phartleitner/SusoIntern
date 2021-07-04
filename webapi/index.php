<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json;charset=utf-8');

/* Utilities*/
require "../base/class.superutility.php";
require "../class.user.php";
include("class.controller.php");
include("../class.connect.php");
include("../class.model.php");
include("../class.coverLesson.php");
include("../class.termin.php");
include("class.webapimodel.php");
include("../administrator/administrator.tmanager.class.php");

$data = array_merge($_POST,$_GET);
new Controller($data);

?>