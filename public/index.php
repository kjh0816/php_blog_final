<?php require_once __DIR__ . "/../webInit.php";

$REQUEST_URI = $_SERVER['REQUEST_URI'];

if ( $REQUEST_URI == '/' ) {
  jsLocationReplaceExit("/usr/member/home");
}

list($action) = explode('?', $REQUEST_URI);
$action = substr($action, 1);

App__run($action);
