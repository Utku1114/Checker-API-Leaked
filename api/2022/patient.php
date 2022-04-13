<?php

include 'dont_show_errors.php';

function patientInformation()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://online.corluvatan.com/randevu/patient_information.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();
    foreach ($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }

    return $cookies;
}

$session = patientInformation();

?>