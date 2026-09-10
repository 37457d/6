<?php

$github_url = "https://github.com/37457d/6";

$db_host = 'sql210.infinityfree.com';
$db_user = 'if0_42361416';
$db_pass = 'u5E4TOZGatyltXC';
$db_name = 'if0_42361416_std';
$db_port = 3306;

$conn = new mysqli(
    $db_host,
    $db_user,
    $db_pass,
    $db_name,
    $db_port
);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

date_default_timezone_set('Asia/Bangkok');

?>