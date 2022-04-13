<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

if (empty($_POST["ad"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'ad eksik!'
    ));
    exit;
} else if (empty($_POST["soyad"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'soyad eksik!'
    ));
    exit;
}

$ad = $_POST["ad"];
$soyad = $_POST["soyad"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://78.135.87.16/wizort/api/lbys/api.php?ad=$ad&soyad=$soyad");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
