<?php

include 'dont_show_errors.php';

if (!isset($_GET["session"]) || empty($_GET["session"])) {
    echo json_encode(["status" => "false"]);
    die();
}

function getCaptcha($session, $timeObject)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://online.corluvatan.com/randevu/captcha.php?$timeObject");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$session");
    $result = curl_exec($ch);
    return $result;
}

$year = date('Y');
$month = date('m');
$day = date('d');
$hour = date('H');
$minute = date('i');
$second = date('s');
$monthobj = DateTime::createFromFormat('m', $month);
$monthName = $monthobj->format('M');
$dayobj = DateTime::createFromFormat('d', $day);
$dayName = $dayobj->format('D');
$timeObject = $dayName . " " . $monthName . " " . $year . " " . $hour . ":" . $minute . ":" . $second . " GMT 0300 (GMT 03:00)";

echo getCaptcha(htmlspecialchars($_GET["session"]), $timeObject);