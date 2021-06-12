<?php 
// 사용자 요청을 처리하는 모든 php파일에서 호출하는 파일.

// WEB 루트 = $_SERVER['DOCUMENT_ROOT'];

// require_once $_SERVER['DOCUMENT_ROOT'] . '/webInit.php';



date_default_timezone_set('Asia/Seoul');
session_start();
require_once __DIR__ . "/util.php";
require_once __DIR__ . "/app/app.php";

// 현재 환경이 개발 혹은 운영
$dbConn = $application->getDbConnectionByEnv();


