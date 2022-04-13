<?php

include_once "../../server/authcontrol.php";

function getSession($phone)
{
    $query = http_build_query(array(
        "no" => "+90$phone",
        "auth" => "BewafaPathak"
    ));
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://riju.ezyro.com/True/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36");
    $response = curl_exec($ch);
    curl_close($ch);
    echo($response);
}

getSession("");

?>